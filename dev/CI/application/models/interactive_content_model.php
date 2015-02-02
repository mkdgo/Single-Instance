<?php

class Interactive_content_model extends CI_Model {

	private $_table_cont_pages = 'content_page_slides';
	private $_table_int_assessment = 'interactive_assessments_slides';

	public function __construct() {
		parent::__construct();
	}
	
	public function get_il_content_pages($lesson_id = ''){
		$where = array(
			'lesson_id' => $lesson_id
		);
		$query = $this->db->get_where($this->_table_cont_pages, $where);
		return $query->result();
	}
	
	public function get_il_int_assesments($lesson_id = ''){
		$where = array(
			'lesson_id' => $lesson_id
		);
		$query = $this->db->get_where($this->_table_int_assessment, $where);
		return $query->result();
	}
		
	public function if_has_assesments($lesson_id = ''){
		$where = array(
			'lesson_id' => $lesson_id
		);
		$queryi = $this->db->get_where($this->_table_int_assessment, $where);
		$queryc = $this->db->get_where($this->_table_cont_pages, $where);
		
		return sizeof($queryc->result() + $queryi->result()) > 0 ? true : false;
	}
	
	
}