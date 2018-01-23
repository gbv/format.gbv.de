<?php
namespace Re\Database\Driver;

/**
 * PDO MySQL driver.
 *
 * @package Teralios' Web Publisher
 * @author Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license GPLv3
 */
class PDOMySQLDriver extends AbstractPDODriver {
	use MySQLDriverTrait;

	/**
	 * {@inheritDoc}
	 */
	public function isSupported() {
		return (extension_loaded('PDO') && extension_loaded('pdo_mysql'));
	}

	/**
	 * {@inheritDoc}
	 */
	protected function setAttributes() {
		parent::setAttributes();
		
		$this->pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
		$this->isConnected = true;
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function buildConnectionInformation(string $database, string $host, int $port) {
		// set standard mysqli port
		if ($port == 0) {
			$port = 3306;
		}

		$driverOptions = [
			\PDO::MYSQL_ATTR_INIT_COMMAND	=> "SET NAMES 'utf8mb4', SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY,STRICT_ALL_TABLES'",
			\PDO::ATTR_EMULATE_PREPARES		=> false,
			\PDO::ATTR_ERRMODE				=> \PDO::ERRMODE_EXCEPTION
		];
		
		$connectionString = 'mysql:host='.$host.';port='.$port.';dbname='.$database;
		
		return [$connectionString, $driverOptions];
	}
}
