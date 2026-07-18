-- Tạo Database cho ứng dụng Bookstore
CREATE DATABASE IF NOT EXISTS bookstore_order_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE bookstore_order_db;

-- 1. Bảng users: Lưu thông tin tài khoản nhân viên/quản trị viên hệ thống
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Bảng book_leads: Khách hàng tiềm năng quan tâm đến sách
CREATE TABLE IF NOT EXISTS book_leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30),
    preferred_genre VARCHAR(50), -- Thể loại sách khách hàng quan tâm (ví dụ: Novel, Sci-Fi, Comic...)
    status VARCHAR(30) NOT NULL DEFAULT 'new', -- Trạng thái chăm sóc: new, contacted, converted, lost
    note TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,
    UNIQUE KEY unique_lead_email (email), -- Ràng buộc duy nhất email để tránh trùng leads
    INDEX idx_leads_created_at (created_at), -- Index để tăng tốc lọc và sắp xếp theo thời gian
    INDEX idx_leads_status_created_at (status, created_at), -- Index phức hợp hỗ trợ tìm kiếm theo trạng thái + sắp xếp
    INDEX idx_leads_phone (phone) -- Index phục vụ tìm kiếm theo số điện thoại
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Bảng book_orders: Đơn hàng sách
CREATE TABLE IF NOT EXISTS book_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(50) NOT NULL, -- Mã đơn hàng sách dạng BS-2026-XXXX
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(150) NOT NULL,
    total_amount DECIMAL(12,2) NOT NULL DEFAULT 0, -- Tổng tiền đơn hàng
    status VARCHAR(30) NOT NULL DEFAULT 'pending', -- Trạng thái đơn hàng: pending, paid, shipping, cancelled
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,
    UNIQUE KEY unique_order_code (order_code), -- Ràng buộc duy nhất mã đơn hàng để chống trùng lắp
    INDEX idx_orders_created_at (created_at), -- Index hỗ trợ phân trang và sắp xếp theo ngày tạo
    INDEX idx_orders_status_created_at (status, created_at), -- Index phức hợp hỗ trợ tìm kiếm status + sắp xếp ngày tạo
    INDEX idx_orders_customer_email (customer_email) -- Index phục vụ tìm kiếm theo email khách hàng
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
