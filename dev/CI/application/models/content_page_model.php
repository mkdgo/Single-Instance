<?php

class Content_page_model extends CI_Model {

	private $_table = 'content_page_slides';

	public function __construct() {
		parent::__construct();
	}
	
	public function get_cont_page($id) {
		$query = $this->db->get_where($this->_table, array('id' => $id, 'active' => 1));
		return $query->result();
	}
	
	public function save($data = array(), $id = '') {
		if ($id) {
			//log_message('error', implode(",", array_keys($data))."-".implode(",", $data));
			$this->db->update($this->_table, $data, array('id' => $id));
		} else {
			$this->db->insert($this->_table, $data);
			$id = $this->db->insert_id();
		}
		return $id;
	}
	
	public function content_page_exist($id) {
		$query = $this->db->get_where($this->_table, array('id' => $id));

		return $query->num_rows();
	}
	
	public function delete($cont_page_id = '' ){
		$this->db->where('id', $cont_page_id);
		$this->db->delete($this->_table); 
	}

}