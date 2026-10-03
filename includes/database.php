<?php
require_once __DIR__ . '/config.php';

class Database
{
    private $conn;

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

    public function getConnection()
    {
        return $this->conn;
    }

    private function initializeSchema()
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

    private function seedData()
    {
        $seedPath = __DIR__ . '/../db/seed.sql';
        if (!file_exists($seedPath)) {
            return;
        }

        $seedSql = file_get_contents($seedPath);
        if ($seedSql === false || trim($seedSql) === '') {
            return;
        }

        $this->conn->multi_query($seedSql);
        do {
            if ($result = $this->conn->store_result()) {
                $result->free();
            }
        } while ($this->conn->next_result());
    }
}
