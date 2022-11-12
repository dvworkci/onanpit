<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Api_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Api_model');
        $this->load->library('form_validation');

        $this->load->helper('api/json_creator_helper');
        $this->load->helper('api/user_validation_helper');

        // APIMOD MODEL
        $this->load->model('Api_model', 'APIMOD');
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/new-login
     * 
     * email: user@example.com
     */
    public function login()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
            setJsonResponse($response);
        } else {
            $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
            if ($this->form_validation->run() == true) {
                $email = $this->input->post('email');
                $admin = $this->Api_model->checkUser($email);

                $otp = rand('1000', '9999');
                if (!empty($admin)) {
                    $response = [
                        'error' => true,
                        'message' => 'User already exists.',
                        'data' => NULL
                    ];
                    setJsonResponse($response);
                } else {

                    $this->send($email, 'OTP', 'Your OTP is ' . $otp . '. Do not share it with anyone.');

                    $data = [
                        'email' => $email,
                        'referral_code' => 'TIPNANO' . rand(100000, 999999),
                        'dollar' => $this->return_default('default_dollar_to_user'),
                        'total_balance' => $this->return_default('default_dollar_to_user'),
                        'mh' => $this->return_default('default_mh'),
                        'last_login' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'kill_date' => date('Y-m-d H:i:s')
                    ];

                    $insert = $this->Api_model->InsertUser($data);
                    if ($insert) {
                        // GET USER
                        $user = $this->APIMOD->getRecordWhere('users', 'user_id,email,dollar,total_balance,mh', ['user_id' => $insert]);

                        $response = [
                            'error' => false,
                            'message' => 'Login successful.',
                            'data' => [
                                'otp' => $otp,
                                'user' => $user,
                                'currentDateTime' => date('d-m-Y H:i:s')
                            ]
                        ];
                        setJsonResponse($response);
                    } else {
                        $response = [
                            'error' => true,
                            'message' => 'An unexpected error occurred while trying to add new user.',
                            'data' => null
                        ];
                        setJsonResponse($response);
                    }
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => null
                ];
                setJsonResponse($response);
            }
        }
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/exist-login
     * 
     * email: user@example.com
     * is_otp: 1 => For OTP, 0 => Only Update
     * username: Only in cas of OTP = 0
     */
    public function exist_login()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
            setJsonResponse($response);
        } else {
            $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
            $this->form_validation->set_rules('is_otp', 'is_otp', 'required|numeric');

            if ($this->form_validation->run() == true) {
                $email = $this->input->post('email');
                $is_otp = $this->input->post('is_otp');

                $user = $this->Api_model->checkUser($email);

                if ($is_otp == 0) {
                    $this->form_validation->set_rules('username', 'Username', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        if (!empty($user)) {
                            $data = [
                                'username' => $this->input->post('username'),
                                'last_login' => date('Y-m-d H:i:s')
                            ];

                            $this->db->where('email', $email)->update('users', $data);

                            // GET UPDATED USER ID
                            $userID = $this->db->select('user_id')->from('users')->where('email', $email)->get()->row_array();

                            $result = [
                                'user_id' => $userID['user_id'],
                                'username' => $data['username'],
                                'email' => $email,
                            ];

                            $response = [
                                'error' => false,
                                'message' => 'Login Successful.',
                                'data' => $result
                            ];
                            setJsonResponse($response);
                        } else {
                            $response = [
                                'error' => true,
                                'message' => 'User does not exist.',
                                'data' => null
                            ];
                            setJsonResponse($response);
                        }
                    } else {
                        $response = [
                            'error' => true,
                            'message' => get_error_message($this->form_validation->error_array()),
                            'data' => null
                        ];
                        setJsonResponse($response);
                    }
                } else {
                    $dataOtp['otp'] = rand('1000', '9999');
                    if (!empty($user)) {
                        // UPDATE USERS TABLE WITH OTP
                        $this->db->where('email', $email)->update('users', $dataOtp);

                        // UPDATED USER
                        $updatedUser = $this->db->select('*')->from('users')->where('email', $email)->get()->row_array();
                        $this->send($email, 'OTP', 'Your OTP is ' . $dataOtp['otp'] . '. Do not share it with anyone.');

                        $response = [
                            'error' => false,
                            'message' => 'Login successful.',
                            'data' => [
                                'user' => $updatedUser,
                                'otp' => $dataOtp['otp'],
                                'currentDateTime' => date('d-m-Y H:i:s')
                            ]
                        ];
                        setJsonResponse($response);
                    } else {
                        $response = [
                            'error' => true,
                            'message' => 'User does not exist.',
                            'data' => null
                        ];
                        setJsonResponse($response);
                    }
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => null
                ];
                setJsonResponse($response);
            }
        }
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/update-user
     * 
     * user_id:1,
     * username: Sample User
     * password
     * phone_number
     * email
     * picture
     */
    public function update_user()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
            setJsonResponse($response);
        } else {

            // FIRST CHECK IF VALID USER ID
            $user_id = $this->input->post('user_id');

            $check = $this->db->select('user_id')->from('users')->where('user_id', $user_id)->get()->num_rows();

            if ($check > 0) {
                $post = $this->input->post();

                if (!empty($_FILES['picture']['name']) && $_FILES['picture']['name'] != '') {
                    $post['picture'] = $this->upload_image();
                }

                $post['updated_at'] = date('Y-m-d H:i:s');

                $this->db->where('user_id', $post['user_id'])->update('users', $post);
                $updatedUser = $this->db->select('*')->from('users')->where('user_id', $post['user_id'])->get()->row_array();

                $response = [
                    'error' => false,
                    'message' => 'User Updated Successfully.',
                    'data' => $updatedUser
                ];

                setJsonResponse($response);
            } else {
                $response = [
                    'error' => true,
                    'message' => 'Invalid User ID',
                    'data' => NULL
                ];

                setJsonResponse($response);
            }
        }
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/redeem-referral-code
     * 
     * user_id
     * referral_code
     */
    public function redeem_referral_code()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
            setJsonResponse($response);
        } else {
            // USER ID WHO WILL REDEEM THE CODE AND REFERRAL CODE
            $this->form_validation->set_rules('user_id', 'user_id', 'required|numeric');
            $this->form_validation->set_rules('referral_code', 'referral_code', 'required');

            if ($this->form_validation->run() == TRUE) {
                $post = $this->input->post();
                $referral_code = $post['referral_code'];

                // CHECK IF REFERRAL CODE IS VALID OR NOT
                $check = $this->APIMOD->checkReferralCode($referral_code);

                if ($check) {
                    // VALID REFERRAL CODE
                    // GET USE TO WHOM THIS REFERRAL CODE BELONGS TO
                    $referralCodeUser = $this->APIMOD->getReferralCodeUser($referral_code);

                    if ($referralCodeUser['user_id'] == $post['user_id']) {
                        // USER CANNOT REDEEM THEIR OWN REFERRAL CODE
                        $response = [
                            'error' => true,
                            'message' => 'Sorry, you cannot redeem your own referral code.',
                            'data' => NULL
                        ];
                        setJsonResponse($response);
                    } else {
                        // SET REFRRAL DATA AND SAVE TO DB
                        $data = [
                            'referred_by' => $referralCodeUser['user_id'],
                            'referral_code_used_by' => $post['user_id'],
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        if ($this->APIMOD->saveData('referrals', $data)) {
                            // REFERRAL CODE REDEEMED SUCCESSFULLY.

                            // if ($task_id != "0") {
                            //     $check = $this->APIMOD->checkRecord('task_status', ['task_id' => $task_id, 'user_id' => $referralCodeUser['user_id']]);
                            //     $total_task = $this->db->get_where('task', ['task_id' => $task_id])->row()->watch_required;

                            //     if ($check > 0) {

                            //         $taskStatus = $this->APIMOD->getRecordWhere('task_status', 'completed,total', ['task_id' => $task_id, 'user_id' => $referralCodeUser['user_id']]);

                            //         if ($taskStatus['completed'] == $total_task) {
                            //             $this->APIMOD->updateData('task_status', ['status' => 1, 'updated_at' => date('Y-m-d H:i:s')], ['task_id' => $task_id, 'user_id' => $referralCodeUser['user_id']]);
                            //         } else {
                            //             $updateData = [
                            //                 'completed' => $taskStatus['completed'] + 1,
                            //                 'updated_at' => date('Y-m-d H:i:s')
                            //             ];

                            //             $this->APIMOD->updateData('task_status', $updateData, ['task_id' => $task_id, 'user_id' => $referralCodeUser['user_id']]);
                            //             $taskNewStatus = $this->APIMOD->getRecordWhere('task_status', 'completed,total', ['task_id' => $task_id, 'user_id' => $referralCodeUser['user_id']]);

                            //             if ($taskNewStatus['completed'] == $taskNewStatus['total']) {
                            //                 $this->APIMOD->updateData('task_status', ['status' => 1, 'updated_at' => date('Y-m-d H:i:s')], ['task_id' => $task_id, 'user_id' => $referralCodeUser['user_id']]);
                            //             }
                            //         }
                            //     } else {
                            //         $insertData = [
                            //             'task_id' => $task_id,
                            //             'user_id' => $referralCodeUser['user_id'],
                            //             'completed' => '1',
                            //             'total' => $total_task,
                            //             'created_at' => date('Y-m-d H:i:s')
                            //         ];

                            //         $this->APIMOD->saveData('task_status', $insertData);
                            //     }
                            // }

                            $response = [
                                'error' => false,
                                'message' => 'Referral Code Redeem Successfully.',
                                'data' => NULL
                            ];
                            setJsonResponse($response);
                        } else {
                            // UNEXPECTED DATABASE ERROR
                            $response = [
                                'error' => true,
                                'message' => 'Sorry, an unexpected error occurred while trying to redeem referral code.',
                                'data' => NULL
                            ];
                            setJsonResponse($response);
                        }
                    }
                } else {
                    // INVALID REFERRAL CODE
                    $response = [
                        'error' => true,
                        'message' => 'Invalid Referral Code',
                        'data' => NULL
                    ];
                    setJsonResponse($response);
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => NULL
                ];
                setJsonResponse($response);
            }
        }
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/get-user-earnings
     * 
     * user_id:1
     */
    public function get_user_earnings()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
            setJsonResponse($response);
        } else {
            $this->form_validation->set_rules('user_id', 'user_id', 'required|numeric');

            if ($this->form_validation->run() == TRUE) {
                $user_id = $this->input->post('user_id');
                $status = $this->input->post('status');
                if ($status == '1') {
                    $this->db->where('user_id', $user_id)->update('users', ['kill_date' => date('Y-m-d H:i:s')]);
                }

                // GET USER'S BALANCE,REFERRALS AND COMMISSION EARNED
                $userBalanceCommission = $this->APIMOD->getRecordWhere('users', 'total_balance,dollar,mh,commission_earned,kill_date', ['user_id' => $user_id]);
                $mhRecords = $this->APIMOD->getAllRecordWhere('speed_records', 'mh', ['user_id' => $user_id]);
                $dollarRecords = $this->APIMOD->getAllRecordWhere('speed_records', 'dollar_increased', ['user_id' => $user_id]);
                $userReferrals = $this->APIMOD->getUserRefferals($user_id);

                if (!empty($mhRecords)) {
                    foreach ($mhRecords as $mh) {
                        $userBalanceCommission['mh'] += $mh['mh'];
                    }
                }

                if (!empty($dollarRecords)) {
                    foreach ($dollarRecords as $dollar) {
                        $userBalanceCommission['dollar'] += $dollar['dollar_increased'];
                    }
                }


                if (!$userBalanceCommission && !$userReferrals) {
                    $response = [
                        'error' => true,
                        'message' => 'Data Not Found.',
                        'data' => NULL
                    ];
                    setJsonResponse($response);
                } else {
                    $response = [
                        'error' => false,
                        'message' => 'User Earnings',
                        'data' => [
                            'dollar' => sprintf('%.12f', floatval($userBalanceCommission['dollar'])),
                            'total_balance' => sprintf('%.12f', floatval($userBalanceCommission['total_balance'])),
                            'current_speed' => sprintf('%.12f', floatval($userBalanceCommission['dollar'])),
                            'mh' => (float)number_format((float)$userBalanceCommission['mh'], 4, '.', ''),
                            'referrals' => $userReferrals,
                            'commission_earned' => $userBalanceCommission['commission_earned'],
                            'currentDateTime' => date('d-m-Y H:i:s'),
                            'kill_date_time' => date('d-m-Y H:i:s', strtotime($userBalanceCommission['kill_date']))
                        ]
                    ];
                    setJsonResponse($response);
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => NULL
                ];
                setJsonResponse($response);
            }
        }
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/get-tasks
     * 
     * type: 1 => Incomplete, 2 => Completed
     */
    public function get_tasks()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
        } else {

            $this->form_validation->set_rules('type', 'type', 'required|numeric');
            $this->form_validation->set_rules('user_id', 'user_id', 'required|numeric');

            if ($this->form_validation->run() == true) {
                $type = $this->input->post('type');
                $id = $this->input->post('user_id');
                
                if($type == 2){
                    $tasks = $this->db->select('t1.task_id, t1.type, t1.task_title, t1.description, t1.increased_dollar, t1.watch_required,t2.completed,t2.total,t2.status')
                    ->from('task t1')
                    ->join('task_status as t2','t1.task_id = t2.task_id','left')
                    ->where('status',1)
                    ->get()->result_array();
                } else {
                    $tasks = $this->db->select('t1.task_id, t1.type, t1.task_title, t1.description, t1.increased_dollar, t1.watch_required')
                    ->from('task t1')
                    ->get()->result_array();

                    foreach ($tasks as &$task) {
                        $completed = $this->db->select('completed, status')->get_where('task_status', ['task_id' => $task['task_id'], 'user_id' => $id])->row();
                        if (!empty($completed)) {
                            $task['completed'] = $completed->completed;
                            $task['status'] = $completed->status;
                        } else {
                            $task['completed'] = "0";
                            $task['status'] = "0";
                        }
                    }
                }

                if (!empty($tasks)) {
                    $response = [
                        'error' => false,
                        'message' => 'Tasks',
                        'data' => $tasks
                    ];
                } else {
                    $response = [
                        'error' => true,
                        'message' => 'Tasks Not Created yet',
                        'data' => NULL
                    ];
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => NULL
                ];
            }
        }
        setJsonResponse($response);
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/user-task-progress
     * 
     * task_type: 1 => Video 2 => Referral
     * task_id
     * user_id
     * completed
     * total
     */
    public function user_task_progress()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
        } else {
            $this->form_validation->set_rules('task_type', 'task_type', 'required|numeric');
            $this->form_validation->set_rules('task_id', 'task_id', 'required|numeric');
            $this->form_validation->set_rules('user_id', 'user_id', 'required|numeric');
            $this->form_validation->set_rules('completed', 'completed', 'required|numeric');
            $this->form_validation->set_rules('total', 'total', 'required|numeric');

            if ($this->form_validation->run() == TRUE) {
                $post = $this->input->post();

                $speedRecord = [
                    'user_id' => $post['user_id'],
                    'mh' => 0.005,
                    'dollar_increased' => '0.000000000015',
                    'expiry_date' => date('Y-m-d', strtotime('+1095 days')),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // CHECK IF TASK IS ALREADY IN PROGRESS OR NOT 
                $check = $this->APIMOD->checkRecord('task_status', ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                if ($post['task_type'] == 1) {
                    // TASK TYPE = 1 => VIDEO TASK
                    if ($check > 0) {
                        // MEANS TASK IS PROGRESSED ATLEAST ONE TIME
                        // GET TASK STATUS
                        $taskStatus = $this->APIMOD->getRecordWhere('task_status', 'completed,total', ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                        // CHECK IF TASK IS COMPLETED OR NOT 
                        if ($taskStatus['completed'] == $taskStatus['total']) {
                            // TASK IS COMPLETED, UPDATE STATUS TO 1
                            $this->APIMOD->updateData('task_status', ['status' => 1, 'updated_at' => date('Y-m-d H:i:s')], ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                            $response = [
                                'error' => false,
                                'message' => 'Task Completed',
                                'data' => [
                                    'task_type' => 1,
                                    'task_id' => (int) $post['task_id']
                                ]
                            ];
                        } else {
                            $this->APIMOD->saveData('speed_records', $speedRecord);
                            // TASK IS NOT COMPLETED YET
                            $updateData = [
                                'completed' => $post['completed'],
                                'updated_at' => date('Y-m-d H:i:s')
                            ];

                            $this->APIMOD->updateData('task_status', $updateData, ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                            // GET UPDATED TASK STATUS
                            $taskNewStatus = $this->APIMOD->getRecordWhere('task_status', 'completed,total', ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                            if ($taskNewStatus['completed'] == $taskNewStatus['total']) {
                                $this->APIMOD->updateData('task_status', ['status' => 1, 'updated_at' => date('Y-m-d H:i:s')], ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                                $response = [
                                    'error' => false,
                                    'message' => 'Task Completed',
                                    'data' => [
                                        'task_type' => 1,
                                        'task_id' => (int) $post['task_id']
                                    ]
                                ];
                            } else {
                                $response = [
                                    'error' => false,
                                    'message' => $taskNewStatus['completed'] . '/' . $taskNewStatus['total'] . ' Task Completed',
                                    'data' => [
                                        'task_type' => 1,
                                        'task_id' => (int) $post['task_id']
                                    ]
                                ];
                            }
                        }
                    } else {
                        $this->APIMOD->saveData('speed_records', $speedRecord);
                        // USER HAS STARTED NEW TASK

                        $insertData = [
                            'task_id' => $post['task_id'],
                            'user_id' => $post['user_id'],
                            'completed' => $post['completed'],
                            'total' => $post['total'],
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        if($post['completed'] == $post['total']){
                            $insertData['status'] = 1;
                        }

                        // SAVE TASK PROGRESS
                        $this->APIMOD->saveData('task_status', $insertData);

                        // GET UPDATED TASK STATUS
                        $taskNewStatus = $this->APIMOD->getRecordWhere('task_status', 'completed,total', ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                        $response = [
                            'error' => false,
                            'message' => $taskNewStatus['completed'] . '/' . $taskNewStatus['total'] . ' Task Completed',
                            'data' => [
                                'task_type' => 1,
                                'task_id' => (int) $post['task_id']
                            ]
                        ];
                    }
                } else if ($post['task_type'] == 2) {
                    // TASK TYPE = 2 => REFERRAL TASK
                    if ($check > 0) {
                        // MEANS TASK IS PROGRESSED ATLEAST ONE TIME
                        // GET TASK STATUS
                        $taskStatus = $this->APIMOD->getRecordWhere('task_status', 'completed,total', ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                        // CHECK IF TASK IS COMPLETED OR NOT 
                        if ($taskStatus['completed'] == $taskStatus['total']) {
                            // TASK IS COMPLETED, UPDATE STATUS TO 1
                            $this->APIMOD->updateData('task_status', ['status' => 1, 'updated_at' => date('Y-m-d H:i:s')], ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                            $response = [
                                'error' => false,
                                'message' => 'Task Completed',
                                'data' => [
                                    'task_type' => 1,
                                    'task_id' => (int) $post['task_id']
                                ]
                            ];
                        } else {
                            // TASK IS NOT COMPLETED YET
                            $updateData = [
                                'completed' => $post['completed'],
                                'updated_at' => date('Y-m-d H:i:s')
                            ];

                            $this->APIMOD->updateData('task_status', $updateData, ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);
                            $this->APIMOD->saveData('speed_records', $speedRecord);

                            // GET UPDATED TASK STATUS
                            $taskNewStatus = $this->APIMOD->getRecordWhere('task_status', 'completed,total', ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                            if ($taskNewStatus['completed'] == $taskNewStatus['total']) {
                                $this->APIMOD->updateData('task_status', ['status' => 1, 'updated_at' => date('Y-m-d H:i:s')], ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                                $response = [
                                    'error' => false,
                                    'message' => 'Task Completed',
                                    'data' => [
                                        'task_type' => 1,
                                        'task_id' => (int) $post['task_id']
                                    ]
                                ];
                            } else {
                                $response = [
                                    'error' => false,
                                    'message' => $taskNewStatus['completed'] . '/' . $taskNewStatus['total'] . ' Task Completed',
                                    'data' => [
                                        'task_type' => 1,
                                        'task_id' => (int) $post['task_id']
                                    ]
                                ];
                            }
                        }
                    } else {
                        // USER HAS STARTED NEW TASK
                        $insertData = [
                            'task_id' => $post['task_id'],
                            'user_id' => $post['user_id'],
                            'completed' => $post['completed'],
                            'total' => $post['total'],
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $this->APIMOD->saveData('speed_records', $speedRecord);
                        // SAVE TASK PROGRESS
                        $this->APIMOD->saveData('task_status', $insertData);

                        // GET UPDATED TASK STATUS
                        $taskNewStatus = $this->APIMOD->getRecordWhere('task_status', 'completed,total', ['task_id' => $post['task_id'], 'user_id' => $post['user_id']]);

                        $response = [
                            'error' => false,
                            'message' => $taskNewStatus['completed'] . '/' . $taskNewStatus['total'] . ' Task Completed',
                            'data' => [
                                'task_type' => 1,
                                'task_id' => (int) $post['task_id']
                            ]
                        ];
                    }
                } else {
                    $response = [
                        'error' => true,
                        'message' => 'Wrong Task Type',
                        'data' => NULL
                    ];
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => NULL
                ];
            }
        }
        setJsonResponse($response);
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/get-completed-tasks
     * 
     * user_id:1 
     */
    public function get_completed_tasks()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
            setJsonResponse($response);
        } else {
            $this->form_validation->set_rules('user_id', 'user_id', 'required|numeric');

            if ($this->form_validation->run() == TRUE) {
                $user_id = $this->input->post('user_id');

                // GET USER'S COMPLETED TASKS
                $data = $this->APIMOD->getUserCompletedTasks($user_id);

                if (!$data) {
                    $response = [
                        'error' => true,
                        'message' => 'Completed tasks not found.',
                        'data' => NULL
                    ];
                    setJsonResponse($response);
                } else {
                    $response = [
                        'error' => false,
                        'message' => 'Completed tasks.',
                        'data' => $data
                    ];
                    setJsonResponse($response);
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => NULL
                ];
                setJsonResponse($response);
            }
        }
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/get-completed-tasks
     * user_id:1
     * amount
     */
    public function increase_earning()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
        } else {
            $this->form_validation->set_rules('user_id', 'user_id', 'required|numeric');
            $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');

            if ($this->form_validation->run() == TRUE) {
                $user_id = $this->input->post('user_id');
                $updateData['total_balance'] = $this->input->post('amount');

                $check = $this->db->select('user_id')->from('users')->where('user_id', $user_id)->get()->num_rows();

                if ($check > 0) {
                    // GET USER EARNING

                    $this->db->where('user_id', $user_id)->update('users', $updateData);

                    // GET USER'S BALANCE,REFERRALS AND COMMISSION EARNED
                    $userBalanceCommission = $this->APIMOD->getRecordWhere('users', 'dollar,total_balance,mh,commission_earned,kill_date', ['user_id' => $user_id]);
                    $mhRecords = $this->APIMOD->getAllRecordWhere('speed_records', 'mh', ['user_id' => $user_id]);
                    $dollarRecords = $this->APIMOD->getAllRecordWhere('speed_records', 'dollar_increased', ['user_id' => $user_id]);
                    $userReferrals = $this->APIMOD->getUserRefferals($user_id);

                    if (!empty($mhRecords)) {
                        foreach ($mhRecords as $mh) {
                            $userBalanceCommission['mh'] += $mh['mh'];
                        }
                    }

                    if (!empty($dollarRecords)) {
                        foreach ($dollarRecords as $dollar) {
                            $userBalanceCommission['dollar'] += $dollar['dollar_increased'];
                        }
                    }

                    $response = [
                        'error' => false,
                        'message' => "Balance updated successfully",
                        'data' => [
                            'dollar' => sprintf('%.12f', floatval($userBalanceCommission['dollar'])),
                            'total_balance' => sprintf('%.12f', floatval($userBalanceCommission['total_balance'])),
                            'current_speed' => sprintf('%.12f', floatval($userBalanceCommission['dollar'])),
                            'mh' => $userBalanceCommission['mh'],
                            'referrals' => $userReferrals,
                            'commission_earned' => $userBalanceCommission['commission_earned'],
                            'currentDateTime' => date('d-m-Y H:i:s'),
                            'kill_date_time' => date('d-m-Y H:i:s', strtotime($userBalanceCommission['kill_date']))
                        ]
                    ];
                } else {
                    $response = [
                        'error' => true,
                        'message' => 'Invalid User ID',
                        'data' => NULL
                    ];
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => NULL
                ];
            }
        }
        setJsonResponse($response);
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/boost-speed
     * user_id:1 
     * type: 1 => Get Coins, 2 => Boost Speed
     */
    public function boost_speed()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
        } else {

            $this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');

            if ($this->form_validation->run() == true) {
                $post = $this->input->post();
                $speedRecord = [
                    'user_id' => $post['user_id'],
                    'mh' => 0.005,
                    'dollar_increased' => 0.000000000015,
                    'expiry_date' => date('Y-m-d', strtotime('+1095 days')),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->APIMOD->saveData('speed_records', $speedRecord);

                // GET USER'S BALANCE,REFERRALS AND COMMISSION EARNED
                $userBalanceCommission = $this->APIMOD->getRecordWhere('users', 'dollar,mh,commission_earned,kill_date', ['user_id' => $post['user_id']]);
                $mhRecords = $this->APIMOD->getAllRecordWhere('speed_records', 'mh', ['user_id' => $post['user_id']]);
                $dollarRecords = $this->APIMOD->getAllRecordWhere('speed_records', 'dollar_increased', ['user_id' => $post['user_id']]);
                $userReferrals = $this->APIMOD->getUserRefferals($post['user_id']);

                if (!empty($mhRecords)) {
                    foreach ($mhRecords as $mh) {
                        $userBalanceCommission['mh'] += $mh['mh'];
                    }
                }

                if (!empty($dollarRecords)) {
                    foreach ($dollarRecords as $dollar) {
                        $userBalanceCommission['dollar'] += $dollar['dollar_increased'];
                    }
                }

                $response = [
                    'error' => false,
                    'message' => 'Speed updated successfully.',
                    'data' => [
                        'dollar' => sprintf('%.12f', floatval($userBalanceCommission['dollar'])),
                        'current_speed' => sprintf('%.12f', floatval($userBalanceCommission['dollar'])),
                        'mh' => (float)number_format((float)$userBalanceCommission['mh'], 4, '.', ''),
                    ]
                ];
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => NULL
                ];
            }
        }
        setJsonResponse($response);
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/withdraw-amount
     * user_id:1 
     * withdraw_amount:1500 
     * paypal_email
     */
    public function withdraw_amount()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
            setJsonResponse($response);
        } else {
            $this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');
            $this->form_validation->set_rules('withdraw_amount', 'Withdraw Amount', 'required|numeric');
            $this->form_validation->set_rules('paypal_email', 'Paypal Account', 'trim|required|valid_email');

            if ($this->form_validation->run() == true) {
                $post = $this->input->post();
                // CHECK IF VALID USER OR NOT
                $userCheck = $this->APIMOD->userCheck($post['user_id']);

                if ($userCheck) {
                    // NOW CHECK WITHDRAW AMOUNT MINIMUM LIMIT
                    $limit = 1500;
                    if ($post['withdraw_amount'] < $limit) {
                        $response = [
                            'error' => true,
                            'message' => "Minimum withdraw limit is {$limit}",
                            'data' => NULL
                        ];
                        setJsonResponse($response);
                    } else {
                        // COIN BALANCE SHOULD BE >= WITHDRAW AMOUNT
                        $user = $this->APIMOD->getRecordWhere('users', 'total_balance', ['user_id' => $post['user_id']]);

                        if ($user['total_balance'] < $post['withdraw_amount']) {
                            $response = [
                                'error' => true,
                                'message' => "Insufficient coin balance: {$user['dollar']}",
                                'data' => NULL
                            ];
                            setJsonResponse($response);
                        } else {
                            $updateData['total_balance'] = $user['total_balance'] - $post['withdraw_amount'];
                            $this->APIMOD->updateData('users', $updateData, ['user_id' => $post['user_id']]);

                            $post['converted_amount'] = $updateData['total_balance'];   // Taking 5 as test value for coin to monney conversion
                            $post['status'] = 2;
                            $post['created_at'] = date('Y-m-d H:i:s');

                            $saved = $this->APIMOD->saveData('wallet', $post);

                            if ($saved) {
                                $updatedUser = $this->APIMOD->getRecordWhere('users', 'total_balance', ['user_id' => $post['user_id']]);
                                $response = [
                                    'error' => false,
                                    'message' => "Amount withdraw success",
                                    'data' => [
                                        'total_balance' => $updatedUser['total_balance'],
                                        'status' => 'Pending'
                                    ]
                                ];
                                setJsonResponse($response);
                            } else {
                                $response = [
                                    'error' => true,
                                    'message' => "Sorry, an unexpected error occurred while trying to save data",
                                    'data' => NULL
                                ];
                                setJsonResponse($response);
                            }
                        }
                    }
                } else {
                    $response = [
                        'error' => true,
                        'message' => 'Invalid User ID',
                        'data' => NULL
                    ];
                    setJsonResponse($response);
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => NULL
                ];
                setJsonResponse($response);
            }
        }
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/withdraw-history
     * 
     * user_id:1
     */
    public function withdraw_history()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
            setJsonResponse($response);
        } else {
            $this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');

            if ($this->form_validation->run() == true) {
                $post = $this->input->post();

                $check = $this->APIMOD->userCheck($post['user_id']);

                if ($check) {
                    // GET USER'S WALLET HISTORY
                    $data = $this->db->select('t1.withdraw_amount,t1.converted_amount,t1.paypal_email,t1.transaction_id,t1.status,t1.created_at,t2.dollar')
                        ->from('wallet as t1')
                        ->join('users as t2', 't1.user_id = t2.user_id', 'left')
                        ->where('t1.user_id', $post['user_id'])
                        ->get()->result_array();

                    foreach ($data as &$d) {
                        if ($d['status'] == 0) {
                            $d['status'] = 'Failed';
                        } else if ($d['status'] == 1) {
                            $d['status'] = 'Success';
                        } else {
                            $d['status'] = 'Pending';
                        }
                    }

                    if (empty($data)) {
                        $response = [
                            'error' => true,
                            'message' => 'Wallet history not found',
                            'data' => NULL
                        ];
                        setJsonResponse($response);
                    } else {
                        $response = [
                            'error' => false,
                            'message' => 'Wallet history',
                            'data' => $data
                        ];
                        setJsonResponse($response);
                    }
                } else {
                    $response = [
                        'error' => true,
                        'message' => 'Invalid User ID',
                        'data' => NULL
                    ];
                    setJsonResponse($response);
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => NULL
                ];
                setJsonResponse($response);
            }
        }
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/get-plans
     */
    public function get_plans()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
        } else {
            $plans = $this->APIMOD->getAllRecords('plans');

            if (!empty($plans)) {
                $response = [
                    'error' => false,
                    'message' => 'Plans.',
                    'data' => $plans
                ];
            } else {
                $response = [
                    'error' => true,
                    'message' => 'Plans not added yet.',
                    'data' => null
                ];
            }
        }
        setJsonResponse($response);
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/purchase-plan
     * 
     * user_id:1 
     * plan_id:1 
     */
    public function purchase_plan()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
        } else {
            $this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');
            $this->form_validation->set_rules('plan_id', 'Plan ID', 'required|numeric');

            if ($this->form_validation->run() == true) {
                $post = $this->input->post();
                // Check User
                $user = $this->APIMOD->getRecordWhere('users', '*', ['user_id' => $post['user_id']]);
                $plan = $this->APIMOD->getRecordWhere('plans', '*', ['plan_id' => $post['plan_id']]);

                if (!empty($user)) {
                    if (!empty($plan)) {
                        // Check if Refferal
                        $referred = $this->APIMOD->getRecordWhere('referrals', '*', ['referral_code_used_by' => $post['user_id']]);

                        if (!empty($referred)) {
                            if ($referred['referral_status'] == 0) {
                                // Referrals history
                                $referral_history = [
                                    'user_id' => $post['user_id'],
                                    'referred_by' => $referred['referred_by'],
                                    'plan_id' => $post['plan_id'],
                                    'mh' => $plan['ref_commission_mh'],
                                    'dollar' => $plan['ref_commission_dollar']
                                ];

                                // Give commission to referrer user
                                $commission = [
                                    'user_id' => $referred['referred_by'],
                                    'mh' => $plan['ref_commission_mh'],
                                    'dollar_increased' => $plan['ref_commission_dollar'],
                                    'expiry_date' => date('Y-m-d', strtotime('+1095 days')),
                                ];
                                $this->APIMOD->saveData('referral_history', $referral_history);
                                $this->APIMOD->saveData('speed_records', $commission);

                                // Change referral_status
                                $statusUpdate['referral_status'] = 1;
                                $this->APIMOD->updateData('referrals', $statusUpdate, ['referral_id' => $referred['referral_id']]);
                            }
                        }
                        // Purchase plan
                        $data = [
                            'user_id' => $post['user_id'],
                            'plan_id' => $post['plan_id'],
                            'purchase_date' => date('Y-m-d'),
                            'expiry_date' => date('Y-m-d', strtotime("+ {$plan['validity']} days")),
                            'amount' => $plan['price'],
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $saved = $this->APIMOD->saveData('plan_purchase_history', $data);

                        if ($saved) {

                            $speed_record = [
                                'user_id' => $post['user_id'],
                                'mh' => $plan['mh'],
                                'dollar_increased' => $plan['dollar'],
                                'expiry_date' => $data['expiry_date'],
                                'created_at' => $data['created_at']
                            ];

                            $this->APIMOD->saveData('speed_records', $speed_record);

                            // GET USER'S BALANCE,REFERRALS AND COMMISSION EARNED
                            $userBalanceCommission = $this->APIMOD->getRecordWhere('users', 'dollar,mh,commission_earned,kill_date', ['user_id' => $post['user_id']]);
                            $mhRecords = $this->APIMOD->getAllRecordWhere('speed_records', 'mh', ['user_id' => $post['user_id']]);
                            $dollarRecords = $this->APIMOD->getAllRecordWhere('speed_records', 'dollar_increased', ['user_id' => $post['user_id']]);
                            $userReferrals = $this->APIMOD->getUserRefferals($post['user_id']);

                            if (!empty($mhRecords)) {
                                foreach ($mhRecords as $mh) {
                                    $userBalanceCommission['mh'] += $mh['mh'];
                                }
                            }

                            if (!empty($dollarRecords)) {
                                foreach ($dollarRecords as $dollar) {
                                    $userBalanceCommission['dollar'] += $dollar['dollar_increased'];
                                }
                            }

                            $response = [
                                'error' => false,
                                'message' => 'Plan purchased successfully.',
                                'data' => [
                                    'dollar' => sprintf('%.12f', floatval($userBalanceCommission['dollar'])),
                                    'current_speed' => sprintf('%.12f', floatval($userBalanceCommission['dollar'])),
                                    'mh' => (float)number_format((float)$userBalanceCommission['mh'], 4, '.', ''),
                                ]
                            ];
                        } else {
                            $response = [
                                'error' => true,
                                'message' => 'Sorry, an unexpected error occurred, please try again later.',
                                'data' => NULL
                            ];
                        }
                    } else {
                        $response = [
                            'error' => true,
                            'message' => 'Plan not found.',
                            'data' => NULL
                        ];
                    }
                } else {
                    $response = [
                        'error' => true,
                        'message' => 'User not found.',
                        'data' => NULL
                    ];
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => get_error_message($this->form_validation->error_array()),
                    'data' => NULL
                ];
            }
        }
        setJsonResponse($response);
    }

    /**
     * @link: https://lapsmhow.co.in/tipneno/api/v1/generate-token
     */
    public function generate_token()
    {
        require 'vendor/autoload.php';

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $response = [
                'error' => true,
                'message' => 'Invalid Request.',
                'data' => NULL
            ];
        } else {
            $user_id = 23;

            $gateway = new Braintree\Gateway([
                'environment' => 'sandbox',
                'merchantId' => 'z9xj2zrh8hd6w5f5',
                'publicKey' => 'jq9qbzjg5z3bny4x',
                'privateKey' => 'cfda612d7df217bd94ca7c74ba6fa8ae'
            ]);

            $clientToken = $gateway->clientToken()->generate([
                "customerId" => $user_id
            ]);

            echo ($clientToken = $gateway->clientToken()->generate());
        }
    }

    /*************************** API END ***********************/

    // ALL PRIVATE FUNCTIONS
    private function upload_image()
    {

        $config['upload_path'] = 'uploads/user_images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('picture')) {
            return false;
        } else {
            $data = array('image_metadata' => $this->upload->data());

            return $config['upload_path'] . $data['image_metadata']['file_name'];
        }
    }

    private function send($email, $subject, $message)
    {
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp-relay.sendinblue.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ritesh.vedanshtechnovision@gmail.com';
        $mail->Password = '4vfcgFdnICmTpRyS';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;

        $mail->setFrom('info@tipnano.com', 'TipNano');
        $mail->addReplyTo('info@tipnano.com', 'TipNano');

        // Add a recipient
        $mail->addAddress($email);
        // Email subject
        $mail->Subject = $subject;

        // Set email format to HTML
        $mail->isHTML(true);
        $mail->Body = $message;

        // Send email
        $mail->send();
        // if(!$mail->send()){
        //     echo 'Message could not be sent.';
        //     echo 'Mailer Error: ' . $mail->ErrorInfo;
        // }else{
        //     echo 'Message has been sent';
        // }
    }

    private function return_default($name)
    {
        $value = $this->APIMOD->getRecordWhere('settings', $name, ['setting_id' => 1]);

        return $value[$name];
    }
}
