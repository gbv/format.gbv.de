<?php
namespace GBV;

/**
 * Kernel
 *
 * @package		PicaHelpRest
 * @author		Karsten Achterrath <karsten.achterrath@gbv.de>
 * @copyright	©$2018 GBV VZG <https://www.gbv.de>
 * @license		GPLv3 <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class Kernel {
	/**
	 * @var	string
	 */
	protected $baseDir = '';

	/**
	 * @var	\PDO
	 */
	protected $db = null;

	/**
	 * Kernel constructor.
	 *
	 * @param	string	$baseDir
	 */
	public function __construct($baseDir = '') {
		if (empty($baseDir)) {
			$this->baseDir = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR;
		}

		// initialize database.
		$this->initDatabase();
	}

	/**
	 * Initialize Database.
	 */
	protected function initDatabase() {
		$configFile = $this->baseDir . 'config/database.json';

		if (!file_exists($configFile)) {
			throw new \RuntimeException('Can not found config file.');
		}

		$file = file_get_contents($configFile);
		$config = json_decode($file, true);

		// database information
		$database = (isset($config['database'])) ? $config['database'] : 'pica';
		$host = (isset($config['host'])) ? $config['host'] : 'localhost';
		$user = (isset($config['user'])) ? $config['user'] : 'root';
		$password = (isset($config['password'])) ? $config['password'] : '';
		$port = (isset($config['port'])) ? $config['port'] : 3306;
		$dns = 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $database;

		// mysql driver option
		$driverOptions = [
			\PDO::MYSQL_ATTR_INIT_COMMAND	=> "SET NAMES 'utf8mb4', SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY,STRICT_ALL_TABLES'",
			\PDO::ATTR_EMULATE_PREPARES		=> false,
			\PDO::ATTR_ERRMODE				=> \PDO::ERRMODE_EXCEPTION
		];

		$this->db = new \PDO($dns, $user, $password, $driverOptions);
	}

	/**
	 * Returns database class.
	 *
	 * @return \PDO
	 */
	public function getDB() {
		return $this->db;
	}
}
