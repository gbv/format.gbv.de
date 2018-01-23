<?php
namespace Re\Database\Driver;

// imports
use Re\Database\Database;

/**
 * Trait for mysql drivers.
 *
 * MySQL and MariaDB are used as equivalent.
 * We must check server type and version numbers for some functions like:
 *
 * fulltext index for innodb.
 *
 * @package Teralios Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
trait MySQLDriverTrait {
	/**
	 * SQL Table.
	 *
	 * @var	string
	 */
	protected $dialect = 'MySQL';

	/**
	 * SQL Server.
	 *
	 * MariaDB or MySQL
	 *
	 * @var	string
	 */
	protected $type = 'MySQL';

	/**
	 * Server version
	 *
	 * @var	string
	 */
	protected $version = null;

	/**
	 * Driver is connected to database.
	 *
	 * @var	bool
	 */
	protected $isConnected = false;

	/**
	 * Returns server type.
	 *
	 * @return	string
	 */
	public function getType() {
		$this->getVersion();

		return $this->type;
	}

	/**
	 * Returns version string.
	 *
	 * @return	string
	 */
	public function getVersion() {
		if ($this->version !== null) {
			return $this->version;
		}

		if ($this->isConnected === true) {
			try {
				$sql = 'SELECT VERSION()';
				$statement = $this->query($sql);

				/** @var	StatementDriverInterface	$statement */
				$version = $statement->fetch(Database::FETCH_NUM);
				$this->version = $this->parseVersion($version[0]);

				return $this->version;
			}
			catch (\Exception $e) {
				return 'unknown';
			}
		}

		return 'unknown';
	}

	/**
	 * Returns sql schema.
	 *
	 * @return	string
	 */
	public function getDialect() {
		return $this->dialect;
	}

	/**
	 * Parse version string.
	 *
	 * @param	$version
	 * @return	string
	 */
	protected function parseVersion(string $version) {
		if (strpos($version, 'MariaDB')) {
			$this->type = 'MariaDB';
		}

		return preg_replace('#^(\d+\.\d+\.\d+).*$#', '$1', $version);
	}
}
