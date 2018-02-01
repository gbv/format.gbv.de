<?php declare(strict_types=1);

namespace GBV;

class DB extends \DB\SQL
{
    public function __construct(string $configFile)
    {
        $config = $this->loadConfig($configFile);

        $database = $config['database'] ?? 'pica';
        $host = $config['host'] ?? 'localhost';
        $user = $config['user'] ?? 'root';
        $password = $config['password'] ?? '';
        $port = $config['port'] ?? 3306;
        $dns = 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $database;

        parent::__construct($dns, $user, $password, [
            \PDO::MYSQL_ATTR_INIT_COMMAND =>
                "SET NAMES 'utf8mb4', SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY,STRICT_ALL_TABLES'",
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }

    protected function loadConfig($configFile)
    {
        $config = [];
        if (file_exists($configFile)) {
            $fileContent = file_get_contents($configFile);
            $config = json_decode($fileContent, true);
        }

        return $config['database'] ?? [];
    }
}
