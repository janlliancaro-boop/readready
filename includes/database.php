<?php
require_once __DIR__ . '/config.php';

class Database
{
    private mysqli $conn;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
        if ($this->conn->connect_error) {
            throw new RuntimeException('Database connection failed: ' . $this->conn->connect_error);
        }

        $this->conn->query('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        $this->conn->select_db(DB_NAME);

        $this->initializeSchema();
        $this->seedData();
    }

    public function getConnection(): mysqli
    {
        return $this->conn;
    }

    private function initializeSchema(): void
    {
        $schemaPath = __DIR__ . '/../db/schema.sql';
        if (!file_exists($schemaPath)) {
            return;
        }

        $schemaSql = file_get_contents($schemaPath);
        if ($schemaSql === false || trim($schemaSql) === '') {
            return;
        }

        $this->conn->multi_query($schemaSql);
        do {
            if ($result = $this->conn->store_result()) {
                $result->free();
            }
        } while ($this->conn->next_result());
    }

    private function seedData(): void
    {
        $seedPath = __DIR__ . '/../db/seed.sql';
        if (!file_exists($seedPath)) {
            $this->ensureDefaultAdmin();
            return;
        }

        $seedSql = file_get_contents($seedPath);
        if ($seedSql === false || trim($seedSql) === '') {
            $this->ensureDefaultAdmin();
            return;
        }

        $this->conn->multi_query($seedSql);
        do {
            if ($result = $this->conn->store_result()) {
                $result->free();
            }
        } while ($this->conn->next_result());

        $this->ensureDefaultAdmin();
    }

    private function ensureDefaultAdmin(): void
    {
        $check = $this->conn->prepare('SELECT id FROM admins WHERE username = ? LIMIT 1');
        $check->bind_param('s', $username);
        $username = ADMIN_DEFAULT_USERNAME;
        $check->execute();
        $result = $check->get_result();

        if ($result && $result->num_rows > 0) {
            $check->close();
            return;
        }
        $check->close();

        $passwordHash = password_hash(ADMIN_DEFAULT_PASSWORD, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare('INSERT INTO admins (username, password_hash, full_name, role, status) VALUES (?, ?, ?, ?, ?)');
        $fullName = 'System Administrator';
        $role = 'super_admin';
        $status = 'active';
        $stmt->bind_param('sssss', ADMIN_DEFAULT_USERNAME, $passwordHash, $fullName, $role, $status);
        $stmt->execute();
        $stmt->close();
    }
}
