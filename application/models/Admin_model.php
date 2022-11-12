<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model 
{
    public function checkUser($email){
        $this->db->where(array('email'=>$email));
        return $row = $this->db->get('admin')->row_array();
    }

    public function getAllRecords($table,$select){
        $query = $this->db->select($select)->from($table)->get()->result_array();

        return $query;
    }

    public function updateData($table,$data,$where){
        $this->db->where($where)->update($table,$data);
    }

    public function getRecordWhere($table,$select,$where){
        $query = $this->db->select($select)->from($table)->where($where)->get()->row_array();

        return $query;
    }

    public function getAllRecordsWhere($table,$select,$where){
        $query = $this->db->select($select)->from($table)->where($where)->get()->result_array();

        return $query;
    }

    public function fetch_task($id){
        $this->db->select('*');
        $this->db->where('task_id', $id);
        $result = $this->db->get('task');

        return $result->row_array();
    }


}
