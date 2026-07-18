<?php
// app/Core/Database.php

class Database
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['database'],
            $config['charset']
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // Nem exception khi gap loi SQL
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // Tra ve dang mang lien hop
            PDO::ATTR_EMULATE_PREPARES   => false,                    // Su dung prepared statement thuc te
        ];

        $this->pdo = new PDO($dsn, $config['username'], $config['password'], $options);
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
