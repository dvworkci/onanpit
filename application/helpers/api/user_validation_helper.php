<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('get_error_message')) {
	function get_error_message($errors)
	{
		$validation_message = array();
		foreach ($errors as $key => $value) {
			array_push($validation_message, $value);
		}
		return $validation_message[0];
	}
}

if(!function_exists('getStatesValidation')) {
	function getStatesValidation()
	{
		$get_states_validation = array(
			array(
				'field' => 'country_id',
				'label' => 'Country Id',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a country id',
				),
			)
		);
		return $get_states_validation;
	}
}

if(!function_exists('getCitiesValidation')) {
	function getCitiesValidation()
	{
		$get_cities_validation = array(
			array(
				'field' => 'state_id',
				'label' => 'State Id',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a state id',
				),
			)
		);
		return $get_cities_validation;
	}
}

if(!function_exists('userExistValidation')) {
	function userExistValidation()
	{
		$user_exist_validation = array(
			array(
				'field' => 'phone_number',
				'label' => 'Phone number',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a phone number'
				),
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|valid_email',
				'errors' => array(
					'required' => 'You must provide a email number',
					'valid_email' => 'Email should be valid format'
				),
			)
		);
		return $user_exist_validation;
	}
}

if(!function_exists('insertUserValidation')) {
	function insertUserValidation()
	{
		$insert_user_validation = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a name'
				),
			),
			array(
				'field' => 'phone_number',
				'label' => 'Phone number',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a phone number'
				),
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|valid_email',
				'errors' => array(
					'required' => 'You must provide a email number',
					'valid_email' => 'Email should be valid format'
				),
			),
			array(
				'field' => 'country',
				'label' => 'Country',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a Country'
				),
			),
			array(
				'field' => 'state',
				'label' => 'State',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a State'
				),
			),
			array(
				'field' => 'city',
				'label' => 'City',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a City'
				),
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|min_length[8]',
				'errors' => array(
					'required' => 'You must provide a Password',
					'min_length' => 'Minimum Password length is 8 characters'
				),
			),
			array(
				'field' => 'fcm_token',
				'label' => 'FCM token',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a fcm token'
				),
			)
		);
		return $insert_user_validation;
	}
}

if(!function_exists('loginValidation')) {
	function loginValidation()
	{
		$login_validation = array(
			array(
				'field' => 'phone_number_or_email',
				'label' => 'Phone number or Email',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a phone number or email.'
				),
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|min_length[8]',
				'errors' => array(
					'required' => 'You must provide a Password',
					'min_length' => 'Minimum Password length is 8 characters'
				),
			),
			array(
				'field' => 'fcm_token',
				'label' => 'FCM token',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a fcm token'
				),
			)
		);
		return $login_validation;
	}
}

if(!function_exists('forgotPasswordValidation')) {
	function forgotPasswordValidation()
	{
		$forgot_password_validation = array(
			array(
				'field' => 'phone_number',
				'label' => 'Phone number',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a phone number'
				),
			)
		);
		return $forgot_password_validation;
	}
}

if(!function_exists('changePasswordValidation')) {
	function changePasswordValidation()
	{
		$change_password_validation = array(
			array(
				'field' => 'id',
				'label' => 'User Id',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a user id',
				),
			),
			array(
				'field' => 'new_password',
				'label' => 'New Password',
				'rules' => 'required|min_length[8]',
				'errors' => array(
					'required' => 'You must provide a New Password',
					'min_length' => 'Minimum Password length is 8 characters, New Password'
				),
			)
		);
		return $change_password_validation;
	}
}

if(!function_exists('getUserValidation')) {
	function getUserValidation()
	{
		$get_user_validation = array(
			array(
				'field' => 'id',
				'label' => 'User Id',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a user id',
				),
			)
		);
		return $get_user_validation;
	}
}

if(!function_exists('updateUserValidation')) {
	function updateUserValidation()
	{
		$update_user_validation = array(
		    array(
				'field' => 'id',
				'label' => 'id',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a user id'
				),
			),
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a name'
				),
			),
			array(
				'field' => 'phone_number',
				'label' => 'Phone number',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a phone number'
				),
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|valid_email',
				'errors' => array(
					'required' => 'You must provide a email number',
					'valid_email' => 'Email should be valid format'
				),
			),
			array(
				'field' => 'country',
				'label' => 'Country',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a Country'
				),
			),
			array(
				'field' => 'state',
				'label' => 'State',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a State'
				),
			),
			array(
				'field' => 'city',
				'label' => 'City',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a City'
				),
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|min_length[8]',
				'errors' => array(
					'required' => 'You must provide a Password',
					'min_length' => 'Minimum Password length is 8 characters'
				),
			)
		);
		return $update_user_validation;
	}
}
?>