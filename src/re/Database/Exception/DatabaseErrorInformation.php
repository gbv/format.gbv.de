<?php
namespace Re\Database\Exception;

// imports
use Re\Database\Driver\DatabaseDriverInterface;

/**
 * Container class for all information of a given error.
 * 
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class DatabaseErrorInformation {
	/**
	 * @var	\Exception
	 */
	protected $e = null;
	
	/**
	 * @var	\Re\Database\Driver\DatabaseDriverInterface
	 */
	protected $driver = null;
	
	/**
	 * @var	string
	 */
	protected $sql = '';

	/**
	 * @var	int
	 */
	protected $code = null;

	/**
	 * @var	int|mixed
	 */
	protected $sqlState = null;

	/**
	 * @varq	string
	 */
	protected $message = null;
	
	/**
	 * Creates information container.
	 * 
	 * @param	\Exception																$e
	 * @param	\Re\Database\Driver\DatabaseDriverInterface|\Re\Database\Driver\AbstractPDODriver	$driver
	 * @param	string																	$sql
	 */
	public function __construct(\Exception $e, DatabaseDriverInterface $driver, string $sql = '') {
		$this->e = $e;
		$this->driver = $driver;
		$this->sql = $sql;

		if ($this->e instanceof \PDOException && $this->driver) {
			$info = $this->driver->getErrorInfo();

			if (count($info) > 0) {
				$this->sqlState = $info[0];
				$this->code = $info[1];
				$this->message = $info[2];
			}
			else {
				$message = $this->e->getMessage();
				if (preg_match('#^SQLSTATE\[(\w+)\] \[(\w+)\] (.*)$#', $message, $matches)) {
					$this->sqlState = $matches[1];
					$this->code = $matches[2];
					$this->message = $matches[3];
				}
				else {
					$this->sqlState = $this->e->getCode();
					$this->code = 0;
					$this->message = $this->e->getMessage();
				}
			}
		}
	}
	
	/**
	 * Returns error code.
	 * 
	 * @return	integer
	 */
	public function getCode() {
		return ($this->code !== null) ? $this->code : $this->e->getCode();
	}
	
	/**
	 * Returns error message.
	 * 
	 * @return	string
	 */
	public function getMessage() {
		return ($this->message !== null) ? $this->message : $this->e->getMessage();
	}
	
	/**
	 * Returns database type.
	 * 
	 * @return	string
	 */
	public function getType() {
		return $this->driver->getType();
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
	 * Returns driver name.
	 * 
	 * @return	string
	 */
	public function getDriverName() {
		return $this->driver->getDriverName();
	}
	
	/**
	 * Returns server version.
	 * 
	 * @return	string
	 */
	public function getVersion() {
		return $this->driver->getVersion();
	}
	
	/**
	 * Returns query.
	 * 
	 * @return	string
	 */
	public function getQuery() {
		return $this->sql;
	}
	
	/**
	 * Returns sql error state.
	 * 
	 * @return	string
	 */
	public function getSQLState() {
		return ($this->sqlState !== null) ? $this->sqlState : $this->driver->getSQLState();
	}
}
