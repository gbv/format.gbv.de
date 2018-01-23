<?php
namespace Re\Database\Driver;

// imports
use Re\Database\Exception\DatabaseErrorInformation;
use Re\Database\Exception\DatabaseException;
use Re\Database\Exception\DatabaseQueryException;
use Re\Debug\Debug;

/**
 * Abstract PDO Driver for database.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
abstract class AbstractPDODriver implements DatabaseDriverInterface {
	use DatabaseDriverTrait;
	
	/**
	 * PDO object.
	 * 
	 * @var	\PDO
	 */
	protected $pdo = null;

	public function __construct() {
		Debug::cleanArgsFrom('connect', self::class);
	}

	/**
	 * {@inheritDoc}
	 * @throws	\Re\Database\Exception\DatabaseException
	 */
	public function connect(string $database, string $host, string $user, string $password, int $port) {
		try {
			// build connection information.
			$connectionInformation = $this->buildConnectionInformation($database, $host, $port);
			$connectionString = $connectionInformation[0];
			$driverOptions = $connectionInformation[1];
			
			$this->pdo = new \PDO($connectionString, $user, $password, $driverOptions);
			$this->setAttributes();
		}
		catch (\PDOException $e) {
			$information = new DatabaseErrorInformation($e, $this);
			throw new DatabaseException('Can not connect to database server "' . $host . '"', $information);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getVersion() {
		try {
			if ($this->pdo !== null) {
				return $this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);
			}
		}
		catch (\PDOException $e) { }
		
		return 'unknown';
	}

	/**
	 * {@inheritDoc}
	 */
	public function prepare(string $sql) {
		try {
			return new PDOStatementDriver($this->pdo->prepare($sql), $this);
		}
		catch (\PDOException $e) {
			$information = new DatabaseErrorInformation($e, $this, $sql);
			throw new DatabaseQueryException('Could not prepare statement.', $information);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function query(string $sql) {
		try {
			$result = $this->pdo->query($sql);
			return ($result instanceof \PDOStatement) ? new PDOStatementDriver($result, $this) : $result;
		}
		catch (\PDOException $e) {
			$information = new DatabaseErrorInformation($e, $this, $sql);
			throw new DatabaseQueryException('Could not execute query.', $information);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLastID(string $table = null, string $field = null) {
		return $this->pdo->lastInsertId();
	}

	/**
	 * {@inheritDoc}
	 */
	public function escapeString(string $string) {
		return $this->pdo->quote($string);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getSQLState() {
		return ($this->pdo !== null) ? $this->pdo->errorCode() : 0;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFetchMode(int $fetchMode) {
		return $fetchMode;
	}

	/**
	 * {@inheritDoc}
	 */
	public function beginTransaction() {
		return $this->pdo->beginTransaction();
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function rollbackTransaction() {
		return $this->pdo->rollBack();
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getDriverName() {
		return 'PDO';
	}

	/**
	 * {@inheritDoc}
	 */
	public function commitTransaction() {
		return $this->pdo->commit();
	}

	/**
	 * {@inheritDoc}
	 */
	public function handleLimits(string $sql, int $items = 0, int $start = 0) {
		return $sql . ' LIMIT ' . intval($items) . (($start > 0) ? ' OFFSET ' . intval($start) : '');
	}

	/**
	 * Returns PDO error info.
	 *
	 * Only needed py PDODrivers ...
	 */
	public function getErrorInfo() {
		return ($this->pdo !== null) ? $this->pdo->errorInfo() : [];
	}

	/**
	 * {@inheritDoc}
	 */
	public function close() { }
	
	/**
	 * Set attributes for PDO connection.
	 */
	protected function setAttributes() {
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL);
		$this->pdo->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
	}
	
	/**
	 * {@inheritDoc}
	 */
	abstract public function isSupported();

	/**
	 * {@inheritDoc}
	 */
	abstract public function getType();
	
	/**
	 * Build array with all important connection information for pdo object.
	 * @param	string	$host
	 * @param	string	$database
	 * @param	integer	$port
	 */
	abstract protected function buildConnectionInformation(string $database, string $host, int $port);
}
