<?php
namespace Re\Database;

use Re\Database\Driver\StatementDriverInterface;

/**
 * Represents a prepared statement.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class PreparedStatement {
	/**
	 * Driver statement object.
	 * 
	 * @var	\Re\Database\Driver\StatementDriverInterface
	 */
	protected $statement = null;
	
	/**
	 * Creates statement object.
	 * 
	 * @param	\Re\Database\Driver\StatementDriverInterface $statement
	 */
	public function __construct(StatementDriverInterface $statement) {
		$this->statement = $statement;
	}
	
	/**
	 * Bind a parameter to the statement.
	 * 
	 * @param	mixed	$name
	 * @param	mixed	$value
	 * @param	integer	$type
	 * @return	\Re\Database\PreparedStatement
	 */
	public function bindParameter($name, $value, $type = null) {
		$this->statement->bindParameter($name, $value, $type);

		return $this;
	}
	
	/**
	 * Fetch a row from the result list.
	 * 
	 * @param	integer	$type
	 * @return	mixed
	 */
	public function fetch(int $type = Database::FETCH_ASSOC) {
		return $this->statement->fetch($type);
	}
	
	/**
	 * Return all rows of the result list.
	 * 
	 * @param	integer	$type
	 * @return	array[mixed]
	 */
	public function fetchAll(int $type = Database::FETCH_ASSOC) {
		return $this->statement->fetchAll($type);
	}
	
	/**
	 * Fetch a row from the result list as a object with given class name.
	 * 
	 * @param	string	$className
	 * @return	object
	 */
	public function fetchByClass(string $className) {
		return $this->statement->fetchByClass($className);
	}
	
	/**
	 * Executes a sql command.
	 * 
	 * @param	array	$parameters
	 * @return	\Re\Database\PreparedStatement
	 */
	public function execute(array $parameters = null) {
		$this->statement->execute($parameters);

		return $this;
	}
	
	/**
	 * Return affected rows.
	 * 
	 * @return	number
	 */
	public function getAffectedRows() {
		return $this->statement->getAffectedRows();
	}
}
