<?php

require_once __DIR__ . '/../db.php'; 
class BaseModel {
    protected $tableName;
    protected $db;

    public function __construct($tableName) {
        $this->tableName = $tableName;
        $this->db = getDB(); 
    }

    public function db() { return $this->db; }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM " . $this->tableName);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->tableName . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        if (is_object($data)) {
            $data = (array) $data;
        }

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $values = array_values($data);

        $sql = "INSERT INTO " . $this->tableName . " (" . $columns . ") VALUES (" . $placeholders . ")";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        if (is_object($data)) {
            $data = (array) $data;
        }

        $setParts = [];
        $values = [];
        foreach ($data as $key => $value) {
            $setParts[] = "`" . $key . "` = ?";
            $values[] = $value;
        }
        $values[] = $id;

        $sql = "UPDATE " . $this->tableName . " SET " . implode(', ', $setParts) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM " . $this->tableName . " WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function rawFetch($query, $params = []) {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Raw fetch query failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function rawExecute($query, $params = []) {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->rowCount(); 
        } catch (PDOException $e) {
            error_log("Raw execute query failed: " . $e->getMessage());
            throw $e; 
        }
    }

    public function filter(array $conditions) {
        /* 
            exemple d'utilisaton:
            $filteredStudentsLike = $etudiantModel->filter([
                ['column' => 'nom', 'operator' => 'LIKE', 'value' => '%User%']
            ]);
        */ 
        if (empty($conditions)) {
            return $this->getAll();
        }

        $whereParts = [];
        $values = [];

        foreach ($conditions as $condition) {
            if (!isset($condition['column']) || !isset($condition['operator']) || !array_key_exists('value', $condition)) {
                throw new InvalidArgumentException("Each condition must have 'column', 'operator', and 'value' keys.");
            }

            $column = $condition['column'];
            $operator = strtoupper($condition['operator']);
            $value = $condition['value'];

            $allowedOperators = ['=', '!=', '<', '>', '<=', '>=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'IS NULL', 'IS NOT NULL'];
            if (!in_array($operator, $allowedOperators)) {
                throw new InvalidArgumentException("Invalid operator: " . $operator);
            }

            if ($operator === 'IN' || $operator === 'NOT IN') {
                if (!is_array($value)) {
                    throw new InvalidArgumentException("Value for IN/NOT IN operator must be an array.");
                }
                if (empty($value)) {
                }
                $placeholders = implode(', ', array_fill(0, count($value), '?'));
                $whereParts[] = "`" . $column . "` " . $operator . " (" . $placeholders . ")";
                $values = array_merge($values, $value);
            } elseif ($operator === 'IS NULL' || $operator === 'IS NOT NULL') {
                $whereParts[] = "`" . $column . "` " . $operator;
            } else {
                $whereParts[] = "`" . $column . "` " . $operator . " ?";
                $values[] = $value;
            }
        }

        $sql = "SELECT * FROM " . $this->tableName . " WHERE " . implode(' AND ', $whereParts);

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Filter query failed: " . $e->getMessage());
            throw $e;
        }
    }

}
