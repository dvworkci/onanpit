<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_Model extends CI_Model
{
    public function checkUser($email)
    {
        $query = $this->db->get_where('users',array('email'=>$email));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false; 
        }
    }

    public function userCheck($user_id)
    {
        $query = $this->db->get_where('users',array('user_id'=>$user_id));
        if($query->num_rows() > 0){
            return true;
        }else{
            return false; 
        }
    }

    public function InsertUser($data)
    {
        $this->db->insert('users',$data);
        if($this->db->affected_rows()){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    // FUNCTION TO CHECK REFERRAL CODE VALIDITY
    public function checkReferralCode($referral_code){
        $query = $this->db->where('referral_code',$referral_code)->get('users')->num_rows();

        if($query > 0){
            return true;
        } else {
            return false;
        }
    }

    // GET USER ID ACCORDING TO REFERRAL CODE
    public function getReferralCodeUser($referral_code){
        $query = $this->db->select('user_id')->from('users')->where('referral_code',$referral_code)->get()->row_array();

        return $query;
    }

    // FUNCTION TO SAVE DATA INTO DB
    public function saveData($table,$data){
        if($this->db->insert($table,$data)){
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function getAllRecords($table){
        return $this->db->select('*')->from($table)->get()->result_array();
    }

    public function getRecordWhere($table,$select,$where){
        $query = $this->db->select($select)->from($table)->where($where)->get();

        if($query->num_rows() > 0){
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getAllRecordWhere($table,$select,$where){
        $query = $this->db->select($select)->from($table)->where($where)->get();

        if($query->num_rows() > 0){
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getUserCompletedTasks($user_id){
        $query = $this->db->select('t1.task_id,t2.task_title,t2.description')
                          ->from('task_status as t1')
                          ->join('task as t2','t1.task_id = t2.task_id','LEFT')
                          ->where('status',1)
                          ->get();
        
        if($query->num_rows() > 0){
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function updateData($table,$data,$where){
        $query = $this->db->where($where)->update($table,$data);

        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function getUserRefferals($user_id){
        return $this->db->select('*')->from('referrals')->where('referred_by',$user_id)->get()->num_rows();
    }

    // FUNCTION TO CHECK IF A PARTICULAR RECORD EXISTS IN DB
    public function checkRecord($table,$where){
        return $this->db->select('*')->from($table)->where($where)->get()->num_rows();
    }
}