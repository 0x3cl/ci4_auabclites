<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function fetchData($field, $value = '') {
        $builder = $this->db->table('lites_users');
        $builder->where($field, $value);
        $result = $builder->get()->getResult();
        return $result;
    }

}