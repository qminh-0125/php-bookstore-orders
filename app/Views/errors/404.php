<?php ob_start(); ?>

<div class="error-container">
    <div class="error-code">404</div>
    <h2>Không tìm thấy trang</h2>
    <p class="error-msg">Đường dẫn bạn yêu cầu không tồn tại hoặc đã bị di chuyển.</p>
    <a href="/" class="btn primary">Quay lại Dashboard</a>
</div>

<?php
$content = ob_get_clean();
$title = '404 Not Found - Lỗi';
require __DIR__ . '/../layout.php';
?>
