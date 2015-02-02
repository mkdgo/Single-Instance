<?php
if (!defined('BASEPATH'))	exit('No direct script access allowed');
class User_types_permissions extends MY_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->model('admin/user_types_permissions_model');
		$this->load->library('user_types_permissions_lib');
		$this->_data['_controller_name'] = strtolower(get_class($this));
		$this->_data['_controller_title'] = $this->_parse_title(get_class($this));
		$this->_data['_menu_selected'] = '/admin/users/';
	}


	public function index() {
		$user_types = $this->user_types_permissions_model->get_user_types('user_types', 1);
		foreach ($user_types as $key => $user_type) {
			$this->_data['user_types'][$key]['name'] = $user_type->content;			
		}
		$this->_generate_form();
		$this->_paste_admin('user_types_permissions');
	}


	public function _generate_form() {
		$fields_arr = $this->user_types_permissions_lib->generate_lang_checkbox('permissions',1);
		foreach($fields_arr as $field){
//			echo $field['label'];
//			echo $field['checkbox'];
		}
	}
	public function _parse_title($title) {
		$new_title = str_replace("_", " ", strtolower($title));
		return $new_title;
	}


}
