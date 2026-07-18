<?php
// app/Controllers/HealthController.php

class HealthController
{
    // Kiem tra trang thai ket noi database, tra ve JSON
    public function index(): void
    {
        header('Content-Type: application/json');

        try {
            $config = require __DIR__ . '/../../config/database.php';
            $database = new Database($config);
            $pdo = $database->getConnection();
            $pdo->query('SELECT 1');

            echo json_encode([
                'status'   => 'ok',
                'database' => 'connected'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status'   => 'error',
                'database' => 'failed'
            ]);
        }
    }
}
