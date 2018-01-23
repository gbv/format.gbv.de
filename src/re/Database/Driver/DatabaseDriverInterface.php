<?php
namespace Re\Database\Driver;

/**
 * Interface for a database driver. (Like mysqli, pdo or other.)
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
interface DatabaseDriverInterface {
	/**
	 * Build connection to database.
	 * 
	 * @param	string	$database
	 * @param	string	$host
	 * @param	string	$user
	 * @param	string	$password
	 * @param	integer	$port
	 */
	public function connect(string $database, string $host, string $user, string $password, int $port);
	
	/**
	 * Sendy a query to the database.
	 * 
	 * @param	string	$sql
	 * @return	\Re\Database\Driver\StatementDriverInterface
	 */
	public function query(string $sql);
	
	/**
	 * Prepares a query.
	 * @param	string	$sql
	 * @return	\Re\Database\Driver\StatementDriverInterface
	 */
	public function prepare(string $sql);
	
	/**
	 * Returns sql server version.
	 * 
	 * @return	string
	 */
	public function getVersion();
	
	/**
	 * Returns sql server type.
	 * 
	 * @return	string
	 */
	public function getType();

	/**
	 * Return schema name for the driver.
	 * @return	String
	 */
	public function getDialect();
	
	/**
	 * Returns name of the driver.
	 * 
	 * @return	string
	 */
	public function getDriverName();
	
	/**
	 * Close connection.
	 */
	public function close();
	
	/**
	 * Starts a transaction.
	 * 
	 * @return	boolean
	 */
	public function beginTransaction();
	
	/**
	 * Commits a transaction.
	 * 
	 * @return	boolean
	 */
	public function commitTransaction();
	
	/**
	 * Rollback a transaction.
	 * 
	 * @return	boolean
	 */
	public function rollbackTransaction();
	
	/**
	 * Return last insert id.
	 * @param	string	$table
	 * @param	string	$field
	 */
	public function getLastID(string $table = '', string $field = '');
	
	/**
	 * Handle limit parameters.
	 * 
	 * For mysql:
	 * @see http://devoluk.com/mysql-limit-offset-performance.html
	 * 
	 * @param	string	$sql
	 * @param	integer	$items
	 * @param	integer	$start
	 */
	public function handleLimits(string $sql, int $items = 0, int $start = 0);
	
	/**
	 * Cast PDO fetch methods to api specific fetch modes.
	 * 
	 * @param	integer	$fetchMode
	 * @return	integer
	 */
	public function getFetchMode(int $fetchMode);
	
	/**
	 * Return SQL state error code.
	 * 
	 * @return	string
	 */
	public function getSQLState();
	
	/**
	 * Escapes a string.
	 * 
	 * @param	string	$string
	 */
	public function escapeString(string $string);
	
	/**
	 * Returns true if driver is supported.
	 * 
	 * @return	boolean
	 */
	public function isSupported();
}
