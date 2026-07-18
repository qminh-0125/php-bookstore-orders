<?php
// app/Controllers/BookLeadController.php

class BookLeadController
{
    private function repository(): BookLeadRepository
    {
        $config = require __DIR__ . '/../../config/database.php';
        $pdo = (new Database($config))->getConnection();
        return new BookLeadRepository($pdo);
    }

    // Hien thi danh sach
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

        // Ngan chan page vuot muc gioi han lon hon totalPages
        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $perPage;
        }

        $leads = $repo->getPaginated($q, $perPage, $offset, $sort, $direction);

        view('book_leads/index', compact('leads', 'q', 'page', 'perPage', 'total', 'totalPages', 'sort', 'direction'));
    }

    // Form tao moi
    public function create(): void
    {
        $errors = [];
        $old = [
            'name'            => '',
            'email'           => '',
            'phone'           => '',
            'preferred_genre' => '',
            'status'          => 'new',
            'note'            => '',
        ];

        view('book_leads/create', compact('errors', 'old'));
    }

    // Xu ly tao moi
    public function store(): void
    {
        $result = $this->validate($_POST);
        $errors = $result['errors'];
        $old = $result['values'];

        if (!empty($errors)) {
            view('book_leads/create', compact('errors', 'old'));
            return;
        }

        try {
            $this->repository()->create($old);
            flash_set('success', 'Khách hàng tiềm năng đã được tạo thành công.');
            redirect('/book-leads');
        } catch (DuplicateRecordException $e) {
            $errors['email'] = $e->getMessage();
            view('book_leads/create', compact('errors', 'old'));
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
        $lead = $this->repository()->findById($id);

        if (!$lead) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $errors = [];
        $old = $lead;

        view('book_leads/edit', compact('errors', 'old', 'id'));
    }

    // Xu ly cap nhat
    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $repo = $this->repository();
        $lead = $repo->findById($id);
        if (!$lead) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $result = $this->validate($_POST);
        $errors = $result['errors'];
        $old = $result['values'];

        if (!empty($errors)) {
            view('book_leads/edit', compact('errors', 'old', 'id'));
            return;
        }

        try {
            $repo->update($id, $old);
            flash_set('success', 'Thông tin khách hàng đã được cập nhật thành công.');
            redirect('/book-leads');
        } catch (DuplicateRecordException $e) {
            $errors['email'] = $e->getMessage();
            view('book_leads/edit', compact('errors', 'old', 'id'));
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
            flash_set('success', 'Đã xóa khách hàng tiềm năng ra khỏi hệ thống.');
        } else {
            flash_set('error', 'Khách hàng không tồn tại hoặc đã bị xóa trước đó.');
        }

        redirect('/book-leads');
    }

    // Validate du lieu leads
    private function validate(array $input): array
    {
        $values = [
            'name'            => trim($input['name'] ?? ''),
            'email'           => trim($input['email'] ?? ''),
            'phone'           => trim($input['phone'] ?? ''),
            'preferred_genre' => trim($input['preferred_genre'] ?? ''),
            'status'          => trim($input['status'] ?? 'new'),
            'note'            => trim($input['note'] ?? ''),
        ];

        $errors = [];
        $allowedStatuses = ['new', 'contacted', 'converted', 'lost'];

        if ($values['name'] === '') {
            $errors['name'] = 'Vui lòng nhập họ tên của khách hàng.';
        }

        if ($values['email'] === '') {
            $errors['email'] = 'Vui lòng nhập địa chỉ email.';
        } elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Địa chỉ email không đúng định dạng.';
        }

        if (!in_array($values['status'], $allowedStatuses, true)) {
            $errors['status'] = 'Trạng thái chăm sóc không hợp lệ.';
        }

        return [
            'values' => $values,
            'errors' => $errors
        ];
    }
}
