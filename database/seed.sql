USE bookstore_order_db;

-- Xóa dữ liệu cũ nếu có
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE users;
TRUNCATE TABLE book_leads;
TRUNCATE TABLE book_orders;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Chèn dữ liệu mẫu cho bảng users
INSERT INTO users (name, email, password_hash, role, status) VALUES
('Quản trị viên', 'admin@bookstore.com', '$2y$10$examplehashadmin12345', 'admin', 'active'),
('Nhân viên bán hàng', 'staff@bookstore.com', '$2y$10$examplehashstaff12345', 'staff', 'active');

-- 2. Chèn ít nhất 15 bản ghi cho bảng book_leads (khách hàng tiềm năng quan tâm đến sách)
INSERT INTO book_leads (name, email, phone, preferred_genre, status, note, created_at) VALUES
('Nguyễn Văn A', 'nguyenvana@example.com', '0901234567', 'Novel', 'new', 'Quan tâm tiểu thuyết trinh thám mới', '2026-06-01 08:30:00'),
('Trần Thị B', 'tranthib@example.com', '0902345678', 'Sci-Fi', 'contacted', 'Đã gửi danh mục sách khoa học viễn tưởng', '2026-06-02 09:15:00'),
('Lê Văn C', 'levanc@example.com', '0903456789', 'Comic', 'converted', 'Đã chuyển thành khách hàng mua bộ truyện tranh Conan', '2026-06-03 10:00:00'),
('Phạm Thị D', 'phamthid@example.com', '0904567890', 'Business', 'lost', 'Không có nhu cầu mua thêm sách kinh tế', '2026-06-04 11:45:00'),
('Hoàng Văn E', 'hoangvane@example.com', '0905678901', 'Novel', 'new', 'Tìm kiếm tiểu thuyết lịch sử', '2026-06-05 14:20:00'),
('Vũ Thị F', 'vuthif@example.com', '0906789012', 'Biography', 'contacted', 'Quan tâm sách tiểu sử danh nhân', '2026-06-06 15:30:00'),
('Đỗ Văn G', 'dovang@example.com', '0907890123', 'Sci-Fi', 'new', 'Hỏi về sách Du hành thời gian', '2026-06-07 16:10:00'),
('Bùi Thị H', 'buithih@example.com', '0908901234', 'Self-Help', 'contacted', 'Tư vấn sách kỹ năng sống cho sinh viên', '2026-06-08 08:45:00'),
('Tăng Văn I', 'tangvani@example.com', '0909012345', 'Novel', 'converted', 'Đã mua bộ tiểu thuyết của Haruki Murakami', '2026-06-09 10:30:00'),
('Phan Thị K', 'phanthik@example.com', '0912345678', 'History', 'new', 'Muốn tìm sách lịch sử Việt Nam thế kỷ 20', '2026-06-10 11:15:00'),
('Lý Văn L', 'lyvanl@example.com', '0913456789', 'Comic', 'new', 'Hỏi lịch phát hành Manga tuần này', '2026-06-11 13:00:00'),
('Dương Thị M', 'duongthim@example.com', '0914567890', 'Business', 'contacted', 'Đã tư vấn sách quản trị kinh doanh khởi nghiệp', '2026-06-12 14:50:00'),
('Ngô Văn N', 'ngovann@example.com', '0915678901', 'Biography', 'converted', 'Đã mua cuốn tự truyện Steve Jobs', '2026-06-13 16:25:00'),
('Trịnh Thị O', 'trinhthio@example.com', '0916789012', 'Self-Help', 'lost', 'Hủy đăng ký nhận bản tin khuyến mãi', '2026-06-14 09:05:00'),
('Đặng Văn P', 'dangvanp@example.com', '0917890123', 'Comic', 'new', 'Đăng ký nhận tin tức truyện tranh Marvel', '2026-06-15 10:40:00'),
('Lâm Thị Q', 'lamthiq@example.com', '0918901234', 'Novel', 'contacted', 'Quan tâm tiểu thuyết lãng mạn', '2026-06-16 11:20:00');

-- 3. Chèn ít nhất 15 bản ghi cho bảng book_orders (đơn hàng sách)
INSERT INTO book_orders (order_code, customer_name, customer_email, total_amount, status, created_at) VALUES
('BS-2026-0001', 'Nguyễn Văn A', 'nguyenvana@example.com', 250000.00, 'paid', '2026-06-01 09:00:00'),
('BS-2026-0002', 'Lê Văn C', 'levanc@example.com', 450000.00, 'shipping', '2026-06-03 10:30:00'),
('BS-2026-0003', 'Tăng Văn I', 'tangvani@example.com', 890000.00, 'paid', '2026-06-09 11:00:00'),
('BS-2026-0004', 'Ngô Văn N', 'ngovann@example.com', 180000.00, 'pending', '2026-06-13 17:00:00'),
('BS-2026-0005', 'Trần Thị B', 'tranthib@example.com', 320000.00, 'cancelled', '2026-06-15 08:30:00'),
('BS-2026-0006', 'Phạm Thị D', 'phamthid@example.com', 150000.00, 'paid', '2026-06-16 14:00:00'),
('BS-2026-0007', 'Hoàng Văn E', 'hoangvane@example.com', 270000.00, 'pending', '2026-06-17 15:30:00'),
('BS-2026-0008', 'Vũ Thị F', 'vuthif@example.com', 560000.00, 'shipping', '2026-06-18 10:15:00'),
('BS-2026-0009', 'Đỗ Văn G', 'dovang@example.com', 95000.00, 'pending', '2026-06-19 11:40:00'),
('BS-2026-0010', 'Bùi Thị H', 'buithih@example.com', 640000.00, 'paid', '2026-06-20 09:20:00'),
('BS-2026-0011', 'Phan Thị K', 'phanthik@example.com', 120000.00, 'shipping', '2026-06-21 13:50:00'),
('BS-2026-0012', 'Lý Văn L', 'lyvanl@example.com', 380000.00, 'paid', '2026-06-22 14:15:00'),
('BS-2026-0013', 'Dương Thị M', 'duongthim@example.com', 750000.00, 'cancelled', '2026-06-23 16:00:00'),
('BS-2026-0014', 'Trịnh Thị O', 'trinhthio@example.com', 220000.00, 'pending', '2026-06-24 10:00:00'),
('BS-2026-0015', 'Đặng Văn P', 'dangvanp@example.com', 430000.00, 'paid', '2026-06-25 15:45:00'),
('BS-2026-0016', 'Lâm Thị Q', 'lamthiq@example.com', 310000.00, 'shipping', '2026-06-26 11:30:00');
