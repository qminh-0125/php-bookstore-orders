<?php ob_start(); ?>

<div class="page-header">
    <h2>Quản lý Đơn hàng Sách</h2>
    <a href="/book-orders/create" class="btn primary">+ Tạo Đơn hàng</a>
</div>

<!-- Thanh công cụ tìm kiếm và lọc -->
<div class="toolbar-card">
    <form method="get" action="/book-orders" class="search-form">
        <!-- Đặt trang mặc định là 1 khi tìm kiếm mới -->
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="sort" value="<?= e($sort) ?>">
        <input type="hidden" name="direction" value="<?= e($direction) ?>">
        
        <div class="search-input-group">
            <input type="text" name="q" value="<?= e($q) ?>" placeholder="Tìm theo Mã đơn hàng, Tên khách hàng, Email..." class="search-input">
            <button type="submit" class="btn btn-search">Tìm kiếm</button>
            <?php if ($q !== ''): ?>
                <a href="/book-orders" class="btn btn-clear">Xóa lọc</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Bảng dữ liệu đơn hàng -->
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>
                    <a href="/book-orders?<?= e(query_string(['sort' => 'id', 'direction' => ($sort === 'id' && $direction === 'asc') ? 'desc' : 'asc'])) ?>">
                        ID <?= $sort === 'id' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="/book-orders?<?= e(query_string(['sort' => 'order_code', 'direction' => ($sort === 'order_code' && $direction === 'asc') ? 'desc' : 'asc'])) ?>">
                        Mã đơn hàng <?= $sort === 'order_code' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="/book-orders?<?= e(query_string(['sort' => 'customer_name', 'direction' => ($sort === 'customer_name' && $direction === 'asc') ? 'desc' : 'asc'])) ?>">
                        Khách hàng <?= $sort === 'customer_name' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="/book-orders?<?= e(query_string(['sort' => 'customer_email', 'direction' => ($sort === 'customer_email' && $direction === 'asc') ? 'desc' : 'asc'])) ?>">
                        Email <?= $sort === 'customer_email' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="/book-orders?<?= e(query_string(['sort' => 'total_amount', 'direction' => ($sort === 'total_amount' && $direction === 'asc') ? 'desc' : 'asc'])) ?>">
                        Tổng tiền (VNĐ) <?= $sort === 'total_amount' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="/book-orders?<?= e(query_string(['sort' => 'status', 'direction' => ($sort === 'status' && $direction === 'asc') ? 'desc' : 'asc'])) ?>">
                        Trạng thái <?= $sort === 'status' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="/book-orders?<?= e(query_string(['sort' => 'created_at', 'direction' => ($sort === 'created_at' && $direction === 'asc') ? 'desc' : 'asc'])) ?>">
                        Ngày tạo <?= $sort === 'created_at' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="8" class="text-center">Không tìm thấy đơn hàng nào phù hợp.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= e($order['id']) ?></td>
                        <td class="font-semibold text-primary"><?= e($order['order_code']) ?></td>
                        <td><?= e($order['customer_name']) ?></td>
                        <td><?= e($order['customer_email'] ?: '-') ?></td>
                        <td class="font-semibold text-right"><?= e(number_format($order['total_amount'], 0, ',', '.')) ?> VNĐ</td>
                        <td>
                            <?php
                            $statusMap = [
                                'pending'   => ['label' => 'Chờ thanh toán', 'class' => 'status-pending'],
                                'paid'      => ['label' => 'Đã thanh toán', 'class' => 'status-paid'],
                                'shipping'  => ['label' => 'Đang giao hàng', 'class' => 'status-shipping'],
                                'cancelled' => ['label' => 'Đã hủy đơn', 'class' => 'status-lost'],
                            ];
                            $statusInfo = $statusMap[$order['status']] ?? ['label' => $order['status'], 'class' => ''];
                            ?>
                            <span class="badge <?= $statusInfo['class'] ?>"><?= e($statusInfo['label']) ?></span>
                        </td>
                        <td class="text-muted"><?= e(date('d/m/Y H:i', strtotime($order['created_at']))) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="/book-orders/edit?id=<?= e($order['id']) ?>" class="btn-action edit-btn">Sửa</a>
                                
                                <form method="post" action="/book-orders/delete" class="inline-form" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng <?= e($order['order_code']) ?> không? Hành động này không thể hoàn tác!')">
                                    <input type="hidden" name="id" value="<?= e($order['id']) ?>">
                                    <button type="submit" class="btn-action delete-btn">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Phân trang -->
<?php if ($totalPages > 1): ?>
    <div class="pagination-container">
        <div class="pagination-info">
            Hiển thị bản ghi từ <strong><?= (($page - 1) * $perPage) + 1 ?></strong> đến <strong><?= min($page * $perPage, $total) ?></strong> trong tổng số <strong><?= $total ?></strong> đơn hàng.
        </div>
        <div class="pagination-buttons">
            <?php if ($page > 1): ?>
                <a href="/book-orders?<?= e(query_string(['page' => $page - 1])) ?>" class="btn-page">« Trước</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="/book-orders?<?= e(query_string(['page' => $i])) ?>" class="btn-page <?= $page === $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="/book-orders?<?= e(query_string(['page' => $page + 1])) ?>" class="btn-page">Sau »</a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
$title = 'Quản lý Đơn hàng - Bookstore App';
require __DIR__ . '/../layout.php';
?>
