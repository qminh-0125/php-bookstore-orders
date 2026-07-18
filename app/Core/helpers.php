<?php
// app/Core/helpers.php

// Chuyen cac ky tu dac biet sang thuc the HTML de chong XSS
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Chuyen huong trang
function redirect(string $path): void
{
    header("Location: {$path}");
    exit;
}

// Giu nguyen tham so GET khi sap xep va phan trang
function query_string(array $params = []): string
{
    $current = $_GET;
    foreach ($params as $key => $value) {
        $current[$key] = $value;
    }
    return http_build_query($current);
}

// Thiet lap thong bao flash
function flash_set(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

// Lay thong bao flash va xoa luon khoi session
function flash_get(string $key): ?string
{
    $message = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $message;
}

// Nap va hien thi view
function view(string $path, array $data = []): void
{
    extract($data);
    require __DIR__ . '/../Views/' . $path . '.php';
}
