<?php

namespace App\Models;
use CodeIgniter\Model;

class CustomModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function get_data($data) {

        $builder = $this->db->table($data['table']);

        if(isset($data['select'])) {
            $builder->select($data['select']);
        }

        if(isset($data['join']) && is_array($data['join'])) {
            foreach ($data['join'] as $key => $value) {
                if(is_array($value)) {
                    $builder->join($value['table'], $value['on'], $value['type']);
                } else {
                    $builder->join($data['join']['table'], $data['join']['on'], $data['join']['type']);
                    break;
                }
            }
        }

        if(isset($data['condition']) && is_array($data['condition'])) {
            foreach ($data['condition'] as $key => $value) {
                if(is_array($value)) {
                    $builder->where($value['column'], $value['value']);
                } else {
                    $builder->where($data['condition']['column'], $data['condition']['value']);
                    break;
                }
            }
        }

        if(isset($data['like']) && is_array($data['like'])) {
            foreach ($data['like'] as $key => $value) {
                if(is_array($value)) {
                    $builder->like($value['column'], $value['value'], $value['param']);
                } else {
                    $builder->like($data['like']['column'], $data['like']['value'], $data['like']['param']);
                    break;
                }
            }
        }

        if(isset($data['limit'])) {
            $builder->limit($data['limit']);
        }

        if(isset($data['offset'])) {
            $builder->limit($data['limit'], $data['offset']);
        }

        if(isset($data['order'])) {
            $builder->orderBy($data['order']);
        }

        if(isset($data['group'])) {
            $builder->groupBy($data['group']);
        }

    
    
        // print_r($builder->getCompiledSelect());
        return $builder->get()->getResult();
    }

    public function insert_data($table, $data) {
        $builder = $this->db->table($table);
        $builder->insert($data);
        return $this->db->insertID();
    }

    public function insert_data_batch($table, $data) {
        $builder = $this->db->table($table);
        return $builder->insertBatch($data);
    }

    public function delete_data($table, $condition) {
        $builder = $this->db->table($table);
        if(is_array($condition)) {
            foreach($condition as $key => $value) {
                $builder->where($key, $value);
            }
        }
        
        return $builder->delete();
    }

    public function update_data($table, $where, $value, $data) {
        $builder = $this->db->table($table);
        $builder->where($where, $value);
        return $builder->update($data);
    }

    public function update_data_batch($table, $data, $param) {
        $builder = $this->db->table($table);
        $builder->updateBatch($data, $param);
        return $this->db->affectedRows();
    } 


}

