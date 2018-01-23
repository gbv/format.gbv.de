<?php
namespace Re\Database\Table\Writer;

// imports
use Re\Database\Exception\TableException;
use Re\Database\Table\Field;
use Re\Database\Table\Key;
use Re\Database\Table\Table;

/**
 * MySQL writer for tables.
 *
 * @package Teralios' Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class MySQLTableWriter implements TableWriterInterface {
	/**
	 * MySQL database types.
	 *
	 * @param	string[]
	 */
	const ENGINES = ['MyISAM', 'InnoDB'];

	/**
	 * Limits for mysql tables
	 *
	 * @param	array
	 */
	const LIMITS = [
			'fields' => 1017,
			'keys' => 64,
			'keyBytes' => 767, // mysql 5.7 and later: 3072;
			'nameLength' => 64,
			'nameExpression' => '#^[@]{0,2}[\p{L}]+[\p{L}\p{N}_]+[\p{L}\p{N}]{1}$#',
			'bytesPerLetter' => 4 // uft8bm4
	];

	/**
	 * Charset for table.
	 *
	 * @var	string
	 */
	protected static $charset = 'utf8mb4';

	/**
	 * Charset for table.
	 *
	 * @var	string
	 */
	protected static $collate = 'utf8mb4_unicode_ci';

	/**
	 * Table has a fulltext index.
	 *
	 * @var	bool
	 */
	protected $fullText = false;

	/**
	 * Table has foreign keys.
	 *
	 * @var	bool
	 */
	protected $foreignKeys = false;

	/**
	 * MySQL/MariaDB version.
	 * @var	int
	 */
	protected $version = 0;

	/**
	 * Database version.
	 *
	 * @var	string
	 */
	protected $type = '';

	/**
	 * Sql commands.
	 *
	 * @var	array
	 */
	protected $commands = [];

	/**
	 * {@inheritDoc}
	 */
	public function setVersion(string $version, string $type) {
		$this->version = $version;
		$this->type = $type;
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildCommands(Table $table) {
		$fields = $table->getFields();
		$keys = $table->getKeys();
		$primary = $table->getPrimary();

		if (count($fields) <= 0) {
			throw new TableException('Table "' . $table->getName() . '" has no fields.');
		}

		/*if ($primary === null) {
			throw new TableException('Table "' . $table->getName() . '" has no primary key.');
		}*/

		// adds primary key to key array.
		if ($primary instanceof Key) {
			array_unshift($keys, $primary);
		}

		$block = array_merge($this->handleFields($fields), $this->handleKeys($keys));

		// maria db > 10.0.22 and mysql > 5.6.22 can contains fulltext index and foreign key in one table.
		if ($this->fullText && $this->foreignKeys && !$this->supportsFulltext()) {
			throw new TableException('Table "' . $table->getName() . '" can only contains fulltext index or foreign keys, not both');
		}

		/** @var	string	$sql */
		$sql = 'CREATE TABLE ' . static::escapesName($table->getName()) . "(\n\t";
		$sql .= implode(",\n\t", $block);
		$sql .= "\n)";
		$sql .= 'ENGINE=' . (($this->fullText === true && $this->supportsFullText()) ? 'InnoDB ' : 'MyISAM ');
		$sql .= 'DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';

		$this->commands[] = $sql;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getCommands() {
		return $this->commands;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLimits() {
		return self::LIMITS;
	}

	/**
	 * Build sql command for fields.
	 *
	 * @param	Field[]	$fields
	 * @return	string[]
	 */
	protected function handleFields(array $fields) {
		$rawFields = [];
		foreach ($fields as $field) {
			$sql = static::escapesName($field->getName()) . ' ';
			if ($field->getType() == 'ENUM') {
				$sql .= $field->getType() . '(' . implode(',', $field->getEnums()) . ')';
			}
			else {
				$sql .= ($field->getLength() > 0) ? ($field->getType() . '(' . $field->getLength() . ')') : $field->getType();
			}
			$sql .= ($field->getNull()) ? ' NULL' : ' NOT NULL';
			$sql .= (!$field->getDefault() || $field->isPrimaryKey()) ? '' : ' DEFAULT ' . $field->getDefault();
			$sql .= ($field->getAutoIncrement()) ? ' auto_increment' : '';
			$sql .= ($field->isPrimaryKey()) ? ' PRIMARY KEY' : '';
			$rawFields[] = $sql;
		}

		return $rawFields;
	}

	/**
	 * Builds sql command for keys.
	 *
	 * @param	Key[]	$keys
	 * @return	string[]
	 * @throws	\Re\Database\Exception\TableException
	 */
	protected function handleKeys(array $keys) {
		$rawKeys = [];
		$foreignKeys = []; // add foreign keys to the end.

		foreach ($keys as $key) {
			// primary key
			if ($key->isPrimary()) {
				$sql = 'PRIMARY KEY (';

				if ($key->isNameField()) {
					$sql .= static::escapesName($key->getName());
				}
				else {
					$sql .= implode(',', array_map([static::class, 'escapesName'], $key->getFields()));
				}

				$sql .= ')';

				$rawKeys[] = $sql;
			}
			// normal keys and fulltext keys.
			else if ($key->getType() != Key::FOREIGN && $key->getType()) {
				$sql = $key->getType();
				if ($key->isNameField()) {
					$sql .= '(' . static::escapesName($key->getName()) . ')';
				}
				else {
					$sql .= static::escapesName($key->getName()) . ' (' . implode(',', array_map([static::class, 'escapesName'], $key->getFields())) . ')';
				}

				if ($key->getType() == Key::FULLTEXT && $this->fullText == false) {
					$this->fullText = true;
				}
				$rawKeys[] = $sql;
			}
			// foreign keys.
			else {
				$field = $key->getName();
				$refTable = $key->getRefTable();
				$refField = $key->getRefField();

				if (empty($table) || empty($reField)) {
					throw new TableException('Foreign key for field "' . $field . '" needs a reference table and field');
				}

				$sql = 'FOREIGN KEY ( ' . static::escapesName($field) . ') REFERENCES ' . static::escapesName($refTable) . '(' . static::escapesName($refField) . ')';
				if ($key->getOnDelete() != Key::NOTHING) {
					$sql .= ' ON DELETE ';
					switch ($key->getOnDelete()) {
						case Key::CASCADE:
							$sql .= 'CASCADE';
							break;
						case Key::RESTRICT:
							$sql .= 'RESTRICT';
							break;
						case Key::SETNULL:
							$sql .= 'SET NULL';
					}
				}

				if ($key->onUpdate() != Key::NOTHING) {
					$sql .= ' ON UPDATE ';
					switch ($key->getOnDelete()) {
						case Key::CASCADE:
							$sql .= 'CASCADE';
							break;
						case Key::RESTRICT:
							$sql .= 'RESTRICT';
							break;
						case Key::SETNULL:
							$sql .= 'SET NULL';
					}
				}

				if ($this->foreignKeys == false) {
					$this->foreignKeys = true;
				}
				$foreignKeys[] = $sql;
			}
		}

		return array_merge($rawKeys, $foreignKeys);
	}

	/**
	 * Returns true if database supports fulltext in innodb tables.
	 *
	 * @return	bool
	 */
	protected function supportsFulltext() {
		if ($this->type == 'MariaDB') {
			return (version_compare($this->version, '10.0.22') >= 0);
		}

		return (version_compare($this->version, '5.6.22') >= 0);
	}

	/**
	 * Escapes name.
	 *
	 * @param	$name
	 * @return	string
	 */
	public static function escapesName(string $name) {
		return '`' . $name . '`';
	}
}
