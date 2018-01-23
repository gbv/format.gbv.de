<?php
namespace Re\Database\Driver;

// imports
use Re\Database\Exception\DatabaseErrorInformation;
use Re\Database\Exception\DatabaseQueryException;
use Re\Database\Database;

/**
 * PDO statement implementation.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class PDOStatementDriver implements StatementDriverInterface {
	protected $sql = '';
	protected $statement = null;
	protected $driver = null;

	/**
	 * @var string[]
	 */
	protected $parameters = [];
	
	/**
	 * Creates statement object.
	 * 
	 * @param	\PDOStatement			$statement
	 * @param	DatabaseDriverInterface	$driver
	 */
	public function __construct(\PDOStatement $statement, DatabaseDriverInterface $driver) {
		$this->statement = $statement;
		$this->driver = $driver;
		$this->sql = $this->statement->queryString;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function fetchByClass(string $className) {
		return $this->statement->fetchObject($className);
	}

	/**
	 * {@inheritDoc}
	 */
	public function fetchAll(int $type = Database::FETCH_ASSOC) {
		return $this->statement->fetchAll($type);
	}

	/**
	 * {@inheritDoc}
	 */
	public function bindParameter($name, $value = null, $type = null) {
		if (is_array($name)) {
			foreach ($name as $key => $value) {
				$this->parameters[$key] = $value;
				$this->statement->bindValue($key, $value);
			}
		}
		else {
			$this->parameters[$name] = $value;
			$this->statement->bindValue($name, $value, $type);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function fetch(int $type = Database::FETCH_ASSOC) {
		return $this->statement->fetch($type);
	}

	/**
	 * {@inheritDoc}
	 */
	public function execute(array $parameters = null) {
		try {
			$this->statement->execute($parameters);
		}
		catch (\PDOException $e) {
			$information = new DatabaseErrorInformation($e, $this->driver, $this->sql);
			throw new DatabaseQueryException('Can not execute sql statement.', $information);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAffectedRows() {
		return $this->statement->rowCount();
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
		return $this->sql;
	}
}
