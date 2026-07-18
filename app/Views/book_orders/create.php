<?php ob_start(); ?>

<div class="form-container">
    <h2>Tạo mới Đơn hàng Sách</h2>
    <p class="form-subtitle">Điền thông tin chi tiết hóa đơn mua sách của khách hàng.</p>

    <form method="post" action="/book-orders/store" class="form-card">
        <!-- Mã đơn hàng -->
        <div class="form-group">
            <label for="order_code">Mã đơn hàng <span class="required">*</span></label>
            <input type="text" id="order_code" name="order_code" value="<?= e($old['order_code'] ?? '') ?>" class="<?= isset($errors['order_code']) ? 'input-error' : '' ?>" placeholder="Ví dụ: BS-2026-0001">
            <?php if (isset($errors['order_code'])): ?>
                <p class="field-error-msg"><?= e($errors['order_code']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Tên khách hàng -->
        <div class="form-group">
            <label for="customer_name">Họ và tên khách hàng <span class="required">*</span></label>
            <input type="text" id="customer_name" name="customer_name" value="<?= e($old['customer_name'] ?? '') ?>" class="<?= isset($errors['customer_name']) ? 'input-error' : '' ?>" placeholder="Nhập tên khách hàng mua sách">
            <?php if (isset($errors['customer_name'])): ?>
                <p class="field-error-msg"><?= e($errors['customer_name']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Email khách hàng -->
        <div class="form-group">
            <label for="customer_email">Địa chỉ Email khách hàng</label>
            <input type="text" id="customer_email" name="customer_email" value="<?= e($old['customer_email'] ?? '') ?>" class="<?= isset($errors['customer_email']) ? 'input-error' : '' ?>" placeholder="customer@domain.com">
            <?php if (isset($errors['customer_email'])): ?>
                <p class="field-error-msg"><?= e($errors['customer_email']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Tổng tiền đơn hàng -->
        <div class="form-group">
            <label for="total_amount">Tổng tiền đơn hàng (VNĐ) <span class="required">*</span></label>
            <input type="number" step="1000" min="0" id="total_amount" name="total_amount" value="<?= e($old['total_amount'] ?? '0') ?>" class="<?= isset($errors['total_amount']) ? 'input-error' : '' ?>" placeholder="Ví dụ: 250000">
            <?php if (isset($errors['total_amount'])): ?>
                <p class="field-error-msg"><?= e($errors['total_amount']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Trạng thái đơn hàng -->
        <div class="form-group">
            <label for="status">Trạng thái đơn hàng <span class="required">*</span></label>
            <select id="status" name="status" class="<?= isset($errors['status']) ? 'input-error' : '' ?>">
                <option value="pending" <?= ($old['status'] ?? 'pending') === 'pending' ? 'selected' : '' ?>>Chờ thanh toán (Pending)</option>
                <option value="paid" <?= ($old['status'] ?? '') === 'paid' ? 'selected' : '' ?>>Đã thanh toán (Paid)</option>
                <option value="shipping" <?= ($old['status'] ?? '') === 'shipping' ? 'selected' : '' ?>>Đang giao hàng (Shipping)</option>
                <option value="cancelled" <?= ($old['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Đã hủy (Cancelled)</option>
            </select>
            <?php if (isset($errors['status'])): ?>
                <p class="field-error-msg"><?= e($errors['status']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Nút thao tác -->
        <div class="form-actions">
            <button type="submit" class="btn primary">Tạo đơn hàng</button>
            <a href="/book-orders" class="btn secondary">Hủy bỏ</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
$title = 'Tạo Đơn hàng - Bookstore App';
require __DIR__ . '/../layout.php';
?>
