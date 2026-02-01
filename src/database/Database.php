<?php


namespace Tournament\Database;

use Analog;
use Directory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Database
{
    private readonly \PDO $connection;
    public function __construct() {
        $dbPath = \Tournament\Configuration::DATABASE_FILE;
        $dbDir = pathinfo($dbPath, PATHINFO_DIRNAME);
        if (!file_exists($dbDir)) {
            mkdir($dbDir, 0777, true);
        }
        $this->connection = new \PDO("sqlite:$dbPath");
    }

    public function initialise() {
        $dbVersion = $this->getVersion();

        if($dbVersion < 1)
        {
            $this->connection->exec(file_get_contents(__DIR__ . '/v0001.sql'));
            \Analog::log("Database upgraded to version 1");
        }
    }

    public function getVersion() : int {
        $query = $this->connection->query("SELECT name FROM sqlite_master WHERE name='db_version' and type='table'");
        $tables = $query->fetchAll();

        if(count($tables) === 0) {
            return 0;
        }
        
        $query = $this->connection->query("SELECT version FROM db_version");
        $version = $query->fetch();
        
        return intval($version['version']);
    }
}
