<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Bookstore Order DB App') ?></title>
    <!-- Google Fonts Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <!-- Navbar điều hướng chính -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="brand">📚 Bookstore Manager</a>
            <div class="nav-links">
                <a href="/">Dashboard</a>
                <a href="/book-leads">Khách hàng</a>
                <a href="/book-leads/create">+ Thêm Khách hàng</a>
                <a href="/book-orders">Đơn hàng sách</a>
                <a href="/book-orders/create">+ Tạo Đơn hàng</a>
                <a href="/health" target="_blank">Health DB</a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="container">
        <!-- Thông báo Flash Success -->
        <?php if ($success = flash_get('success')): ?>
            <div class="alert success-alert">
                <span class="alert-icon">✓</span>
                <span class="alert-message"><?= e($success) ?></span>
            </div>
        <?php endif; ?>

        <!-- Thông báo Flash Error -->
        <?php if ($error = flash_get('error')): ?>
            <div class="alert error-alert">
                <span class="alert-icon">✗</span>
                <span class="alert-message"><?= e($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Nội dung động của các trang con -->
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2026 Mini Bookstore Order DB App. Lab05 - Phát triển Web với PHP.</p>
    </footer>
</body>
</html>
