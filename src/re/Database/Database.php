<?php
namespace Re\Database;

// imports
use Re\Database\Driver\DatabaseDriverInterface;
use Re\Database\Driver\MySQLiDriver;
use Re\Database\Driver\PDOMySQLDriver;
use Re\Database\Driver\StatementDriverInterface;
use Re\Database\Table\Table;
use Re\Debug\Debug;

/**
 * Database class.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class Database {
	// constants for database
	const FETCH_OBJECT = \PDO::FETCH_OBJ;
	const FETCH_BOTH = \PDO::FETCH_BOTH;
	const FETCH_ASSOC = \PDO::FETCH_ASSOC;
	const FETCH_NUM = \PDO::FETCH_NUM;
	const BUILD_IN_DRIVERS = [
		'PDOMySQL' => PDOMySQLDriver::class,
		'MySQLi' => MySQLiDriver::class
	];

	/**
	 * @var	string
	 */
	private $database = '';
	
	/**
	 * @var	string
	 */
	private $host = '';
	
	/**
	 * @var	string
	 */
	private $user = '';
	
	/**
	 * @var	string
	 */
	private $password = '';
	
	/**
	 * @var	integer
	 */
	private $port = 0;

	/**
	 * @var	string
	 */
	protected $driverName = '';

	/**
	 * @var	\Re\Database\Driver\DatabaseDriverInterface
	 */
	protected $driver = null;

	/**
	 * Creates database object.
	 * 
	 * @param	string	$database
	 * @param	string	$host
	 * @param	string	user
	 * @param	string	$password
	 * @param	integer	$port
	 * @param	string	$driverName
	 */
	public function __construct(string $database, string $host, string $user, string $password, int $port = 0, string $driverName = 'PDOMySQL') {
		Debug::cleanArgsFrom('__construct', static::class);

		$this->database = $database;
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->port = $port;
		$this->driverName = $driverName;

		$this->driver = static::getDriverClass($this->driverName);
		$this->connect();
	}

	/**
	 * Prepares sql query.
	 * 
	 * @param	string	$sql
	 * @return	\Re\Database\PreparedStatement
	 */
	public function prepare(string $sql) {
		return new PreparedStatement($this->driver->prepare($sql));
	}

	/**
	 * Sends a query.
	 * 
	 * @param	string	$sql
	 * @return	\Re\Database\Driver\StatementDriverInterface|bool
	 */
	public function query(string $sql) {
		$query = $this->driver->query($sql);

		if ($query instanceof StatementDriverInterface) {
			$query = new PreparedStatement($query);
		}

		return $query;
	}

	/**
	 * Starts a transaction.
	 * 
	 * @return	bool
	 */
	public function beginTransaction() {
		return $this->driver->beginTransaction();
	}

	/**
	 * Commits a transaction.
	 * 
	 * @return	bool
	 */
	public function commitTransaction() {
		return $this->driver->commitTransaction();
	}

	/**
	 * Rollback a failed transaction.
	 * 
	 * @return	bool
	 */
	public function rollbackTransaction() {
		return $this->driver->rollbackTransaction();
	}
	
	/**
	 * Handle sql limits.
	 * 
	 * @param	string	$sql
	 * @param	integer	$items
	 * @param	integer	$start
	 * @return	string
	 */
	public function handleLimits(string $sql, int $items = 0, int $start = 0) {
		return $this->driver->handleLimits($sql, $items, $start);
	}
	
	/**
	 * Escapes a string.
	 * 
	 * @param	string	$string
	 * @return	string
	 */
	public function escapeString(string $string) {
		return $this->driver->escapeString($string);
	}
	
	/**
	 * Returns database schema.
	 * 
	 * @return	string
	 */
	public function getDialect() {
		return $this->driver->getDialect();
	}

	/**
	 * Returns database version.
	 *
	 * @return	string
	 */
	public function getVersion() {
		return $this->driver->getVersion();
	}

	/**
	 * Return database type.
	 *
	 * @return	string
	 */
	public function getType() {
		return $this->driver->getType();
	}

	/**
	 * Returns table editor for creating a table.
	 *
	 * @param	$tableName
	 * @return	\Re\Database\Table\Table
	 */
	public function createTable(string $tableName) {
		return Table::create($tableName, $this);
	}

	/**
	 * Return build in drivers.
	 *
	 * @return	array[string]
	 */
	public static function getBuildInDrivers() {
		return array_keys(static::BUILD_IN_DRIVERS);
	}

	/**
	 * Check a driver.
	 * @param	string	$driverName
	 * @return	bool
	 */
	public static function isSupported(string $driverName) {
		$driver = static::getDriverClass($driverName);

		return $driver->isSupported();
	}
	
	/**
	 * Builds connection.
	 * 
	 * @throws	\RuntimeException
	 */
	protected function connect() {
		if (!$this->driver->isSupported()) {
			throw new \RuntimeException('SQL driver is not supported');
		}
		
		$this->driver->connect($this->database, $this->host, $this->user, $this->password, $this->port);
	}
	
	/**
	 * Search driver class and return it as driver object.
	 * 
	 * @param	string	$driverName
	 * @return	\Re\Database\Driver\DatabaseDriverInterface
	 * @throws	\RuntimeException
	 */
	protected static function getDriverClass(string $driverName) {
		// build in drivers
		if (isset(static::BUILD_IN_DRIVERS[$driverName])) {
			$className = static::BUILD_IN_DRIVERS[$driverName];
			
			$driver = new $className;
		}
		else {
			// driver name contains the driver class.
			$className = $driverName;
			
			if (!class_exists($className)) {
				// driver name is not a class, check standard path for a class.
				$className = __NAMESPACE__ . '\\Driver\\' . $driverName . 'Driver';
				
				if (!class_exists($className)) {
					throw new \RuntimeException('Can not find driver class "' . $className . '" for sql driver "' . $driverName . '"');
				}
			}
			
			// creates driver and check interface.
			$driver = new $className;
			if (!($driver instanceof DatabaseDriverInterface)) {
				throw new \RuntimeException('Class "' . $className . '" must implement interface "' . DatabaseDriverInterface::class . '"');
			}
		}
		
		return $driver;
	}
}
