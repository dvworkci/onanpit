<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model 
{
     // PROPERTIES
     var $table = "users";
     var $selected_columns = ["user_id","email","referral_code","dollar","mh","last_login","status"];
     var $order_column = [null,"email","dollar","mh","referral_code","last_login",null,null];
 
     public function make_query()
     {
         $this->db->select($this->selected_columns);
         $this->db->from($this->table);
         if(isset($_POST["search"]["value"])){
             $this->db->like(["email" => $_POST["search"]["value"],"referral_code" => $_POST["search"]["value"],"dollar" => $_POST["search"]["value"],"mh" => $_POST["search"]["value"]]);
         }
         if(isset($_POST["order"])){
             $this->db->order_by($this->order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
         } else {
             $this->db->order_by("user_id","DESC");
         }
     }
 
     public function make_datatables()
     {
         $this->make_query();
         if($_POST["length"] != -1){
             $this->db->limit($_POST["length"],$_POST["start"]);
         }
         $query = $this->db->get();
         return $query->result();
     }
 
     public function get_filtered_data()
     {
         $this->make_query();
         $query = $this->db->get();
         return $query->num_rows();
     }
 
     public function get_all_data()
     {
         $this->db->select("*");
         $this->db->from($this->table);
         return $this->db->count_all_results();
     }


}
