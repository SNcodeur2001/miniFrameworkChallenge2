<?php

namespace App\Config\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            // Lire les variables depuis .env
            $driver = $_ENV['DB_DRIVER'];
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $dbname = $_ENV['DB_NAME'];
            $port = $_ENV['DB_PORT'] ?? 3306;
            $user = $_ENV['DB_USER'] ?? '';
            $pass = $_ENV['DB_PASSWORD'] ?? '';

            switch ($driver) {
                case 'pgsql':
                    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
                    break;
                case 'mysql':
                    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
                    break;
                case 'sqlite':
                    $dsn = "sqlite:" . ($_ENV['DB_PATH'] ?? '');
                    $user = null;
                    $pass = null;
                    break;
                default:
                    throw new \Exception("Driver non supporté : $driver");
            }

            try {
                self::$pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
