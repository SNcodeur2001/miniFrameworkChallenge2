<?php
namespace App\Config\Core;

class Session
{
    private static ?Session $session = null;

    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance(): Session
    {
        if (self::$session === null) {
            self::$session = new Session();
        }
        return self::$session;
    }

    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function destroy()
    {
        session_destroy();
    }

    public function unset(string $key)
    {
        unset($_SESSION[$key]);
    }

    public function isset(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
}
