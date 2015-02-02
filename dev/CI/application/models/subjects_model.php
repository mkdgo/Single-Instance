<?php

class Subjects_model extends CI_Model {

	private $_table = 'subjects';
        private $_year_table = 'subject_years';

	public function __construct() {
		parent::__construct();
	}

	public function get_subjects() {
		$this->db->select('*');
                $this->db->from($this->_table);
                $this->db->where('publish',1);
                $query = $this->db->get();
		return $query->result();
	}

        public function get_students_subjects($student_year) {
		$this->db->select('subjects.id, subjects.name, subjects.logo_pic, subjects.publish, subject_years.subject_id, subject_years.year');
                $this->db->from($this->_table);
                $this->db->join($this->_year_table,'subject_years.subject_id=subjects.id');
                
                $this->db->where(array($this->_year_table.'.year'=>$student_year,'subjects.publish'=>1));
               
                $query = $this->db->get();
                
                //die($this->db->last_query());
                
		return $query->result();
	}
        
        
	public function get_subject_by_id($id = '') {
		$where_arr = array('id' => $id);
		$this->db->where($where_arr);
		$query = $this->db->get($this->_table);
		return $query->result();
	}
	public function get_single_subject($id = '') {
		$where_arr = array('id' => $id);
		$this->db->where($where_arr);
		$query = $this->db->get($this->_table);
		return $query->row();
	}
	
        public function get_main_curriculum($subject_id)
        {
            $this->db->select('*');
            $this->db->from('curriculum');
            $this->db->where(array('subject_id'=>$subject_id,'year_id'=>0));
            $query= $this->db->get();
            
            return $query->row();
            
        }
        public function get_subject_curriculum($subject_id,$year_id)
        {
            $this->db->select('*');
            $this->db->from('curriculum');
            $this->db->where(array('subject_id'=>$subject_id,'year_id'=>$year_id));
            $query= $this->db->get();
            
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
        
        
        public function save_curriculum($data,$subject_id, $id = '') {
            
           $this->db->update('curriculum', $data, array('id' => $id,'subject_id'=>$subject_id));
            
//		if ($id) {
//			$this->db->update($this->_table, $data, array('id' => $id));
//		} else {
//			$this->db->insert($this->_table, $data);			
//			$id = $this->db->insert_id();
//		}
		
		return TRUE;
	}
        
        
        
        public function get_subject_years($subject_id) {
            
		$query = $this->db->order_by("year", "asc")->get_where($this->_year_table, array('subject_id' => $subject_id,'publish'=>1));
		return $query->result();
	}
        
        public function get_subject_year($subject_id, $year) {
            
		$where_arr = array('id' => $subject_id, 'year' => $year);
		$this->db->where($where_arr);
		$query = $this->db->get($this->_year_table);
                //$r = $query->result_array();
                 //die(print_r($r));
                
               //echo $this->db->last_query();
		return $query->row();
	}
        
        public function get_student_subject_year($subject_id, $year) {
            
		$where_arr = array('subject_id' => $subject_id, 'year' => $year);
		$this->db->where($where_arr);
		$query = $this->db->get($this->_year_table);
               
		return $query->row();
	}
        
        
        
        public function get_year($year_id) {
            
		$where_arr = array('id' => $year_id);
		$this->db->where($where_arr);
		$query = $this->db->get($this->_year_table);
		return $query->row();
	}
        

}