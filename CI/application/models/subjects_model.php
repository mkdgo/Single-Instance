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
			$q = "SELECT `subjects`.`id`, `subjects`.`name`, `subjects`.`logo_pic`, `subjects`.`publish`, `subject_years`.`subject_id`, `subject_years`.`year` ,(SELECT COUNT(*) FROM modules WHERE subject_id=`subject_years`.`subject_id` AND publish=1)ccn FROM (`subjects`) JOIN `subject_years` ON `subject_years`.`subject_id`=`subjects`.`id` WHERE `subject_years`.`year` = $student_year AND `subjects`.`publish` = 1";
			$query = $this->db->query($q);

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

	public function get_student_subject_years($student_year)
	{
		$query = $this->db->query("SELECT GROUP_CONCAT(id SEPARATOR ', ') subs
FROM (`subject_years`)
WHERE `year` =  $student_year AND publish =1 ");

//die($this->db->last_query());
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		else
		{
			return false;
		}
	}



	public function get_allowed_modules_for_student($student_year)
	{
		$query= $this->db->query(" SELECT GROUP_CONCAT( lessons.id
SEPARATOR ',' ) AS l_id
FROM `subject_years`
JOIN modules ON ( subject_years.id = modules.year_id )
JOIN lessons ON ( lessons.module_id = modules.id )
WHERE subject_years.year =$student_year
AND modules.publish =1");
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		else
		{
			return false;
		}
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