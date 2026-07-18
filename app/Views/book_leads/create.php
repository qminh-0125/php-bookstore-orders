<?php ob_start(); ?>

<div class="form-container">
    <h2>Thêm mới Khách hàng tiềm năng</h2>
    <p class="form-subtitle">Điền thông tin chi tiết của khách hàng để lưu vào cơ sở dữ liệu.</p>

    <form method="post" action="/book-leads/store" class="form-card">
        <!-- Họ tên -->
        <div class="form-group">
            <label for="name">Họ và tên <span class="required">*</span></label>
            <input type="text" id="name" name="name" value="<?= e($old['name'] ?? '') ?>" class="<?= isset($errors['name']) ? 'input-error' : '' ?>" placeholder="Nhập họ tên đầy đủ">
            <?php if (isset($errors['name'])): ?>
                <p class="field-error-msg"><?= e($errors['name']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Địa chỉ Email <span class="required">*</span></label>
            <input type="text" id="email" name="email" value="<?= e($old['email'] ?? '') ?>" class="<?= isset($errors['email']) ? 'input-error' : '' ?>" placeholder="example@domain.com">
            <?php if (isset($errors['email'])): ?>
                <p class="field-error-msg"><?= e($errors['email']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Điện thoại -->
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" id="phone" name="phone" value="<?= e($old['phone'] ?? '') ?>" placeholder="Ví dụ: 0901234567">
        </div>

        <!-- Thể loại sách quan tâm -->
        <div class="form-group">
            <label for="preferred_genre">Thể loại sách yêu thích</label>
            <select id="preferred_genre" name="preferred_genre">
                <option value="">-- Chọn thể loại --</option>
                <?php foreach (['Novel', 'Sci-Fi', 'Comic', 'Business', 'Biography', 'Self-Help', 'History'] as $genre): ?>
                    <option value="<?= $genre ?>" <?= ($old['preferred_genre'] ?? '') === $genre ? 'selected' : '' ?>><?= $genre ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Trạng thái -->
        <div class="form-group">
            <label for="status">Trạng thái chăm sóc <span class="required">*</span></label>
            <select id="status" name="status" class="<?= isset($errors['status']) ? 'input-error' : '' ?>">
                <option value="new" <?= ($old['status'] ?? 'new') === 'new' ? 'selected' : '' ?>>Mới (New)</option>
                <option value="contacted" <?= ($old['status'] ?? '') === 'contacted' ? 'selected' : '' ?>>Đã liên hệ (Contacted)</option>
                <option value="converted" <?= ($old['status'] ?? '') === 'converted' ? 'selected' : '' ?>>Đã mua hàng (Converted)</option>
                <option value="lost" <?= ($old['status'] ?? '') === 'lost' ? 'selected' : '' ?>>Đã đóng/Không nhu cầu (Lost)</option>
            </select>
            <?php if (isset($errors['status'])): ?>
                <p class="field-error-msg"><?= e($errors['status']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Ghi chú -->
        <div class="form-group">
            <label for="note">Ghi chú chi tiết</label>
            <textarea id="note" name="note" rows="4" placeholder="Nhập ghi chú hoặc nhu cầu tìm kiếm sách cụ thể của khách hàng"><?= e($old['note'] ?? '') ?></textarea>
        </div>

        <!-- Nút thao tác -->
        <div class="form-actions">
            <button type="submit" class="btn primary">Lưu thông tin</button>
            <a href="/book-leads" class="btn secondary">Hủy bỏ</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
$title = 'Thêm Khách hàng - Bookstore App';
require __DIR__ . '/../layout.php';
?>
