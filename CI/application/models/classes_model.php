<?php

class Classes_model extends CI_Model {

	private $_table = 'classes';

	public function __construct() {
		parent::__construct();
	}
	
	public function get_classes_for_subject_year($subject, $year) {
		$this->db->select('classes.id, classes.year, classes.group_name');
		$this->db->from($this->_table);
		//$this->db->join('teacher_classes', 'teacher_classes.class_id = classes.id', 'inner');
		//$this->db->where('subject_id', $subject_id);
		$this->db->where('subject_id', $subject);
        	$this->db->where('year', $year);
        	//$this->db->group_by('classes.year');
		//$this->db->order_by('year', 'asc');
		$this->db->order_by('group_name', 'asc');
		$query = $this->db->get();
		//log_message('error', $this->db->last_query());

		return $query->result_array();	
	}
	
	public function get_classes_for_teacher($teacher_id) {
		$this->db->select('classes.id, classes.year, classes.group_name');
		$this->db->from($this->_table);
		$this->db->join('teacher_classes', 'teacher_classes.class_id = classes.id', 'inner');
		//$this->db->where('subject_id', $subject_id);
		$this->db->where('teacher_id', $teacher_id);
        	$this->db->group_by('classes.year');
		$this->db->order_by('year', 'asc');
		$this->db->order_by('group_name', 'asc');
		$query = $this->db->get();
		//log_message('error', $this->db->last_query());

		return $query->result_array();	
	}

	public function get_classes_for_student($student_id) {
	}

    public function getAllYears() {
        $this->db->select('year');
        $this->db->distinct();
        $this->db->from($this->_table);
        $this->db->order_by("year", "asc"); 
        $query = $this->db->get();
        return $query->result_array();
    }
}
