<?php


if (!defined('BASEPATH'))
	exit('No direct script access allowed');


class MY_Form_validation extends CI_Form_validation {


	private $_CI;


	public function __construct($rules = array()) {
		parent::__construct($rules);
		$this->_CI = & get_instance();
		$this->_CI->load->database();
	}


	function unique_email_check($email) {
		$emailExists = $this->_CI->user_model->check_unique_email($email, $this->_CI->_id); 
		if ($emailExists) {
			$this->_CI->form_validation->set_message('unique_email_check', 'Email exist! Please enter diffrent email.');
			return false;
		} else {
			return true;
		}
	}
        function unique_nickname_check($nickname) {
		$nicknameExists = $this->_CI->user_model->check_unique_nickname($nickname, $this->_CI->_id); 
		if ($nicknameExists) {
			$this->_CI->form_validation->set_message('unique_nickname_check', 'Nickname exist! Please enter diffrent nickname.');
			return false;
		} else {
			return true;
		}
	}


	function validate_phone_number($phone) {
		$phone_number = trim($phone);
		if (!empty($phone_number)) {
			if (preg_match('/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $phone_number)) {
				return TRUE;
			} else {
				$this->_CI->form_validation->set_message('validate_phone_number', 'The %s field may contain valid phone number.');
				return FALSE;
			}
		}
	}


	public function validate_url($str) {
		$url = trim($str);
		if (!empty($url)) {
			$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
			if (!preg_match($pattern, $url)) {
				$this->_CI->form_validation->set_message('validate_url', 'The %s field must be valid url address.');
				return FALSE;
			}


			return TRUE;
		}
	}


	function validate_date($date) {
		$pattern = "/^\d{2}-\d{2}-\d{4}$/";
		if (!preg_match($pattern, $date)) {
			$this->_CI->form_validation->set_message('validate_date', 'Invalid date..');
			return false;
		}
		return true;
	}


}