<?php
namespace App\Config\Core;

class DatabaseFactory
{
    public static function createConnection(): \PDO
    {
        $driver = DB_DRIVER;
        $host = DB_HOST;
        $dbname = DB_NAME;
        $port = DB_PORT;
        $user = DB_USER;
        $pass = DB_PASSWORD;

        switch ($driver) {
            case 'pgsql':
                $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
                break;
            case 'mysql':
                $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
                break;
            case 'sqlite':
                $dsn = "sqlite:" . DB_PATH;
                $user = null;
                $pass = null;
                break;
            default:
                throw new \Exception("Driver non supporté : $driver");
        }

        return new \PDO($dsn, $user, $pass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }
}