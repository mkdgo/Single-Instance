<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Interface_lib {

	private $_CI;

	function __construct() {
		$this->_CI = & get_instance();
		$this->_CI->load->database();
		$this->_CI->load->model('admin/interface_model');
	}

	public function alert($message = '', $type = 'alert-info') {
		if ($message) {
			return '<div class="alert ' . $type . '">' . $message . '</div>';
		} else {
			return '';
		}
	}

	public function generate_select_lang($table, $field_name = 'name', $lang_id = 1, $selected = '') {
		$results = $this->_CI->interface_model->get_lang_data($table, $field_name, $lang_id);
		foreach ($results as $result) {
			$select_data[$result->object_id] = $result->content;
		}

		$this->_CI->_data['select_' . $table] = form_dropdown($table, $select_data, $selected);
		$this->_CI->_data['label_' . $table] = form_label($this->_parse_table_name($table), $table);
	}

//	function _generate_select($name, $table, $field = 'title') {
//		$query = $this->db->get($table);
//		foreach ($query->result() as $row) {
//			$row_id = $row->id;
//			$this->_data[$name . '_arr'][$row_id][$name . '_id'] = $row_id;
//			$this->_data[$name . '_arr'][$row_id][$name] = $row->$field;
//			$this->_data[$name . '_arr'][$row_id]['selected'] = '';
//		}
//	}	

	private function _parse_table_name($table) {
		$new_title = str_replace("_", " ", ucfirst($table));
		return $new_title;
	}		public function p($args) {		echo '<pre>' . print_r($args,true) . '</pre>';	}		public function pe($args) {		exit('<pre>' . print_r($args,true) . '</pre>');	}	}