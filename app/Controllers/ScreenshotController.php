<?php
// app/Controllers/ScreenshotController.php

class ScreenshotController
{
    
    // Giả lập giao diện báo lỗi trùng email của Leads
    
    public function duplicateLead(): void
    {
        $errors = [
            'email' => 'Email này đã tồn tại trong hệ thống. Vui lòng dùng email khác.'
        ];
        $old = [
            'name'            => 'Anna Duplicate',
            'email'           => 'anna@example.com',
            'phone'           => '0909000099',
            'preferred_genre' => 'Novel',
            'status'          => 'new',
            'note'            => 'Em muốn được tư vấn lại',
        ];
        view('book_leads/create', compact('errors', 'old'));
    }

    
    // Giả lập giao diện báo lỗi trùng mã đơn hàng
     
    public function duplicateOrder(): void
    {
        $errors = [
            'order_code' => 'Mã đơn hàng này đã tồn tại trong hệ thống. Vui lòng nhập mã khác.'
        ];
        $old = [
            'order_code'     => 'BS-2026-0001',
            'customer_name'  => 'Nguyễn Văn A',
            'customer_email' => 'nguyenvana@example.com',
            'total_amount'   => 250000,
            'status'         => 'pending',
        ];
        view('book_orders/create', compact('errors', 'old'));
    }

    // Giả lập giao diện lỗi 500 an toàn ở chế độ Production (debug = false)
     
    public function safeError(): void
    {
        // Ghi đè hiển thị dạng production để chụp ảnh
        $content = '';
        ob_start();
        ?>
        <div class="error-container">
            <div class="error-code">500</div>
            <h2>Đã xảy ra sự cố hệ thống (Internal Server Error)</h2>
            <p class="error-msg">Xin lỗi, chúng tôi không thể xử lý yêu cầu của bạn vào lúc này.</p>
            <div class="production-panel">
                <p>Hệ thống đã ghi nhận lỗi kỹ thuật này. Vui lòng liên hệ với bộ phận kỹ thuật hoặc thử lại sau.</p>
            </div>
            <a href="/" class="btn primary" style="margin-top: 25px;">Quay lại Dashboard</a>
        </div>
        <?php
        $content = ob_get_clean();
        $title = '500 Internal Server Error - Lỗi';
        require __DIR__ . '/../Views/layout.php';
    }
}
