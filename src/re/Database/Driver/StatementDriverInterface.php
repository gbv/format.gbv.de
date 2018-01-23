<?php
namespace Re\Database\Driver;

// imports
use Re\Database\Database;

/**
 * Statement driver interface.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
interface StatementDriverInterface {
	/**
	 * Bind a parameter | Binds parameters to the statement.
	 * 
	 * @param	string|array	$name
	 * @param	mixed|null		$value
	 * @param	mixed			$type
	 */
	public function bindParameter($name, $value = null, $type = null);

	/**
	 * Returns parameters for statement.
	 *
	 * @return	array
	 */
	public function getParameters();

	/**
	 * Returns query string.
	 *
	 * @return	string
	 */
	public function getQueryString();
	
	/**
	 * Binds parameters to the statement and execute it.
	 * 
	 * @param	array	$parameters
	 */
	public function execute(array $parameters = null);
	
	/**
	 * Returns a result set as given type.
	 * 
	 * @param	integer	$type
	 * @return	mixed
	 */
	public function fetch(int $type = Database::FETCH_ASSOC);
	
	/**
	 * Returns all results as given tye in array.
	 * 
	 * @param	integer	$type
	 * @return	array<mixed>
	 */
	public function fetchAll(int $type = Database::FETCH_ASSOC);
	
	/**
	 * Returns a result set as object by given class name.
	 * 
	 * @param	string	$className
	 */
	public function fetchByClass(string $className);
	
	/**
	 * Returns number of affected rows after a insert,update,delete sql command.
	 * 
	 * @return	integer
	 */
	public function getAffectedRows();
}
