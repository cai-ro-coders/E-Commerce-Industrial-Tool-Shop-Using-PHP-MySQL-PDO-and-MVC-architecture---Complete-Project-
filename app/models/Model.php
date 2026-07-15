<?php

namespace App\Models;

use App\Helpers\Database;

abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $searchable = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all($orderBy = 'created_at', $direction = 'DESC')
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy} {$direction}";
        return $this->db->fetchAll($sql);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->fetch($sql, [$id]);
    }

    public function findBy($field, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = ?";
        return $this->db->fetch($sql, [$value]);
    }

    public function findAllBy($field, $value, $orderBy = 'created_at', $direction = 'DESC')
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = ? ORDER BY {$orderBy} {$direction}";
        return $this->db->fetchAll($sql, [$value]);
    }

    public function create($data)
    {
        $filtered = $this->filterData($data);
        $columns = implode(', ', array_keys($filtered));
        $placeholders = implode(', ', array_fill(0, count($filtered), '?'));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        return $this->db->insert($sql, array_values($filtered));
    }

    public function update($id, $data)
    {
        $filtered = $this->filterData($data);
        $sets = implode(' = ?, ', array_keys($filtered)) . ' = ?';
        $values = array_values($filtered);
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET {$sets} WHERE {$this->primaryKey} = ?";
        return $this->db->update($sql, $values);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->delete($sql, [$id]);
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = $this->db->fetch($sql);
        return $result ? (int)$result['count'] : 0;
    }

    public function countBy($field, $value)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE {$field} = ?";
        $result = $this->db->fetch($sql, [$value]);
        return $result ? (int)$result['count'] : 0;
    }

    public function paginate($page = 1, $perPage = 10, $conditions = '', $params = [], $orderBy = 'created_at', $direction = 'DESC')
    {
        $offset = ($page - 1) * $perPage;
        $where = $conditions ? "WHERE {$conditions}" : '';
        $countSql = "SELECT COUNT(*) as count FROM {$this->table} {$where}";
        $total = $this->db->fetch($countSql, $params);
        $total = $total ? (int)$total['count'] : 0;
        
        $sql = "SELECT * FROM {$this->table} {$where} ORDER BY {$orderBy} {$direction} LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;
        $items = $this->db->fetchAll($sql, $params);
        
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    public function search($query, $page = 1, $perPage = 10, $conditions = '', $params = [])
    {
        if (empty($this->searchable)) {
            return $this->paginate($page, $perPage, $conditions, $params);
        }
        
        $searchTerms = explode(' ', $query);
        $searchConditions = [];
        $searchParams = [];
        
        foreach ($searchTerms as $term) {
            $termConditions = [];
            foreach ($this->searchable as $field) {
                $termConditions[] = "{$field} LIKE ?";
                $searchParams[] = "%{$term}%";
            }
            $searchConditions[] = '(' . implode(' OR ', $termConditions) . ')';
        }
        
        $searchWhere = '(' . implode(' AND ', $searchConditions) . ')';
        $where = $conditions ? "{$conditions} AND {$searchWhere}" : $searchWhere;
        $allParams = array_merge($params, $searchParams);
        
        return $this->paginate($page, $perPage, $where, $allParams);
    }

    protected function filterData($data)
    {
        if (empty($this->fillable)) {
            return $data;
        }
        $filtered = [];
        foreach ($this->fillable as $key) {
            if (array_key_exists($key, $data)) {
                $filtered[$key] = $data[$key];
            }
        }
        return $filtered;
    }

    public function getTable()
    {
        return $this->table;
    }
}
