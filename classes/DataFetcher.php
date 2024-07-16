<?php
namespace App;

class DataFetcher {
    private $db;
    private $allowedTables = ['adjustments', 'mapping', 'tb_trend'];

    public function __construct() {
        $this->db = new Database();
    }

    public function fetchTableData($tableName, $limit, $offset) {
        if (!in_array($tableName, $this->allowedTables)) {
            throw new \Exception('Invalid table name');
        }

        $query = "SELECT * FROM $tableName LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countTableData($tableName) {
        if (!in_array($tableName, $this->allowedTables)) {
            throw new \Exception('Invalid table name');
        }

        $query = "SELECT COUNT(*) as count FROM $tableName";
        $stmt = $this->db->query($query);
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }
}
?>
