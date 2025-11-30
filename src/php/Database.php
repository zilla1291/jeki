<?php
/**
 * Database Helper Class
 * Provides methods for database operations
 */

class Database {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Execute a SELECT query
     */
    public function select($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("SELECT Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Execute a query and return single row
     */
    public function selectOne($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("SELECT Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Execute an INSERT query
     */
    public function insert($table, $data) {
        try {
            $columns = implode(',', array_keys($data));
            $placeholders = implode(',', array_fill(0, count($data), '?'));
            $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute(array_values($data));
            
            return $result ? $this->pdo->lastInsertId() : false;
        } catch (PDOException $e) {
            error_log("INSERT Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Execute an UPDATE query
     */
    public function update($table, $data, $where) {
        try {
            $set = implode('=?,', array_keys($data)) . '=?';
            $query = "UPDATE $table SET $set WHERE $where";
            
            $values = array_merge(array_values($data), []);
            $stmt = $this->pdo->prepare($query);
            
            return $stmt->execute($values);
        } catch (PDOException $e) {
            error_log("UPDATE Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Execute a DELETE query
     */
    public function delete($table, $where) {
        try {
            $query = "DELETE FROM $table WHERE $where";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("DELETE Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Count rows in table
     */
    public function count($table, $where = '') {
        try {
            $query = "SELECT COUNT(*) as count FROM $table";
            if ($where) {
                $query .= " WHERE $where";
            }
            
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
            
            return $result['count'] ?? 0;
        } catch (PDOException $e) {
            error_log("COUNT Error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get PDO instance
     */
    public function getPDO() {
        return $this->pdo;
    }
}
?>
