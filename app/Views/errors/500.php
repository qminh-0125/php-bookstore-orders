<?php ob_start(); 
// Đọc cấu hình để kiểm tra chế độ debug
$appConfig = require __DIR__ . '/../../../config/app.php';
$isDebug = $appConfig['debug'] ?? false;
?>

<div class="error-container">
    <div class="error-code">500</div>
    <h2>Đã xảy ra sự cố hệ thống (Internal Server Error)</h2>
    <p class="error-msg">Xin lỗi, chúng tôi không thể xử lý yêu cầu của bạn vào lúc này.</p>
    
    <?php if ($isDebug): ?>
        <div class="debug-panel">
            <strong>Chế độ Debug dành cho Nhà phát triển (debug = true):</strong>
            <p>Lỗi hệ thống hoặc lỗi cơ sở dữ liệu đã xảy ra. Vui lòng kiểm tra file log tại <code>storage/logs/app.log</code> để xem thông tin lỗi chi tiết.</p>
            <p>Khi đưa lên môi trường Production, hãy cấu hình <code>'debug' => false</code> trong file <code>config/app.php</code> để ẩn các lỗi kỹ thuật thô hoặc SQLSTATE đối với người dùng.</p>
        </div>
    <?php else: ?>
        <div class="production-panel">
            <p>Hệ thống đã ghi nhận lỗi kỹ thuật này. Vui lòng liên hệ với bộ phận kỹ thuật hoặc thử lại sau.</p>
        </div>
    <?php endif; ?>
    
    <a href="/" class="btn primary" style="margin-top: 25px;">Quay lại Dashboard</a>
</div>

<?php
$content = ob_get_clean();
$title = '500 Internal Server Error - Lỗi';
require __DIR__ . '/../layout.php';
?>
