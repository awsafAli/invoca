<?php
namespace App;

class DataFetcher {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function fetchTableData($tableName) {
        // Ensure table name is safe to prevent SQL injection
        $allowedTables = ['adjustments', 'mapping', 'tb_trend'];
        if (!in_array($tableName, $allowedTables)) {
            throw new \Exception('Invalid table name');
        }

        $query = "SELECT * FROM $tableName";
        return $this->db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchDataById($tableName, $id) {
        $allowedTables = ['adjustments', 'mapping', 'tb_trend'];
        if (!in_array($tableName, $allowedTables)) {
            throw new \Exception('Invalid table name');
        }

        $query = "SELECT * FROM $tableName WHERE id = :id";
        return $this->db->query($query, ['id' => $id])->fetch(\PDO::FETCH_ASSOC);
    }
}
?>
