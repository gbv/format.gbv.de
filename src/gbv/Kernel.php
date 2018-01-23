<?php
namespace GBV;

// imports
use Re\Database\Database;
use Re\Debug\Debug;

class Kernel {
	protected $baseDir = '';
	protected $db = null;

	public function __construct($baseDir = '') {
		if (empty($baseDir)) {
			$this->baseDir = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR;
		}

		// catch error and exception handler.
		Debug::catchTrapHandlers();

		// initialize database.
		$this->initDatabase();
	}

	protected function initDatabase() {
		$configFile = $this->baseDir . 'config/database.json';

		if (!file_exists($configFile)) {
			throw new \RuntimeException('Can not found config file.');
		}

		$file = file_get_contents($configFile);
		$config = json_decode($file, true);

		$database = (isset($config['database'])) ? $config['database'] : 'pica';
		$host = (isset($config['host'])) ? $config['host'] : 'localhost';
		$user = (isset($config['user'])) ? $config['user'] : 'root';
		$password = (isset($config['password'])) ? $config['password'] : '';
		$port = (isset($config['port'])) ? $config['port'] : 3306;

		$this->db = new Database($database, $host, $user, $password, $port);
	}

	public function getDB() {
		return $this->db;
	}
}