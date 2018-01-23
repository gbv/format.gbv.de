<?php
namespace Re\Database\Table;

// imports
use Re\Database\Exception\TableException;
use Re\Database\Table\Writer\TableWriterInterface;
use Re\Database\Database;

/**
 * Creates or edit a table.
 *
 * @package Teralios' Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class Table {
	// limits for table.
	protected static $maxFields = 1017; // innodb
	protected static $maxKeys = 64; // innodb secondary indices.
	protected static $maxBytesForKey = 767; // innodb mysql < 5.7
	protected static $bytesPerLetter = 4; // utf8mb4
	protected static $nameLength = 64; // max length for a name
	protected static $nameRegex = '#^[@]{0,2}[\p{L}]+[\p{L}\p{N}_]+[\p{L}\p{N}]{1}$#';
	protected static $limitsSet = false;

	/**
	 * @var	string
	 */
	protected $name = '';

	/**
	 * @var	\Re\Database\Table\Field[]
	 */
	protected $fields = [];

	/**
	 * @var	\Re\Database\Table\Key[]
	 */
	protected $keys = [];

	/**
	 * @var	string
	 */
	protected $command = '';

	/**
	 * @var	int
	 */
	protected $fieldCounter = 0;

	/**
	 * @var	int
	 */
	protected $keyCounter = 0;

	/**
	 * @var	\Re\Database\Table\Key|\Re\Database\Table\Field
	 */
	protected $primaryKey = null;

	/**
	 * @var	\Re\Database\Database
	 */
	protected $database = null;

	/**
	 * @var	\Re\Database\Table\Writer\TableWriterInterface
	 */
	protected $builder = null;

	/**
	 * Table constructor.
	 *
	 * @param	string	$name
	 * @param	\Re\Database\Database	$database
	 */
	protected function __construct(string $name, Database $database) {
		static::checkName($name);

		$this->name = $name;
		$this->database = $database;
		$this->setBuilder();
	}

	/**
	 * Adds a field to table.
	 *
	 * @param	string	$name
	 * @return	\Re\Database\TAble\Field
	 * @throws	\Re\Database\Exception\TableException
	 */
	public function addField(string $name) {
		if (isset($this->fields[$name])) {
			throw new TableException('Table "' . $this->name . '" has a field "' . $name . '"');
		}

		if (($this->fieldCounter + 1) >= static::$maxFields) {
			throw new TableException('Can not add field "' . $name . '" to table. Table can only have ' . static::$maxFields . ' fields.');
		}

		$this->fields[$name] = new Field($name);
		$this->fieldCounter++;

		return $this->fields[$name];
	}

	/**
	 * Adds a key to table.
	 *
	 * @param	string	$name
	 * @param	string	$type
	 * @param	array	$fields
	 * @return	\Re\Database\Table\Key
	 * @throws	\Re\Database\Exception\TableException
	 */
	public function addKey(array $fields, string $type = Key::KEY, string $name = '') {
		// key is primary
		/*
			It is recommended to use $this->>setPrimary(fields[]) not add key.
		*/
		if ($type == Key::PRIMARY) {
			$this->setPrimary($fields);
		}

		// key ist foreign key
		if ($type == Key::FOREIGN && count($fields) > 1) {
			throw new TableException('Can not add foreign key. Foreign keys can only have one field');
		}

		// check number of keys.
		if (($this->keyCounter + 1) >= static::$maxKeys) {
			throw new TableException('Can not add "' . $type . '" to table. Table can only have ' . static::$maxKeys .' keys,');
		}

		// check fields
		$bytes = 0;
		foreach ($fields as $field) {
			if (!$this->hasField($field)) {
				throw new TableException('Table "' . $this->name . '" has no a field "' . $field . '"');
			}

			if (!$this->getField($field)->supportsKey($type)) {
				throw new TableException('Field "' . $field . '" do not supports a key from type "' . $type . '"');
			}

			$bytes += $this->getField($field)->getBytes();

			if ($bytes > static::$maxBytesForKey) {
				throw new TableException('Fields have to many bytes for a key.');
			}
		}

		// adds a key name
		if (empty($name)) {
			$name = $fields[0]; // adds first field as name.
			$i = 1;

			do {
				$check = (isset($this->keys[$name])) ?: false;
				if ($check) {
					$name .= $i;
				}
			}
			while ($check);
		}

		$this->keys[$name] = new Key($fields, $type, $name);
		$this->keyCounter++;

		return $this->keys[$name];
	}

	/**
	 * Returns true if the table has a primary key.
	 *
	 * @return bool
	 */
	public function hasPrimary() {
		return ($this->primaryKey !== null) ? true : false;
	}

	/**
	 * Adds a primary key to table.
	 *
	 * @param	string[]	$fields		Names of fields for the primary key.
	 * @return	$this
	 * @throws	\Re\Database\Exception\TableException
	 */
	public function setPrimary(array $fields) {
		if ($this->primaryKey !== null) {
			throw new TableException('Table "' . $this->name . '" has a primary key.');
		}

		if (count($fields) == 1) {
			$name = $fields[0];
			if (!$this->hasField($name)) {
				throw new TableException('Table have no field "' . $name . '" for set it as primary key.');
			}
			$this->primaryKey = $this->getField($name)->setPrimaryKey($this);

		}
		else {
			$bytes = 0;
			foreach ($fields as $field) {
				if (!$this->hasField($field)) {
					throw new TableException('Table have no field "' . $field . '" for set it as primary key.');
				}

				if (!$this->getField($field)->supportsKey('PRIMARY')) {
					throw new TableException('Field "' . $field . '" can not be a primary key');
				}

				$bytes += $this->getField($field)->getBytes();
				if ($bytes > static::$maxBytesForKey) {
					throw new TableException('Field "' . $field . '" is to large for a primary key. Current Key length: '. $bytes .' Bytes. Max bytes: ' . static::$maxBytesForKey . ' Bytes.');
				}
			}

			$this->primaryKey = new Key($fields, Key::PRIMARY);
		}

		return $this;
	}

	/**
	 * Removes primary key.
	 *
	 * @return	$this
	 */
	public function removePrimary() {
		if ($this->primaryKey === null) return $this;

		if ($this->primaryKey instanceof Field) {
			$this->primaryKey->removePrimary();
		}

		$this->primaryKey = null;

		return $this;
	}

	/**
	 * Checks that the table have a given field.
	 *
	 * @param	string	$name
	 * @return	bool
	 */
	public function hasField(string $name) {
		return isset($this->fields[$name]);
	}

	/**
	 * Get a specific field.
	 *
	 * @param	string	$name
	 * @return	\Re\Database\Table\Field
	 */
	public function getField(string $name) {
		return $this->fields[$name];
	}

	/**
	 * Returns name of table.
	 *
	 * @return	string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns fields.
	 *
	 * @return \Re\Database\Table\Field[]
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Return keys.
	 *
	 * @return \Re\Database\Table\Key[]
	 */
	public function getKeys() {
		return $this->keys;
	}

	/**
	 * Returns primary.
	 *
	 * @return \Re\Database\Table\Field|\Re\Database\Table\Key
	 */
	public function getPrimary() {
		return $this->primaryKey;
	}

	/**
	 * Creates table at database.
	 */
	public function execute() {
		$this->builder->buildCommands($this);
		$commands = $this->builder->getCommands();

		foreach ($commands as $command) {
			// todo remove debug settings in future
			echo '<pre>' . $command . '</pre>';
			//$this->database->query($command);
		}
	}

	/**
	 * Returns table for creating a table.
	 *
	 * @param	string	$name
	 * @return	\Re\Database\Table\Table
	 */
	final public static function create(string $name, Database $database) {
		return new self($name, $database);
	}

	/**
	 * Returns bytes per letter for char and vchar fields.
	 *
	 * @return	int
	 */
	final public static function getBytesPerLetter() {
		return self::$bytesPerLetter;
	}

	/**
	 * Returns max bytes for a key.
	 *
	 * @return	int
	 */
	final public static function getBytesForKey() {
		return self::$maxBytesForKey;
	}

	/**
	 * Checks given name.
	 *
	 * @param	string	$name
	 * @param	string	$type
	 */
	final public static function checkName(string $name, string $type = 'table') {
		if (!preg_match(self::$nameRegex, $name)) {
			throw new \InvalidArgumentException('Name "' . $name . '" for ' . $type . ' is invalid.');
		}
		
		if (mb_strlen($name) > self::$nameLength) {
			throw new \InvalidArgumentException('Length of name "' . $name . '" is to long.');
		}
	}

	/**
	 * Sets limits for table.
	 *
	 * @param	\Re\Database\Table\Writer\TableWriterInterface
	 */
	final public static function setLimits(TableWriterInterface $builder) {
		if (static::$limitsSet === true) {
			return;
		}

		$limits = $builder->getLimits();

		static::$maxFields = $limits['fields'];
		static::$maxBytesForKey = $limits['keyBytes'];
		static::$nameLength = $limits['nameLength'];
		static::$nameRegex = $limits['nameExpression'];
		static::$maxKeys = $limits['keys'];
		static::$bytesPerLetter = $limits['bytesPerLetter'];
		static::$limitsSet = true;
	}


	/**
	 * Sets builder.
	 */
	protected function setBuilder() {
		$builder = __NAMESPACE__ . '\\Writer\\' . $this->database->getDialect() . 'TableWriter';
		if (!class_exists($builder)) {
			throw new \RuntimeException('Can not find builder class "' . $builder . '".');
		}

		if (!is_a($builder, TableWriterInterface::class, true)) {
			throw new \RuntimeException('Builder class "' . $builder . '" must implement interface "' . TableWriterInterface::class . '"');
		}

		$this->builder = new $builder();
		$this->builder->setVersion($this->database->getVersion(), $this->database->getType());
		static::setLimits($this->builder);
	}
}
