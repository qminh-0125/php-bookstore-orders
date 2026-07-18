# Quản Lý Khách Hàng Tiềm Năng & Đơn Hàng Sách (Mini Bookstore Order DB App)

Dự án thực hành môn Phát triển Web bằng PHP & MySQL (Lab 5), sử dụng cấu trúc thuần MVC (Model-View-Controller) tự xây dựng không phụ thuộc Framework bên ngoài.

---

## Yêu Cầu Hệ Thống (System Requirements)
*   PHP: Phiên bản 8.x trở lên.
*   MySQL / MariaDB: Phiên bản 8.x trở lên.
*   Web Server: Apache hoặc Nginx (Laragon được khuyến khích sử dụng trên Windows).

---

## Hướng Dẫn Cài Đặt và Chạy Dự Án

### Bước 1: Thiết lập Cơ sở dữ liệu
1. Mở phần mềm quản lý MySQL (ví dụ: HeidiSQL, phpMyAdmin, DBeaver).
2. Tạo mới một cơ sở dữ liệu có tên chính xác là:
   ```sql
   CREATE DATABASE bookstore_order_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
3. Import lần lượt 2 file SQL mẫu nằm trong thư mục database/ của dự án theo thứ tự:
   *   database/schema.sql: Tạo cấu trúc các bảng (users, book_leads, book_orders) va thiết lập các ràng buộc, chỉ mục tối ưu.
   *   database/seed.sql: Chèn dữ liệu mẫu (> 15 bản ghi mỗi bảng) để hiển thị và test phân trang.

---

### Bước 2: Cấu hình Kết nối Cơ sở dữ liệu
1. Mở tệp tin cấu hình database tại đường dẫn: config/database.php.
2. Chỉnh sửa thông tin kết nối phù hợp với môi trường local của bạn (Host, Tên đăng nhập, Mật khẩu):
   ```php
   return [
       'host'     => '127.0.0.1', // Khuyên dùng IP thay vì localhost trên Windows để tránh lỗi phân giải IPv6
       'database' => 'bookstore_order_db',
       'username' => 'root',      // Username MySQL của bạn
       'password' => '',          // Password MySQL của bạn
       'charset'  => 'utf8mb4'
   ];
   ```

---

### Bước 3: Chạy ứng dụng trên môi trường Local

#### Cách 1: Sử dụng Laragon (Khuyến khích)
1. Copy toàn bộ thư mục dự án php-bookstore-orders vào thư mục ảo của Laragon: C:\laragon\www\.
2. Mở Laragon nhấn Start All.
3. Truy cập đường dẫn: http://php-bookstore-orders.test/ trên trình duyệt để sử dụng.

#### Cách 2: Sử dụng PHP Built-in Server
1. Mở cửa sổ dòng lệnh (Terminal / PowerShell) và trỏ thẳng vào thư mục php-bookstore-orders/.
2. Khởi động Web Server tích hợp của PHP bằng lệnh:
   ```bash
   php -S 127.0.0.1:8000 -t public
   ```
3. Mở trình duyệt và truy cập: http://127.0.0.1:8000

---

## Cấu Trúc Mã Nguồn (MVC Folder Structure)
```bash
php-bookstore-orders/
├── app/
│   ├── Controllers/   # Tiếp nhận request và xử lý logic luồng điều hướng
│   ├── Core/          # Bộ lõi gồm Database Connection, Router, helpers
│   ├── Repositories/  # Kết nối CSDL thông qua PDO Prepared Statements
│   └── Views/         # Giao diện hiển thị HTML (Dashboard, Leads, Orders)
├── config/            # Cấu hình hệ thống (app.php, database.php)
├── database/          # File schema.sql và seed.sql của CSDL
├── public/            # File khởi chạy chính index.php và các assets CSS/JS
└── storage/           # Nơi lưu vết lỗi hệ thống (logs/app.log) ở chế độ Production
```

---

## Các Tính Năng An Toàn Đã Triển Khai
1.  Prepared Statements: Chống lỗi tấn công SQL Injection trong toàn bộ các truy vấn thêm/sửa/đọc dữ liệu.
2.  Whitelist Sorting: Chống SQL Injection gián tiếp qua các tham số URL sort và direction trong phân trang.
3.  Database Constraints: Khóa Unique Key ở tầng database ngăn ngừa trùng lặp dữ liệu do lỗi bất đồng bộ (Race Condition).
4.  PRG Pattern: Áp dụng luồng Post-Redirect-Get tránh hiện tượng gửi lặp dữ liệu (Resubmit Form) khi nhấn F5.
5.  POST Delete: Hành động xóa chỉ được chấp nhận bằng phương thức POST kèm theo hộp thoại xác nhận JavaScript.
6.  Production Debug Mode: Ẩn hoàn toàn mã lỗi CSDL thô (SQLSTATE) ở chế độ production và tự động ghi log lỗi vào storage/logs/app.log.
