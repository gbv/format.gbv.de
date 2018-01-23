<?php
namespace Re\Database\Table;

// imports
use Re\Database\Exception\TableException;

class Field {
	/**
	 * Contains all supported types.
	 *
	 * @var	array[mixed]
	 */
	const TYPES = [
			// integers
			'TINYINT' => [
					'length' => 3,
					'bytes' => 1,
					'auto_increment' => true,
					'key' => ['unique', 'primary', 'key']
			],
			
			'SMALLINT' => [
					'length' => 5,
					'bytes' => 2,
					'auto_increment' => true,
					'key' => ['unique', 'primary', 'key']
			],
			
			'MEDIUMINT' => [
					'length' => 7,
					'bytes' => 3,
					'auto_increment' => true,
					'key' => ['unique', 'primary', 'key']
			],
			
			'INT' => [
					'length' => 10,
					'bytes' => 4,
					'auto_increment' => true,
					'key' => ['unique', 'primary', 'key']
			],
	
			'BIGINT' => [
					'length' => 19,
					'bytes' => 8,
					'auto_increment' => true,
					'key' => ['unique', 'primary', 'key']
			],
				
			// decimal numbers
			'FLOAT' => [
					'length' => 65,
					'bytes' => 4,
					'key' => ['unique', 'primary', 'key']
			],

			'DOUBLE' => [
					'length' => 65,
					'bytes' => 8,
					'key' => ['unique', 'primary', 'key']
			],

			// bit masks
			'BIT' => [
					'length' => 64,
					'bytes' => -1,
					'key' => ['unique', 'primary', 'key']
			],
			
			// date types (not supported yet)
			
			// strings (BLOB yet)
			'CHAR' => [
					'length' => 255,
					'bytes' => -1,
					'key' => ['unique', 'primary', 'key', 'fulltext']
			],
			
			'VARCHAR' => [
					'length' => 65535,
					'bytes' => -1,
					'auto_increment' => false,
					'key' => ['unique', 'primary', 'key', 'fulltext']
			],
			
			'BINARY' => [
					'length' => 255,
					'bytes' => -1,
					'key' => ['unique', 'primary', 'key']
			],
			
			'VARBINARY' => [
					'length' => 65535,
					'bytes' => -1,
					'auto_increment' => false,
					'key' => ['unique', 'primary', 'key']
			],
			
			'TINYTEXT' => [
					'no_default' => true,
					'key' => ['fulltext'],
			],
			
			'TEXT' => [
					'no_default' => true,
					'key' => ['fulltext'],
			],
			
			'MEDIUMTEXT' => [
					'no_default' => true,
					'key' => ['fulltext'],
			],
			
			'LARGETEXT' => [
					'no_default' => true,
					'key' => ['fulltext'],
			],
			
			'ENUM' => [
					'parameters' => true,
					'key' => false // enum and keys are tricky. Not supported here.
			]
	];
	
	// field information
	/**
	 * @var	string
	 */
	protected $name = '';

	/**
	 * @var	string
	 */
	protected $type = '';

	/**
	 * @var	int
	 */
	protected $length = 0;

	/**
	 * @var	int
	 */
	protected $length2 = 0;

	/**
	 * @var	bool
	 */
	protected $autoIncrement = false;

	/**
	 * @var	bool
	 */
	protected $isPrimary = false;

	/**
	 * @var	bool
	 */
	protected $null = false;

	/**
	 * @var	mixed
	 */
	protected $default = false;

	/**
	 * @var	array
	 */
	protected $enum = [];

	/**
	 * Contains information from field constant for field type.
	 * @var	array
	 */
	protected $information= [];

	// setter methods for the field.
	/**
	 * Field constructor.
	 * @param	string	$name
	 */
	public function __construct(string $name) {
		Table::checkName($name, 'field');

		$this->name = $name;
	}

	/**
	 * Set field type.
	 *
	 * @param	string	$type
	 * @return	$this
	 * @throws	TableException
	 */
	public function setType(string $type) {
		$this->type = strtoupper($type);

		if (!isset(static::TYPES[$this->type])) {
			throw new TableException('Field not supports type "' . $this->type . '"');
		}

		$this->information = static::TYPES[$this->type];

		return $this;
	}

	/**
	 * Set length for field.
	 *
	 * @param	int	$length
	 * @param	int	$length2
	 * @return	$this
	 * @throws	\Re\Database\Exception\TableException
	 */
	public function setLength(int $length, int $length2 = 0) {
		if (!isset($this->information['length'])) {
			throw new TableException($this->name . '[' . $this->type . '] not supports length settings');
		}

		$maxLength = $this->information['length'];

		// float and double needs two »length« parameters.,
		if (($this->type == 'FLOAT' || $this->type == 'DOUBLE')) {
			if ($length <= 0 || $length2 <= 0) {
				throw new TableException($this->name . '[' . $this->type . '] needs length and length2 setting');
			}

			if (($length + $length2) > $maxLength) {
				throw new TableException('Combined length from length and lenght2 ' . ($length + $length2) . ' is to long. Max length: ' . $maxLength);
			}
		}
		else {
			if ($length <= 0 || $length > $maxLength) {
				throw new TableException('Length must be between 1 and ' . $maxLength . '. Length: ' . $length);
			}

			$this->length = $length;
		}
		return $this;
	}

	/**
	 * Set "NULL" for field. Default is NOT NULL.
	 *
	 * @return	$this
	 */
	public function setNull() {
		$this->null = true;

		return $this;
	}

