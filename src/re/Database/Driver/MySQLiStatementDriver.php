<?php
namespace Re\Database\Driver;

// imports
use Re\Database\Exception\DatabaseErrorInformation;
use Re\Database\Exception\DatabaseQueryException;
use Re\Database\Database;

/**
 * MySQLi Prepared Statement and Result object.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class MySQLiStatementDriver implements StatementDriverInterface {
	/**
	 * Sql query.
	 * 
	 * @var	string
	 */
	protected $sql = '';
	
	/**
	 * Contains origin sql query.
	 * 
	 * MySQLi not supported named parameters, so we must cast them to ?.
	 * 
	 * @var	string
	 */
	protected $originSql = '';
	
	/**
	 * @var	\Re\Database\Driver\MySQLiDriver
	 */
	protected $driver = null;
	
	/**
	 * MySQLi statement object.
	 * 
	 * @var	\mysqli_stmt
	 */
	protected $statement = null;
	
	/**
	 * MySQLi result object.
	 * 
	 * @var	\mysqli_result
	 */
	protected $result = false;
	/**
	 * Mapped named parameters to numbered parameters.
	 * 
	 * @var	array
	 */
	protected $namedToNumber = [];
	
	/**
	 * Contains parameters for mysqli statement.
	 * 
	 * @var	array
	 */
	protected $parameters = [];
	
	/**
	 * Number of set parameters.
	 * 
	 * @var	integer
	 */
	protected $countParameters = 1;
	
	/**
	 * Creates statement object.
	 * 
	 * @param	string					$sql
	 * @param	DatabaseDriverInterface	$driver
	 * @param	boolean					$fromQuery
	 * @throws	\Re\Database\Exception\DatabaseQueryException
	 */
	public function __construct(string $sql, DatabaseDriverInterface $driver, bool $fromQuery = false) {
		$this->originSql = $sql;
		$this->driver = $driver;
		
		if ($fromQuery == false) {
			$this->prepareNamedStatement($sql);
			
			try {
				$this->statement = $this->driver->driverPrepare($this->sql);
			}
			catch (\mysqli_sql_exception $e) {
				$information = new DatabaseErrorInformation($e, $this->driver, $this->originSql);
				throw new DatabaseQueryException('Could not prepare statement.', $information);
			}
		}
		else {
			$this->sql = $sql;
			$this->result = $this->driver->getResult();
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function bindParameter($name, $value = null, $type = null) {
		if ($this->statement === null) return;
		
		// bind parameter array.
		if (is_array($name)) {
			foreach ($name as $key => $value) {
				$this->bindParameter($key, $value);
			}

			return;
		}

		// named parameter.
		if (is_string($name)) {
			if (!isset($this->namedToNumber[$name])) {
				throw new \DomainException('Can not find named parameter "' . $name . '" in query: ' . $this->originSql);
			}
			$name = $this->namedToNumber[$name];
		}
		
		// type (mysqli use type flags.)
		$type = 's';
		if (is_integer($value)) $type = 'i';
		if (is_float($value)) $type = 'd';
		
		$this->parameters[$name] = [$type, $value];
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function fetchByClass(string $className) {
		$object = $this->result->fetch_object($className);

		return $object;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function fetchAll(int $mode = Database::FETCH_ASSOC) {
		$items = [];
		
		if (Database::FETCH_OBJECT) {
			while ($object = $this->result->fetch_object()) {
				$items[] = $object;
			}
		}
		else {
			$items = $this->result->fetch_all($this->driver->getFetchMode($mode));
		}
		
		return $items;
	}

	/**
	 * {@inheritDoc}
	 */
	public function fetch(int $mode = Database::FETCH_ASSOC) {
		switch ($mode) {
			case Database::FETCH_OBJECT:
				return $this->result->fetch_object();
			case Database::FETCH_ASSOC:
				return $this->result->fetch_assoc();
			case Database::FETCH_NUM:
				return $this->result->fetch_row();
			case Database::FETCH_BOTH:
				return $this->result->fetch_array(MYSQLI_BOTH);
		}

		return $this->result->fetch_array(MYSQLI_ASSOC);
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function execute(array $parameters = null) {
		if ($this->statement === null) return false;
		
		// free mysqli result.
		if ($this->result !== false) {
			$this->result->free();
			$this->result = false;
		}
		
		// Prepare given parameters.
		if ($parameters !== null) {
			$this->bindParameter($parameters);
		}
		
		// bind given parameters.
		if (count($this->parameters)) {
			$typeString = '';
			$parameters = [];
			
			foreach ($this->parameters as $no => $value) {
				$typeString .= $value[0];
				$parameters[] = $value[1];
			}
			
			$this->statement->bind_param($typeString, ...$parameters);
		}
		
		// execute statement.
		try {
			$this->statement->execute();
			
			if ($this->statement->result_metadata() !== null) {
				$this->result = $this->statement->get_result();
			}
			
			// reset parameters.
			$this->resetParameters();
		}
		catch (\mysqli_sql_exception $e) {
			$information = new DatabaseErrorInformation($e, $this->driver, $this->originSql);
			throw new DatabaseQueryException('Could not execute statement.', $information);
		}

		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAffectedRows() {
		return ($this->statement === null) ? false : $this->statement->affected_rows;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getParameters() {
		return $this->parameters;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getQueryString() {
		return $this->originSql;
	}
	
	/**
	 * Destructs prepared statement. Is needed for mysqli.
	 */
	public function __destruct() {
		$this->close();
	}

	/**
	 * Find named parameter flags and replace it with a question mark (?).
	 * @param	string	$sql
	 */
	protected function prepareNamedStatement(string $sql) {
		if (preg_match('#:[\w]+#', $sql)) {
			$sql = preg_replace_callback('#:([\w]+)#', [$this, 'parseNamedParameter'], $sql);
		}
		
		$this->sql = $sql;
	}
	
	/**
	 * Build named to number table.
	 * 
	 * @param	array<string>	$match
	 * @return	string
	 */
	protected function parseNamedParameter(array $match) {
		$this->namedToNumber[$match[1]] = $this->countParameters;
		++$this->countParameters;
		
		return '?';
	}
	
	/**
	 * Reset parameters.
	 */
	protected function resetParameters() {
		$this->parameters = [];
		$this->countParameters = 1;
	}
	
	/**
	 * Close the mysqli statement.
	 */
	protected function close() {
		if ($this->result !== false) {
			$this->result->free();
		}
		
		if ($this->statement !== null) {
			$this->statement->free_result();
			$this->statement->close();
		}
	}
}
