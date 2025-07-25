<?php
namespace App\Config\Core;

class App
{
    private static array $instances = [];

    public static function getDependencies(): array
    {
        if (empty(self::$instances)) {
            self::$instances['pdo'] = DatabaseFactory::createConnection();
            // Ajouter d'autres dépendances ici si besoin
        }
        return self::$instances;
    }

    public static function get(string $key)
    {
        $dependencies = self::getDependencies();
        if (!isset($dependencies[$key])) {
            throw new \Exception("Dépendance '$key' non trouvée");
        }
        return $dependencies[$key];
    }
}