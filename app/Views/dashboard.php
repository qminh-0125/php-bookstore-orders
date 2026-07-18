<?php ob_start(); ?>

<div class="dashboard-hero">
    <h1>Hệ thống quản lý Mini Bookstore Order</h1>
    <p class="subtitle">Ứng dụng mẫu quản lý khách hàng tiềm năng và đơn hàng sách - Thực hành Lab 05 PHP Database CRUD</p>
</div>

<div class="dashboard-grid">
    <!-- Card 1: Database -->
    <div class="db-card">
        <div class="db-card-icon">📁</div>
        <h3>Cơ sở dữ liệu sạch</h3>
        <p>Bảng <code>users</code>, <code>book_leads</code> và <code>book_orders</code> với khóa chính, khóa ngoại, unique constraints và index tối ưu.</p>
    </div>

    <!-- Card 2: PDO Repository -->
    <div class="db-card">
        <div class="db-card-icon">🔒</div>
        <h3>PDO Repository</h3>
        <p>Prepared statements ngăn chặn SQL Injection 100%. Tách biệt câu truy vấn SQL khỏi Controller/View thông qua Repository pattern.</p>
    </div>

    <!-- Card 3: Lead CRUD -->
    <div class="db-card">
        <div class="db-card-icon">👥</div>
        <h3>Khách hàng tiềm năng</h3>
        <p>Quản lý danh sách khách hàng tìm kiếm sách, lọc theo từ khóa, phân trang mượt mà, và kiểm tra email trùng lặp thông minh.</p>
        <a href="/book-leads" class="card-btn">Quản lý Khách hàng →</a>
    </div>

    <!-- Card 4: Order CRUD -->
    <div class="db-card">
        <div class="db-card-icon">💸</div>
        <h3>Đơn hàng sách</h3>
        <p>Tạo mới đơn hàng, tự động phát hiện trùng mã đơn hàng. Sắp xếp an toàn theo Whitelist cột và chiều tăng/giảm.</p>
        <a href="/book-orders" class="card-btn">Quản lý Đơn hàng →</a>
    </div>

    <!-- Card 5: Hiệu năng -->
    <div class="db-card">
        <div class="db-card-icon">⚡</div>
        <h3>Hiệu năng tối ưu</h3>
        <p>Sử dụng chỉ mục (Index) trên các trường <code>created_at</code>, <code>status</code> và <code>email/code</code>. Kiểm tra hoạt động truy vấn qua <code>EXPLAIN</code>.</p>
    </div>
</div>

<div class="architecture-section">
    <h3>Luồng kiến trúc ứng dụng (MVC Pattern)</h3>
    <div class="flowchart">
        <span class="flow-step">Browser</span> → 
        <span class="flow-step">public/index.php</span> → 
        <span class="flow-step">Router</span> → 
        <span class="flow-step">Controller</span> → 
        <span class="flow-step">Repository</span> → 
        <span class="flow-step">PDO</span> → 
        <span class="flow-step">MySQL</span> → 
        <span class="flow-step">View/Redirect</span> → 
        <span class="flow-step">Browser</span>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Dashboard - Bookstore Order DB App';
require __DIR__ . '/layout.php';
?>
