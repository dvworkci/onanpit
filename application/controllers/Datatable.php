<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datatable extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('User_model','UM');
        $this->load->model('Api_model','APIMOD');
    }

    public function get_users(){
        $fetch_data = $this->UM->make_datatables();
        $data = [];
        $serial = 1;

        foreach ($fetch_data as $row) {
            $subArray = [];
            $subArray[] = $serial++;
            $subArray[] = $row->email;
            $subArray[] = sprintf('%.12f',floatval($this->get_user_earning($row->user_id,'dollar')));
            $subArray[] = sprintf('%.12f',floatval($this->get_user_earning($row->user_id,'mh')));
            $subArray[] = $row->referral_code;
            $subArray[] = ($row->last_login != '0000-00-00 00:00:00') ? date('d/m/Y h:i A', strtotime($row->last_login)) : 'N/A';

            if($row->status != 0){
                $subArray[] = '<button type="button" id="'.$row->user_id.'" data-status="'.$row->status.'" class="btn btn-success change_status">Active</button>';
            } else {
                $subArray[] = '<button type="button" id="'.$row->user_id.'" data-status="'.$row->status.'" class="btn btn-danger change_status">Inactive</button>';
            }

            $subArray[] = '<a href="'.base_url('admin/transaction_history/' . $row->user_id).'" type="button" class="btn btn-primary">View</a>';

            $data[] = $subArray;
        }

        $output = [
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->UM->get_all_data(),
            "recordsFiltered" => $this->UM->get_filtered_data(),
            "data" => $data
        ];

        echo json_encode($output);
    }

    public function get_user_earning($user_id,$want){
        $userBalanceCommission = $this->APIMOD->getRecordWhere('users', 'total_balance,dollar,mh,commission_earned,kill_date', ['user_id' => $user_id]);
        $mhRecords = $this->APIMOD->getAllRecordWhere('speed_records', 'mh', ['user_id' => $user_id]);
        $dollarRecords = $this->APIMOD->getAllRecordWhere('speed_records', 'dollar_increased', ['user_id' => $user_id]);

        if(!empty($mhRecords)){
            foreach($mhRecords as $mh){
                $userBalanceCommission['mh'] += $mh['mh'];
            }
        }

        if(!empty($dollarRecords)){
            foreach($dollarRecords as $dollar){
                $userBalanceCommission['dollar'] += $dollar['dollar_increased'];
            }
        }

        switch($want){
            case 'dollar':
                return $userBalanceCommission['dollar'];
                break;
            case 'mh':
                return $userBalanceCommission['mh'];
                break;
        }
    }
}
