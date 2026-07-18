<?php
// app/Repositories/BookLeadRepository.php

class BookLeadRepository
{
    public function __construct(private PDO $db) {}

    // Dem tong so lead phuc vu phan trang
    public function countAll(string $keyword = ''): int
    {
        $sql = "SELECT COUNT(*) AS total FROM book_leads";
        $params = [];

        if ($keyword !== '') {
            $sql .= " WHERE name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword OR preferred_genre LIKE :keyword";
            $params['keyword'] = '%' . $keyword . '%';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    // Lay danh sach lead phan trang va sap xep an toan
    public function getPaginated(string $keyword, int $limit, int $offset, string $sort, string $direction): array
    {
        // Whitelist cot va chieu sap xep de chong SQL Injection
        $allowedSorts = ['id', 'name', 'email', 'phone', 'preferred_genre', 'status', 'created_at'];
        $allowedDirections = ['asc', 'desc'];

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        if (!in_array(strtolower($direction), $allowedDirections, true)) {
            $direction = 'desc';
        }

        $sql = "SELECT id, name, email, phone, preferred_genre, status, created_at FROM book_leads";
        $params = [];

        if ($keyword !== '') {
            $sql .= " WHERE name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword OR preferred_genre LIKE :keyword";
            $params['keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY {$sort} {$direction} LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
        }

        // Bind bat buoc kieu INT khi tat EMULATE_PREPARES
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM book_leads WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO book_leads (name, email, phone, preferred_genre, status, note) 
                VALUES (:name, :email, :phone, :preferred_genre, :status, :note)";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'name'            => $data['name'],
                'email'           => $data['email'],
                'phone'           => $data['phone'] ?: null,
                'preferred_genre' => $data['preferred_genre'] ?: null,
                'status'          => $data['status'],
                'note'            => $data['note'] ?: null,
            ]);
        } catch (PDOException $e) {
            // Bat loi trung lap unique email (ma loi 1062 o MySQL)
            if (($e->errorInfo[1] ?? null) === 1062) {
                throw new DuplicateRecordException('Email này đã tồn tại trong hệ thống. Vui lòng dùng email khác.');
            }
            throw $e;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE book_leads 
                SET name = :name, email = :email, phone = :phone, preferred_genre = :preferred_genre, 
                    status = :status, note = :note, updated_at = NOW() 
                WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'id'              => $id,
                'name'            => $data['name'],
                'email'           => $data['email'],
                'phone'           => $data['phone'] ?: null,
                'preferred_genre' => $data['preferred_genre'] ?: null,
                'status'          => $data['status'],
                'note'            => $data['note'] ?: null,
            ]);
        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {
                throw new DuplicateRecordException('Email này đã tồn tại trong hệ thống. Vui lòng dùng email khác.');
            }
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM book_leads WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
