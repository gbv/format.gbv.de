<?php
namespace Re\Database\Table;

/**
 * Represents a Key.
 *
 * Call table method addKey.
 *
 * @package Teralios' Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class Key {
	const KEY = 'KEY';
	const PRIMARY = 'PRIMARY KEY';
	const UNIQUE = 'UNIQUE KEY';
	const FOREIGN = 'FOREIGN KEY';
	const FULLTEXT = 'FULLTEXT';
	const CASCADE = 0;
	const RESTRICT = 1;
	const NOTHING = 2;
	const SETNULL = 3;

	/**
	 * @var	string
	 */
	protected $name = '';

	/**
	 * @var	bool
	 */
	protected $nameIsField = false;

	/**
	 * @var	string[]
	 */
	protected $fields = [];

	/**
	 * @var	string
	 */
	protected $refTable = '';

	/**
	 * @var	string
	 */
	protected $refField = '';

	/**
	 * @var	int
	 */
	protected $onDelete = self::CASCADE;

	/**
	 * @var	int
	 */
	protected $onUpdate = self::NOTHING;

	/**
	 * Key constructor.
	 *
	 * @param	string[]	$fields
	 * @param	string		$type
	 * @param	string	$name
	 */
	public function __construct(array $fields, string $type = self::KEY, string $name = '') {
		if (!empty($name)) Table::checkName($name, 'Key');

		$this->name = $name;
		$this->fields = $fields;
		$this->type = $type;
	}

	/**
	 * Set table for foreign key.
	 *
	 * @param	string	$table
	 * @return	$this
	 */
	public function toTable(string $table) {
		if ($this->type != self::FOREIGN) {
			return $this;
		}

		Table::checkName($table, 'Table');
		$this->refTable = $table;

		return $this;
	}

	/**
	 * Set field for foreign key.
	 *
	 * @param	string	$field
	 * @return	$this
	 */
	public function toField(string $field) {
		if ($this->type != self::FOREIGN) {
			return $this;
		}

		Table::checkName($field, 'Field');
		$this->refField = $field;

		return $this;
	}

	/**
	 * Set mode for delete.
	 *
	 * @param	int	$mode
	 * @return	$this
	 */
	public function setOnDelete(int $mode = self::CASCADE) {
		if ($this->type != self::FOREIGN) {
			return $this;
		}

		$this->onDelete = $mode;

		return $this;
	}

	/**
	 * Set mode for update.
	 *
	 * @param	int	$mode
	 * @return	$this
	 */
	public function setOnUpdate(int $mode = self::CASCADE) {
		if ($this->type != self::FOREIGN) {
			return $this;
		}

		$this->onUpdate = $mode;

		return $this;
	}

	/**
	 * Return type of key.
	 *
	 * @return	string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Key is primary key.
	 *
	 * @return	bool
	 */
	public function isPrimary() {
		return ($this->type == self::PRIMARY) ?: false;
	}

	/**
	 * Returns name of key.
	 *
	 * @return	string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Get reference table name.
	 *
	 * @return	string
	 */
	public function getRefTable() {
		return $this->refTable;
	}

	/**
	 * Get reference field.
	 *
	 * @return	string
	 */
	public function getRefField() {
		return $this->refField;
	}

	/**
	 * Return foreign key status.
	 *
	 * @return	int
	 */
	public function getOnDelete() {
		return $this->onDelete;
	}

	/**
	 * Return foreign key status.
	 *
	 * @return	int
	 */
	public function getOnUpdate() {
		return $this->onUpdate;
	}

	/**
	 * Return fields.
	 *
	 * @return	string[]
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Name is also field.
	 *
	 * @return	bool
	 */
	public function isNameField() {
		return $this->nameIsField;
	}
}
