<?php declare(strict_types=1);

namespace GBV\PicaHelp;

use PDOStatement;

/**
 * Database connection to format database.
 *
 * @package     PicaHelp
 * @author      Karsten Achterrath <karsten.achterrath@gbv.de>
 * @copyright   GBV VZG <https://www.gbv.de>
 * @license     GPLv3 <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class Database
{
    /**
     * @var \PDO
     */
    private $db;

    /**
     * Initialize Database.
     */
    public function __construct(array $config = [])
    {
        $database = $config['database'] ?? 'pica';
        $host = $config['host'] ?? 'localhost';
        $user = $config['user'] ?? 'root';
        $password = $config['password'] ?? '';
        $port = $config['port'] ?? 3306;
        $dns = 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $database;

        $this->db = new \PDO($dns, $user, $password, [
            \PDO::MYSQL_ATTR_INIT_COMMAND =>
                "SET NAMES 'utf8mb4', SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY,STRICT_ALL_TABLES'",
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }

    /**
     * Execute an SQL statement.
     */
    public function query(string $statement, array $parameters = null): PDOStatement
    {
        if ($parameters) {
            $statement = $this->db->prepare($statement);
            $statement->execute($parameters);
        } else {
            $statement = $this->db->query($statement);
        }
        return $statement;
    }
}
