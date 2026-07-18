<?php
// app/Controllers/BookOrderController.php

class BookOrderController
{
    private function repository(): BookOrderRepository
    {
        $config = require __DIR__ . '/../../config/database.php';
        $pdo = (new Database($config))->getConnection();
        return new BookOrderRepository($pdo);
    }

    // Hien thi danh sach don hang
    public function index(): void
    {
        $q = trim($_GET['q'] ?? '');
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 10;
        $sort = $_GET['sort'] ?? 'created_at';
        $direction = $_GET['direction'] ?? 'desc';
        $offset = ($page - 1) * $perPage;

        $repo = $this->repository();
        $total = $repo->countAll($q);
        $totalPages = max(1, (int) ceil($total / $perPage));

        // Ngan chan page vuot qua totalPages
        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $perPage;
        }

        $orders = $repo->getPaginated($q, $perPage, $offset, $sort, $direction);

        view('book_orders/index', compact('orders', 'q', 'page', 'perPage', 'total', 'totalPages', 'sort', 'direction'));
    }

    // Form tao moi
    public function create(): void
    {
        $errors = [];
        $old = [
            'order_code'     => '',
            'customer_name'  => '',
            'customer_email' => '',
            'total_amount'   => '0',
            'status'         => 'pending',
        ];

        view('book_orders/create', compact('errors', 'old'));
    }

    // Xu ly tao moi
    public function store(): void
    {
        $result = $this->validate($_POST);
        $errors = $result['errors'];
        $old = $result['values'];

        if (!empty($errors)) {
            view('book_orders/create', compact('errors', 'old'));
            return;
        }

        try {
            $this->repository()->create($old);
            flash_set('success', 'Đơn hàng mới đã được tạo thành công.');
            redirect('/book-orders');
        } catch (DuplicateRecordException $e) {
            $errors['order_code'] = $e->getMessage();
            view('book_orders/create', compact('errors', 'old'));
        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }

    // Form sua
    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $order = $this->repository()->findById($id);

        if (!$order) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $errors = [];
        $old = $order;

        view('book_orders/edit', compact('errors', 'old', 'id'));
    }

    // Xu ly cap nhat
    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $repo = $this->repository();
        $order = $repo->findById($id);
        if (!$order) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $result = $this->validate($_POST);
        $errors = $result['errors'];
        $old = $result['values'];

        if (!empty($errors)) {
            view('book_orders/edit', compact('errors', 'old', 'id'));
            return;
        }

        try {
            $repo->update($id, $old);
            flash_set('success', 'Đơn hàng đã được cập nhật thành công.');
            redirect('/book-orders');
        } catch (DuplicateRecordException $e) {
            $errors['order_code'] = $e->getMessage();
            view('book_orders/edit', compact('errors', 'old', 'id'));
        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }

    // Xu ly xoa bang form POST
    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $repo = $this->repository();

        if ($repo->findById($id)) {
            $repo->delete($id);
            flash_set('success', 'Đơn hàng đã được xóa thành công.');
        } else {
            flash_set('error', 'Đơn hàng không tồn tại hoặc đã bị xóa trước đó.');
        }

        redirect('/book-orders');
    }

    // Validate du lieu don hang
    private function validate(array $input): array
    {
        $values = [
            'order_code'     => trim($input['order_code'] ?? ''),
            'customer_name'  => trim($input['customer_name'] ?? ''),
            'customer_email' => trim($input['customer_email'] ?? ''),
            'total_amount'   => (float) ($input['total_amount'] ?? 0),
            'status'         => trim($input['status'] ?? 'pending'),
        ];

        $errors = [];
        $allowedStatuses = ['pending', 'paid', 'shipping', 'cancelled'];

        if ($values['order_code'] === '') {
            $errors['order_code'] = 'Vui lòng nhập mã đơn hàng.';
        }

        if ($values['customer_name'] === '') {
            $errors['customer_name'] = 'Vui lòng nhập tên khách hàng.';
        }

        if ($values['customer_email'] !== '' && !filter_var($values['customer_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['customer_email'] = 'Địa chỉ email khách hàng không đúng định dạng.';
        }

        if ($values['total_amount'] < 0) {
            $errors['total_amount'] = 'Tổng số tiền của đơn hàng không được âm.';
        }

        if (!in_array($values['status'], $allowedStatuses, true)) {
            $errors['status'] = 'Trạng thái đơn hàng không hợp lệ.';
        }

        return [
            'values' => $values,
            'errors' => $errors
        ];
    }
}
