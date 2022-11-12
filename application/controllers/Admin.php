<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Admin_model');
    }

    public function is_logged_in()
    {
        if ($this->session->userdata('admin') === NULL) {
            // User is not logged in, redirect to login screen
            $this->session->set_flashdata('message', 'Please login first.');
            redirect('admin/index');
        }
    }

    public function index()
    {
        $data['class'] = 'Login';
        $data['title'] = 'Login';
        $this->load->view('admin/login', $data);
    }

    public function forget()
    {
        $data['class'] = 'Login';
        $data['title'] = 'Login';
        $this->load->view('admin/forget', $data);
    }

    public function dashboard()
    {
        $this->is_logged_in();
        $data['class'] = 'dashboard';
        $data['title'] = 'Dashboard';
        $data['pagename'] = 'Dashboard';
        $data['total_users'] = $this->db->select('user_id')->from('users')->where('status',1)->get()->num_rows();
        $data['total_tasks'] = $this->db->select('task_id')->from('task')->get()->num_rows();
        $data['total_withdraw'] = $this->db->select('wallet_id')->from('wallet')->get()->num_rows();
        $data['total_approved'] = $this->db->select('wallet_id')->from('wallet')->where('status',1)->get()->num_rows();

        $data['history'] = $this->db->select('t1.wallet_id,t1.withdraw_amount,t1.converted_amount,t1.paypal_email,t1.transaction_id,t1.status,t1.created_at,t2.username,t2.phone_number,t2.email')
                                    ->from('wallet as t1')
                                    ->join('users as t2', 't1.user_id = t2.user_id', 'left')
                                    ->order_by('wallet_id','DESC')
                                    ->limit(5)
                                    ->get()->result_array();


        $this->load->view('admin/dashboard', $data);
    }

    public function user()
    {
        $this->is_logged_in();
        $data['class'] = 'user';
        $data['title'] = 'User';
        $data['pagename'] = 'User';

        $this->load->view('admin/user', $data);
    }

    public function task()
    {
        $this->is_logged_in();
        $data['class'] = 'task';
        $data['title'] = 'Task';
        $data['pagename'] = 'Task';
        $this->load->view('admin/task', $data);
    }

    public function sub_task()
    {
        $this->is_logged_in();
        $data['class'] = 'task';
        $data['title'] = 'Sub Task';
        $data['pagename'] = 'Sub Task';
        $this->load->view('admin/sub_task', $data);
    }

    public function withdraw_request()
    {
        $this->is_logged_in();
        $data['class'] = 'withdraw_request';
        $data['title'] = 'Withdraw Request';
        $data['pagename'] = 'Withdraw Request';
        $data['history'] = $this->db->select('t1.wallet_id,t1.withdraw_amount,t1.converted_amount,t1.paypal_email,t1.transaction_id,t1.status,t1.created_at,t2.username,t2.phone_number,t2.email')
                                    ->from('wallet as t1')
                                    ->join('users as t2', 't1.user_id = t2.user_id', 'left')
                                    ->get()->result_array();

        $this->load->view('admin/all_withdraw_requests', $data);
    }

    public function referal_task()
    {
        $this->is_logged_in();
        $data['class'] = 'brand';
        $data['title'] = 'Referal Task';
        $data['pagename'] = 'Referal Task';
        $this->load->view('admin/referal_task', $data);
    }

    public function video_view_task()
    {
        $this->is_logged_in();
        $data['class'] = 'brand';
        $data['title'] = 'Video View Task';
        $data['pagename'] = 'Video View Task';
        $data["tasks"] = $this->db->get('task')->result_array();
        $this->load->view('admin/video_view_task', $data);
    }

    public function offerwal_task()
    {
        $this->is_logged_in();
        $data['class'] = 'offerwal_task';
        $data['title'] = 'Offerwal Task';
        $data['pagename'] = 'Offerwal Task';
        $this->load->view('admin/offerwal_task', $data);
    }

    public function login()
    {
        // FORM VALIDATION
        $data['class'] = 'Admin_login';
        $data['title'] = 'Admin_login';

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            // NO ERROR
            $email = $this->input->post('email');


            $admin = $this->Admin_model->checkUser($email);

            if (!empty($admin)) {

                $password = $this->input->post('password');

                if (password_verify($password, $admin['password'])) {

                    // SET SESSION VARIABLE AND USER LOGIN
                    $sessionArray['id'] = $admin['id'];
                    $sessionArray['user_name'] = $admin['user_name'];
                    $sessionArray['email'] = $admin['email'];
                    $sessionArray['contact_number'] = $admin['phone'];
                    $sessionArray['authenticated'] = TRUE;
                    $this->session->set_userdata('admin', $sessionArray);

                    redirect(base_url() . 'admin/dashboard');
                } else {
                    $this->session->set_flashdata('message', 'Either email or password is incorrect, please try again.');
                    redirect(base_url() . 'admin/index');
                }
            } else {
                $this->session->set_flashdata('message', 'Email does not exist, please register.');
                redirect(base_url('admin/index'));
            }
        } else {
            if ($this->session->userdata('user') != NULL) {
                redirect(base_url() . 'admin/index');
            } else {
                $this->load->view('admin/login', $data);
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/index');
    }

    public function add_video_view_task()
    {

        $insert_data = array(
            'task_title' => $this->input->post('task_title'),
            'earning_when_completed' => $this->input->post('earning_when_completed'),
            'watch_required' => $this->input->post("watch_required"),
            'type' => $this->input->post("type"),
            'description' => $this->input->post('description'),
            'create_at' => date('y-m-d h:i:s')
        );
        $this->db->insert("task", $insert_data);

        if ($this->db->affected_rows()) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function delete_task()
    {

        $id = $this->input->post("id");

        $this->db->where(array("task_id" => $id))->delete('task');

        echo "task delete successfully";
    }

    public function edit_task()
    {
        $this->is_logged_in();

        $task_id = $this->input->post('id');

        $data['task'] = $this->Admin_model->fetch_task($task_id);

        $msg = $this->load->view('admin/edit_task', $data, true);
        echo $msg;
    }

    public function update_task()
    {
        $id = $this->input->post('id');

        $insert_data = array(
            'task_title' => $this->input->post('task_title'),
            'earning_when_completed' => $this->input->post('earning_when_completed'),
            'watch_required' => $this->input->post("watch_required"),
            'type' => $this->input->post("type"),
            'description' => $this->input->post('description'),
            'last_updated' => date('y-m-d h:i:s')
        );
        $this->db->where(array("task_id" => $id))->update("task", $insert_data);

        if ($this->db->affected_rows()) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function change_status()
    {
        $post = $this->input->post();

        if ($post['status'] == 0) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        $this->Admin_model->updateData('users', $data, ['user_id' => $post['user_id']]);
    }

    public function settings()
    {
        $data['class'] = 'settings';
        $data['title'] = 'Settings';
        $data['pagename'] = 'Settings';
        $data['setting'] = $this->Admin_model->getRecordWhere('settings', '*', ['setting_id' => 1]);

        $this->load->view('admin/settings', $data);
    }

    public function update_settings()
    {
        $post = $this->input->post();
        $post['updated_at'] = date('Y-m-d H:i:s');

        $this->Admin_model->updateData('settings', $post, ['setting_id' => 1]);

        $this->session->set_flashdata('success', 'Settings updated successfully.');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function transaction_history($user_id)
    {
        $this->is_logged_in();
        $data['class'] = 'withdraw_request';
        $data['title'] = 'Withdraw Request';
        $data['pagename'] = 'Withdraw Request';
        $data['history'] = $this->db->select('t1.wallet_id,t1.withdraw_amount,t1.converted_amount,t1.paypal_email,t1.transaction_id,t1.status,t1.created_at,t2.username,t2.phone_number,t2.email')
            ->from('wallet as t1')
            ->join('users as t2', 't1.user_id = t2.user_id', 'left')
            ->where('t1.user_id', $user_id)
            ->get()->result_array();


        $this->load->view('admin/withdraw_request', $data);
    }

    public function approve_payment(){
        $post = $this->input->post();

        $data = [
            'transaction_id' => $post['transaction_id'],
            'image' => $this->upload_image(),
            'status' => 1
        ];

        $this->Admin_model->updateData('wallet',$data,['wallet_id' => $post['wallet_id']]);
        $this->session->set_flashdata('success', 'Payment approved successfully.');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function disapprove_payment(){
        $post = $this->input->post();
        $data['status'] = 0;

        $this->Admin_model->updateData('wallet',$data,['wallet_id' => $post['wallet_id']]);
    }

    public function upload_image(){
        $config['upload_path']          = './uploads/transactions';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['encrypt_name']         = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
            return false;
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data['upload_data']['file_name'];
        }
    }
}
