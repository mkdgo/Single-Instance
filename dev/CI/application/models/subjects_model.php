<?php

class Subjects_model extends CI_Model {

	private $_table = 'subjects';
        private $_year_table = 'subject_years';

	public function __construct() {
		parent::__construct();
	}

	public function get_subjects() {
		$query = $this->db->order_by("name", "asc")->get($this->_table);
		return $query->result();
	}

    public function get_students_subjects($student_year) {
		$this->db->select('*');
            $this->db->from($this->_table);
            $this->db->join($this->_year_table,'subject_years.subject_id=subjects.id');
               
            $this->db->where($this->_year_table.'.year',$student_year);
            $query = $this->db->get();
		return $query->result();
	}
        
        
	public function get_subject_by_id($id = '') {
		$where_arr = array('id' => $id);
		$this->db->where($where_arr);
		$query = $this->db->order_by("name", "asc")->get($this->_table);
		return $query->result();
	}
	public function get_single_subject($id = '') {
		$where_arr = array('id' => $id);
		$this->db->where($where_arr);
		$query = $this->db->order_by("name", "asc")->get($this->_table);
		return $query->row();
	}
	
	public function save($data, $id = '') {
		if ($id) {
			$this->db->update($this->_table, $data, array('id' => $id));
		} else {
			$this->db->insert($this->_table, $data);			
			$id = $this->db->insert_id();
		}
		
		return $id;
	}

    public function get_subject_years($subject_id) {
            
		$query = $this->db->order_by("year", "asc")->get_where($this->_year_table, array('subject_id' => $subject_id));
		return $query->result();
	}
        
    public function get_subject_year($subject_id, $year) {
            
		$where_arr = array('subject_id' => $subject_id, 'year' => $year);
		$this->db->where($where_arr);
		$query = $this->db->get($this->_year_table);
                //$r = $query->result_array();
                 //die(print_r($r));
		return $query->row();
	}
        
    public function get_year($year_id) {
            
		$where_arr = array('id' => $year_id);
		$this->db->where($where_arr);
		$query = $this->db->get($this->_year_table);
		return $query->row();
	}

}