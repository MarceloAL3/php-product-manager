<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    public static function connect(): PDO
    {
        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $port = $_ENV['DB_PORT'] ?? '5432';
        $name = $_ENV['DB_NAME'] ?? 'php_products';
        $user = $_ENV['DB_USER'] ?? 'postgres';
        $password = $_ENV['DB_PASSWORD'] ?? '';

        $dsn = "pgsql:host={$host};port={$port};dbname={$name}";

        try {
            return new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new PDOException(
                'Não foi possível conectar ao banco de dados.'
            );
        }
    }
}