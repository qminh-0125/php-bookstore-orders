<?php ob_start(); ?>

<div class="page-header">
    <h2>Quản lý Khách hàng tiềm năng</h2>
    <a href="/book-leads/create" class="btn primary">+ Thêm Khách hàng</a>
</div>

<!-- Thanh công cụ tìm kiếm và lọc -->
<div class="toolbar-card">
    <form method="get" action="/book-leads" class="search-form">
        <!-- Đặt trang mặc định là 1 khi thực hiện tìm kiếm mới -->
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="sort" value="<?= e($sort) ?>">
        <input type="hidden" name="direction" value="<?= e($direction) ?>">
        
        <div class="search-input-group">
            <input type="text" name="q" value="<?= e($q) ?>" placeholder="Tìm kiếm theo Tên, Email, Điện thoại, Thể loại sách..." class="search-input">
            <button type="submit" class="btn btn-search">Tìm kiếm</button>
            <?php if ($q !== ''): ?>
                <a href="/book-leads" class="btn btn-clear">Xóa lọc</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Bảng dữ liệu khách hàng -->
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>
                    <a href="/book-leads?<?= e(query_string(['sort' => 'id', 'direction' => ($sort === 'id' && $direction === 'asc') ? 'desc' : 'asc'])) ?>">
                        ID <?= $sort === 'id' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="/book-leads?<?= e(query_string(['sort' => 'name', 'direction' => ($sort === 'name' && $direction === 'asc' ? 'desc' : 'asc')])) ?>">
                        Tên Khách hàng <?= $sort === 'name' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="/book-leads?<?= e(query_string(['sort' => 'email', 'direction' => ($sort === 'email' && $direction === 'asc' ? 'desc' : 'asc')])) ?>">
                        Email <?= $sort === 'email' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>Điện thoại</th>
                <th>
                    <a href="/book-leads?<?= e(query_string(['sort' => 'preferred_genre', 'direction' => ($sort === 'preferred_genre' && $direction === 'asc' ? 'desc' : 'asc')])) ?>">
                        Thể loại yêu thích <?= $sort === 'preferred_genre' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="/book-leads?<?= e(query_string(['sort' => 'status', 'direction' => ($sort === 'status' && $direction === 'asc' ? 'desc' : 'asc')])) ?>">
                        Trạng thái <?= $sort === 'status' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="/book-leads?<?= e(query_string(['sort' => 'created_at', 'direction' => ($sort === 'created_at' && $direction === 'asc' ? 'desc' : 'asc')])) ?>">
                        Ngày tạo <?= $sort === 'created_at' ? ($direction === 'asc' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($leads)): ?>
                <tr>
                    <td colspan="8" class="text-center">Không tìm thấy khách hàng tiềm năng nào phù hợp.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($leads as $lead): ?>
                    <tr>
                        <td><?= e($lead['id']) ?></td>
                        <td class="font-semibold"><?= e($lead['name']) ?></td>
                        <td><?= e($lead['email']) ?></td>
                        <td><?= e($lead['phone'] ?: '-') ?></td>
                        <td><span class="genre-badge"><?= e($lead['preferred_genre'] ?: '-') ?></span></td>
                        <td>
                            <?php
                            $statusMap = [
                                'new'       => ['label' => 'Mới', 'class' => 'status-new'],
                                'contacted' => ['label' => 'Đã liên hệ', 'class' => 'status-contacted'],
                                'converted' => ['label' => 'Đã mua hàng', 'class' => 'status-converted'],
                                'lost'      => ['label' => 'Đã đóng', 'class' => 'status-lost'],
                            ];
                            $statusInfo = $statusMap[$lead['status']] ?? ['label' => $lead['status'], 'class' => ''];
                            ?>
                            <span class="badge <?= $statusInfo['class'] ?>"><?= e($statusInfo['label']) ?></span>
                        </td>
                        <td class="text-muted"><?= e(date('d/m/Y H:i', strtotime($lead['created_at']))) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="/book-leads/edit?id=<?= e($lead['id']) ?>" class="btn-action edit-btn">Sửa</a>
                                
                                <form method="post" action="/book-leads/delete" class="inline-form" onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng <?= e($lead['name']) ?> không? Hành động này không thể hoàn tác!')">
                                    <input type="hidden" name="id" value="<?= e($lead['id']) ?>">
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
            Hiển thị bản ghi từ <strong><?= (($page - 1) * $perPage) + 1 ?></strong> đến <strong><?= min($page * $perPage, $total) ?></strong> trong tổng số <strong><?= $total ?></strong> khách hàng.
        </div>
        <div class="pagination-buttons">
            <?php if ($page > 1): ?>
                <a href="/book-leads?<?= e(query_string(['page' => $page - 1])) ?>" class="btn-page">« Trước</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="/book-leads?<?= e(query_string(['page' => $i])) ?>" class="btn-page <?= $page === $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="/book-leads?<?= e(query_string(['page' => $page + 1])) ?>" class="btn-page">Sau »</a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
$title = 'Quản lý Khách hàng - Bookstore App';
require __DIR__ . '/../layout.php';
?>