	/**
	 * Set field to auto_increment.
	 *
	 * @return	$this
	 * @throws	\Re\Database\Exception\TableException
	 */
	public function setAutoIncrement() {
		if (!isset($this->information['auto_increment']) || $this->information['auto_increment'] === false) {
			throw new TableException($this->name . '[' . $this->type . '] not supported auto increment.');
		}
		$this->autoIncrement = true;

		return $this;
	}

	/**
	 * Sets the field to primary key.
	 *
	 * Call this method not directly.
	 * Use: $table->setPrimary(['fieldName']).
	 *
	 * @param	\Re\Database\Table\Table	$table
	 * @return	$this
	 * @throws	\Re\Database\Exception\TableException
	 * @internal
	 */
	public function setPrimaryKey(Table $table) {
		if ($this->length <= 0) {
			throw new TableException('No length found for field "' . $this->name . '". First set a length.');
		}

		if (!isset($this->information['key']) || !in_array('primary', $this->information['key'])) {
			throw new TableException($this->name . '[' . $this->type . '] can not be a primary key.');
		}

		$bytes = ($this->information['bytes'] == -1) ? $this->calcBytes($this->length, $this->type) : $this->information['bytes'];

		if ($bytes > Table::getBytesForKey()) {
			throw new TableException($this->name . '[' . $this->type . '] is to long for a key. Length: ' . $bytes . ' Bytes. Max Bytes per Key: ' . Table::getBytesForKey() . ' Bytes');
		}

		if ($table->hasPrimary()) {
			throw new TableException('Table ' . $table->getName() . ' has a primary key.');
		}

		$this->isPrimary = true;

		return $this;
	}

	/**
	 * Removes primary attribute from field.
	 *
	 * Call this method not directly.
	 * Use: $table->removePrimary();
	 * Or: $table->addPrimary(['newFieldName']);
	 *
	 * @return	$this
	 * @internal
	 */
	public function removePrimary() {
		$this->isPrimary = false;

		return $this;
	}

	/**
	 * @param	mixed	$default
	 * @return	$this
	 * @throws	\Re\Database\Exception\TableException
	 */
	public function setDefault($default) {
		if (isset($this->information['no_default']) && $this->information['no_default'] === true) {
			throw new TableException($this->name . '[' . $this->type . '] not support a default value.');
		}

		if ($this->type == 'ENUM') {
			if (count($this->enum) == 0) {
				throw new TableException($this->name . '[' . $this->type . '] have no enum values.');
			}

			if (!in_array($default, $this->enum)) {
				throw new TableException('Can not found "' . $default . '" in enum values.');
			}
		}

		$this->default = $default;

		return $this;
	}

	/**
	 * Set enum variables for field.
	 *
	 * @param	string[] ...$params	$field->setEnum('value1', 'value2');
	 * @return	$this
	 * @throws	\Re\Database\Exception\TableException
	 */
	public function setEnum(...$params) {
		if ($this->type != 'ENUM') {
			throw new TableException($this->name . '[' . $this->type . '] must be from type ENUM.');
		}

		if (count($params) <= 1) {
			throw new TableException($this->name . '[' . $this->type . '] needs more then one enum value.');
		}

		$this->enum = $params;

		return $this;
	}

	// getters for writer

	/**
	 * Returns name.
	 *
	 * @return	string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns type.
	 *
	 * @return	string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Returns null status.
	 *
	 * @return	bool
	 */
	public function getNull() {
		return $this->null;
	}

	/**
	 * Returns default value.
	 *
	 * @return	mixed
	 */
	public function getDefault() {
		if (is_string($this->default)) return "'" . $this->default . "'";

		return $this->default;
	}

	/**
	 * Field is primary key.
	 *
	 * @return	bool
	 */
	public function isPrimaryKey() {
		return $this->isPrimary;
	}

	/**
	 * Return values for enum fields.
	 *
	 * @return	array
	 */
	public function getEnums() {
		$addsQuote = function ($item) {
			return "'" . $item . "'";
		};

		return array_map($addsQuote, $this->enum);
	}

	/**
	 * Returns length.
	 *
	 * @return	int|string
	 */
	public function getLength() {
		if ($this->length > 0 && $this->length2 > 0 && ($this->type == 'FLOAT' || $this->type == 'DOUBLE')) {
			return $this->length . ',' . $this->length2;
		}

		return $this->length;
	}

	/**
	 * Field has a auto_increment attribute.
	 *
	 * @return	bool
	 */
	public function getAutoIncrement() {
		return $this->autoIncrement;
	}

	/**
	 * Field supports given key.
	 *
	 * @param	string	$key
	 * @return	bool
	 */
	public function supportsKey(string $key) {
		$key = explode(' ', strtolower($key));
		$key = $key[0];

		return (isset($this->information['key']) && in_array($key, $this->information['key'])) ? true : false;
	}

	/**
	 * Returns bytes for calculate the key length.
	 *
	 * @return	int|bool
	 */
	public function getBytes() {
		if (isset($this->information['bytes'])) {
			return ($this->information['bytes'] == -1) ? $this->calcBytes($this->length, $this->type) : $this->information['bytes'];
		}

		return false;
	}

	/**
	 * Calculate bytes.
	 *
	 * @param	int		$length
	 * @param	string	$field
	 * @return	int
	 */
	protected function calcBytes(int $length, string $field = 'CHAR') {
		if ($field == 'BIT') return (int) round(($length / 8), 0);
		
		$bytesPerLetter = Table::getBytesPerLetter();
		
		return (int) round($length * $bytesPerLetter, 0);
	}
}
