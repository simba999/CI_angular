<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Your own constructor code
    }

    public function insert($tableName = '', $records = array()) {
        $this->db->insert($tableName, $records);
        return $this->db->insert_id();
    }

    public function select($tableName = '', $conditions = array(), $parameters = '*', $groupby = array() ,$orderBy = '', $returnType = 'array') {
        $this->db->select($parameters);
        if ($groupby != '') {
            $this->db->group_by($groupby);
        }
        if($orderBy != ''){
            $this->db->order_by($orderBy, 'asc');
        }
        $query = $this->db->get_where($tableName, $conditions);
        if ($returnType == 'object') {
            return $query->result();
        } else {
            return $query->result_array();
        }
    }

    public function selectOne($tableName = '', $conditions = array(), $parameters = '*', $returnType = 'array') {

        $this->db->select($parameters);

        $query = $this->db->get_where($tableName, $conditions);
        if ($returnType == 'object') {
            return $query->row();
        } else {
            return $query->row_array();
        }
    }

    public function update($tableName = '', $records = array(), $conditions = array()) {

        $updateStatus = $this->db->update($tableName, $records, $conditions);

        return $updateStatus;
    }

    public function delete($tableName = '', $conditions = array()) {
        $deleteStatus = $this->db->delete($tableName, $conditions);
        return $deleteStatus;
    }

    public function selectJoin($tableName = '', $conditions = array(), $joins = array(), $parameters = "*", $groupby = '',$orderBy = '', $returnType = 'array') {
        $this->db->select($parameters);

        foreach ($joins AS $join) {
            $joinTable = $join['jointable'];
            $joinOn = $join['joinon'];
            $joinType = $join['jointype'];
            $this->db->join($joinTable, $joinOn, $joinType);
        }
        if ($groupby != '') {
            $this->db->group_by($groupby);
        }
        if($orderBy != ''){
            $this->db->order_by($orderBy, 'asc');
        }
        $query = $this->db->get_where($tableName, $conditions);

        if ($returnType == 'object') {
            return $query->result();
        } else {
            return $query->result_array();
        }
    }
    
}
