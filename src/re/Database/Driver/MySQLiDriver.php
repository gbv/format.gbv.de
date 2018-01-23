<?php
namespace Re\Database\Driver;

// imports
use Re\Database\Exception\DatabaseErrorInformation;
use Re\Database\Exception\DatabaseException;
use Re\Database\Exception\DatabaseQueryException;
use Re\Database\Database;

/**
 * Driver class for mysqli connection.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class MySQLiDriver implements DatabaseDriverInterface {
	use DatabaseDriverTrait;
	use MySQLDriverTrait;
	
	/**
	 * MySQLi object.
	 * 
	 * @var	\mysqli
	 */
	protected $mysqli = null;
	
	/**
	 * Result object for a sent query.
	 * 
	 * @var	\mysqli_result|boolean
	 */
	protected $queryResult = false;

	/**
	 * {@inheritDoc}
	 */
	public function getDriverName() {
		return 'mysqli';
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function connect(string $database, string $host, string $user, string $password, int $port) {
		// little bit tricky. MYQLI_REPORT_STRICT would not work in every »stages«. With MYSQLI_REPORT_ALL it works fine,
		// but we get index errors... not fine so, we remove the index errors.
		mysqli_report(MYSQLI_REPORT_STRICT & MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

		// set standard mysqli port
		if ($port == 0) {
			$port = 3306;
		}
		
		try {
			$this->mysqli = new \mysqli($host, $user, $password, $database, $port);
		}
		catch (\mysqli_sql_exception $e) {
			$information = new DatabaseErrorInformation($e, $this);
			throw new DatabaseException('Can not connect to database server "' . $host . '"', $information);
		}

		$this->isConnected = true;
		
		// set charset
		$this->mysqli->set_charset('utf8mb4');
		$this->mysqli->query("SET NAMES 'utf8mb4', SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY,STRICT_ALL_TABLES'");
	}
	
	/**
	 * {@inheritDoc}
	 * @throws	\Re\Database\Exception\DatabaseQueryException
	 */
	public function query(string $sql) {
		try {
			$this->queryResult = $this->mysqli->query($sql);
		}
		catch (\mysqli_sql_exception $e) {
			$information = new DatabaseErrorInformation($e, $this);
			throw new DatabaseQueryException('Can not execute query.', $information);
		}
		
		if ($this->queryResult instanceof \mysqli_result) {
			return new MySQLiSTatementDriver($sql, $this, true);
		}

		return $this->queryResult;
	}

	/**
	 * {@inheritDoc}
	 */
	public function prepare(string $sql) {
		return new MySQLiStatementDriver($sql, $this);
	}
	
	/**
	 * Special driver prepare function.
	 *
	 * @param	string	$sql
	 * @return	\mysqli_stmt
	 */
	public function driverPrepare(string $sql) {
		return $this->mysqli->prepare($sql);
	}
	
	/**
	 * Returns the mysqli result object.
	 * 
	 * 
	 * @return	\mysqli_result|boolean
	 */
	public function getResult() {
		return $this->queryResult;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function close() {
		return $this->mysqli->close();
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function beginTransaction() {
		return $this->mysqli->begin_transaction();
	}

	/**
	 * {@inheritDoc}
	 */
	public function commitTransaction() {
		return $this->mysqli->commit();
	}

	/**
	 * {@inheritDoc}
	 */
	public function rollbackTransaction() {
		return $this->mysqli->rollback();
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getLastID(string $table = null, string $field = null) {
		return $this->mysqli->insert_id;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function escapeString(string $string) {
		return $this->mysqli->real_escape_string($string);
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function handleLimits(string $sql, int $items = 0, int $start = 0) {
		return $sql . ' LIMIT ' . (($start > 0) ? intval($items) : intval($start) . ', ' . intval($items));
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getSQLState() {
		return  ($this->mysqli !== null && $this->mysqli->sqlstate != '00000') ? $this->mysqli->sqlstate : false;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getFetchMode(int $fetchMode) {
		$modes = [
			Database::FETCH_ASSOC => MYSQLI_ASSOC,
			Database::FETCH_NUM => MYSQLI_NUM,
			Database::FETCH_BOTH => MYSQLI_BOTH,
		];
		
		return (isset($modes[$fetchMode])) ? $modes[$fetchMode] : false;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function isSupported() {
		return (class_exists('\mysqli') && function_exists('mysqli_stmt_get_result'));
	}
}
