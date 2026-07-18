<?php
// public/index.php

// Khởi chạy session để hỗ trợ thông báo flash
session_start();

// Nạp các file cốt lõi
require_once __DIR__ . '/../app/Core/helpers.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/DuplicateRecordException.php';

// Nạp các Repository
require_once __DIR__ . '/../app/Repositories/BookLeadRepository.php';
require_once __DIR__ . '/../app/Repositories/BookOrderRepository.php';

// Nạp các Controller
require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/HealthController.php';
require_once __DIR__ . '/../app/Controllers/BookLeadController.php';
require_once __DIR__ . '/../app/Controllers/BookOrderController.php';

// Nạp cấu hình ứng dụng để bật/tắt hiển thị lỗi
$appConfig = require __DIR__ . '/../config/app.php';
if ($appConfig['debug']) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(0);
}

// Cấu hình đường dẫn ghi log lỗi mặc định của PHP vào storage/logs/app.log
$logDir = __DIR__ . '/../storage/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}
ini_set('log_errors', '1');
ini_set('error_log', $logDir . '/app.log');

// Khởi tạo Router và định nghĩa các tuyến đường (routes)
$router = new Router();

// --- Các tuyến đường Dashboard & Health Check ---
$router->get('/', [HomeController::class, 'index']);
$router->get('/health', [HealthController::class, 'index']);

// --- Các tuyến đường Quản lý Khách hàng tiềm năng (Book Leads) ---
$router->get('/book-leads', [BookLeadController::class, 'index']);
$router->get('/book-leads/create', [BookLeadController::class, 'create']);
$router->post('/book-leads/store', [BookLeadController::class, 'store']);
$router->get('/book-leads/edit', [BookLeadController::class, 'edit']);
$router->post('/book-leads/update', [BookLeadController::class, 'update']);
$router->post('/book-leads/delete', [BookLeadController::class, 'delete']);

// --- Các tuyến đường Quản lý Đơn hàng Sách (Book Orders) ---
$router->get('/book-orders', [BookOrderController::class, 'index']);
$router->get('/book-orders/create', [BookOrderController::class, 'create']);
$router->post('/book-orders/store', [BookOrderController::class, 'store']);
$router->get('/book-orders/edit', [BookOrderController::class, 'edit']);
$router->post('/book-orders/update', [BookOrderController::class, 'update']);
$router->post('/book-orders/delete', [BookOrderController::class, 'delete']);


// Thực thi định tuyến dựa trên REQUEST_METHOD và REQUEST_URI hiện tại
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
