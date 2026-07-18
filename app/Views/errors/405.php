<?php ob_start(); ?>

<div class="error-container">
    <div class="error-code">405</div>
    <h2>Phương thức không được phép (Method Not Allowed)</h2>
    <p class="error-msg">Yêu cầu HTTP gửi đến trang này sử dụng phương thức không hợp lệ.</p>
    <a href="/" class="btn primary">Quay lại Dashboard</a>
</div>

<?php
$content = ob_get_clean();
$title = '405 Method Not Allowed - Lỗi';
require __DIR__ . '/../layout.php';
?>
