<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Admin';
$route['forget'] = 'Admin/forget';
$route['dashboard'] = 'Admin/dashboard';
$route['user'] = 'Admin/user';
$route['task'] = 'Admin/task';
$route['video-view-task'] = 'Admin/video_view_task';
$route['referal-task'] = 'Admin/referal_task';
$route['offerwal-task'] = 'Admin/offerwal_task';
$route['sub-task'] = 'Admin/sub_task';
$route['withdraw-request'] = 'Admin/withdraw_request';
$route['settings'] = 'Admin/settings';

// API ROUTES
$route['api/v1/new-login'] = 'Api_controller/login';
$route['api/v1/exist-login'] = 'Api_controller/exist_login';
$route['api/v1/update-user'] = 'Api_controller/update_user';
$route['api/v1/redeem-referral-code'] = 'Api_controller/redeem_referral_code';
$route['api/v1/get-user-earnings'] = 'Api_controller/get_user_earnings';
$route['api/v1/get-tasks'] = 'Api_controller/get_tasks';
$route['api/v1/user-task-progress'] = 'Api_controller/user_task_progress';
$route['api/v1/get-completed-tasks'] = 'Api_controller/get_completed_tasks';
$route['api/v1/increase-earning'] = 'Api_controller/increase_earning';
$route['api/v1/boost-speed'] = 'Api_controller/boost_speed';
$route['api/v1/withdraw-amount'] = 'Api_controller/withdraw_amount';
$route['api/v1/withdraw-history'] = 'Api_controller/withdraw_history';
$route['api/v1/get-plans'] = 'Api_controller/get_plans';
$route['api/v1/purchase-plan'] = 'Api_controller/purchase_plan';
$route['api/v1/generate-token'] = 'Api_controller/generate_token';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// DATATABLES
$route['get_users'] = 'Datatable/get_users';
