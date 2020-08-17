<?php
namespace Cu\Db;

class DBContext
{
    private const USERNAME = "root";
    private const PASSWORD = "";
    private const HOST = "localhost";
    private const DBNAME = "cuongnm3_smart_osc";

    public static function getConnection($migration = false)
    {
        $username = self::USERNAME;
        $password = self::PASSWORD;
        $host = self::HOST;
        $dbName = self::DBNAME;
        if ($migration) {
            $dbName = '';
        }
        $connection = null;

        try {
            $connection = new \PDO("mysql:dbname=$dbName;host=$host", $username, $password);
        } catch (\PDOException $ex) {
            
        }

        return $connection;
    }

}

