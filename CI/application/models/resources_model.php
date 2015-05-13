<?php

class Resources_model extends CI_Model {

	private $_table = 'resources';
	private $_table_mod_resources = 'modules_resources';
	private $_table_les_resources = 'lessons_resources';
	private $_cont_page_resources = 'cont_page_resources';
	private $_table_assignments_resources = 'assignments_resources';

	public function __construct() {
		parent::__construct();
	}

	public function save($data = array(), $id = '') {
		if ($id) {
			$this->db->update($this->_table, $data, array('id' => $id));			
		} else {
			$this->db->insert($this->_table, $data);
			$id = $this->db->insert_id();
		}
		
		return $id;
	}

	public function get_all_resources() {
		$this->db->from($this->_table);
		$this->db->where('active', 1);
		//$this->db->order_by("name", "asc");
		$this->db->order_by("id", "asc");
		$query = $this->db->get();

		return $query->result();
	}
	
	public function get_resource_by_id($resource_id= ''){
		$this->db->where('id', $resource_id);
		$query = $this->db->get($this->_table);
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return NULL;
		}
	}
	
	public function get_teacher_resources($teacher_id) {
		$this->db->from($this->_table);
		$this->db->where('teacher_id', $teacher_id);		
		$this->db->order_by("name", "asc");
		$query = $this->db->get();

		return $query->result();
	}

	public function get_module_resources($module_id = '') {
		$this->db->select(array('resources.id as res_id', 'resources.name', 'resources.resource_name', 'resources.is_remote','resources.type', 'resources.link'));
		$this->db->from($this->_table);
		$this->db->join($this->_table_mod_resources, 'resources.id = modules_resources.resource_id');
		$this->db->where('modules_resources.module_id', $module_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_lesson_resources($lesson_id = '', $search = 0 ) {
		$this->db->select(array('resources.id as res_id', 'resources.name', 'resources.resource_name', 'resources.type', 'resources.is_remote', 'resources.link'));
		$this->db->from($this->_table);
		$this->db->join($this->_table_les_resources, 'resources.id = lessons_resources.resource_id', 'inner');
		$this->db->where('lessons_resources.lesson_id', $lesson_id);
        
        if( is_array( $search ) ) {
            if( isset( $search['restriction_year'] ) && !empty( $search['restriction_year'] ) ) {
                $this->db->where('( resources.restriction_year LIKE "%'.$search['restriction_year'].'" OR resources.restriction_year LIKE "%'.$search['restriction_year'].'%" OR resources.restriction_year LIKE "'.$search['restriction_year'].'%" )');
            }
        }
		$query = $this->db->get();
//echo $this->db->last_query();die;
//log_message('error', "sql: ".$this->db->last_query());
		return $query->result();
	}

	public function get_cont_page_resources($cont_page_id = '') {
		$this->db->select(array('resources.id as res_id', 'resources.name', 'resources.type', 'resources.resource_name', 'resources.is_remote', 'resources.link'));
		$this->db->from($this->_table);
		$this->db->join($this->_cont_page_resources, 'resources.id = cont_page_resources.resource_id');
		$this->db->where('cont_page_resources.cont_page_id', $cont_page_id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function get_assignment_resources($assignment_id) {
		$this->db->select(array('assignments_resources.is_late AS is_late', 'resources.id AS res_id', 'resources.name','resources.type', 'resources.resource_name', 'resources.is_remote', 'resources.link'));
		$this->db->from($this->_table);
		$this->db->join($this->_table_assignments_resources, 'resources.id = assignments_resources.resource_id');
		$this->db->where('assignments_resources.assignment_id', $assignment_id);
		$query = $this->db->get();
//echo $this->db->last_query();
		return $query->result();
	}
	
	public function add_resource($type, $elem_id, $resource_id) {
		switch ($type) {
			case 'module':
				$this->db->insert($this->_table_mod_resources, array('resource_id' => $resource_id, 'module_id' => $elem_id));
				break;
			case 'lesson':
				$this->db->insert($this->_table_les_resources, array('resource_id' => $resource_id, 'lesson_id' => $elem_id));
				break;
			case 'content_page':
				$this->db->insert($this->_cont_page_resources, array('resource_id' => $resource_id, 'cont_page_id' => $elem_id));
				break;
			case 'assignment':
				$this->db->insert($this->_table_assignments_resources, array('resource_id' => $resource_id, 'assignment_id' => $elem_id));
				break;
		}
        return  $this->db->insert_id();
	}
        
    public function remove_resource( $type, $elem_id, $resource_id) {
        $res = '0';
        switch( $type ) {
            case 'module':
                $res = $this->db->where('resource_id', $resource_id)->where('module_id', $elem_id)->delete($this->_table_mod_resources);
                break;
            case 'lesson':
                $res = $this->db->where('resource_id', $resource_id)->where('lesson_id', $elem_id)->delete($this->_table_les_resources);
                break;
            case 'content_page':
                $res = $this->db->where('resource_id', $resource_id)->where('cont_page_id', $elem_id)->delete($this->_cont_page_resources);
                break;
            case 'assignment':
                $res = $this->db->where('resource_id', $resource_id)->where('assignment_id', $elem_id)->delete($this->_table_assignments_resources);
                break;
        }
        return  $res;
    }

    public function assignment_resource_set_late($id, $late) {
        $this->db->update($this->_table_assignments_resources, array('is_late'=>$late), array('id' => $id));
    }

    public function delete_resource($resource_id) {

        $this->db->where('resource_id', $resource_id);
		$this->db->delete($this->_table_mod_resources);

        $this->db->where('resource_id', $resource_id);
		$this->db->delete($this->_table_les_resources);

        $this->db->where('resource_id', $resource_id);
		$this->db->delete($this->_cont_page_resources);

        $this->db->where('resource_id', $resource_id);
		$this->db->delete($this->_table_assignments_resources);

        $this->db->where('id', $resource_id);
		$this->db->delete($this->_table); 
    }


    public function search_users($query){
		$this->db->from('users');
		$this->db->like('first_name', $query);
		// $this->db->like('last_name', $query);
		// $this->db->like('email', $query);
		$query = $this->db->get();

		return $query->result();
    }

	public function get_resource_usage($resource_id) {

		$q_modules = $this->db->query("SELECT subject_years.year,modules.name as title FROM modules_resources
JOIN modules ON modules_resources.module_id=modules.id
JOIN subject_years subject_years ON modules.year_id=subject_years.id
where resource_id = $resource_id");
		$m_r = $q_modules->result_array();
		if($q_modules->num_rows()>=1)
		{
			$data['result']['Modules']=$m_r;
		}





		$q_lessons = $this->db->query("SELECT lessons.title,subject_years.year FROM lessons_resources
JOIN lessons ON lessons_resources.lesson_id=lessons.id
JOIN modules ON lessons.module_id = modules.id
JOIN subject_years subject_years ON modules.year_id=subject_years.id
where resource_id = $resource_id");
		$l_r = $q_lessons->result_array();
		if($q_lessons->num_rows()>=1)
		{

			$data['result']['Lessons']=$l_r;
		}



		$q_assignment = $this->db->query("SELECT classes.year,assignments.title FROM assignments_resources
JOIN assignments ON assignments.id=assignments_resources.assignment_id
JOIN classes  ON classes.id=assignments.class_id
where resource_id = $resource_id");
		$a_r = $q_assignment->result_array();
		if($q_assignment->num_rows()>=1)
		{
			$data['result']['Assignment']=$a_r;
		}

		$q_slides = $this->db->query("SELECT content_page_slides.title,subject_years.year FROM cont_page_resources
JOIN content_page_slides ON content_page_slides.id=cont_page_resources.cont_page_id
JOIN lessons ON lessons.id = content_page_slides.lesson_id
JOIN modules ON modules.id=lessons.module_id
JOIN subject_years subject_years ON modules.year_id=subject_years.id
where resource_id = $resource_id");
		$s_r = $q_slides->result_array();
		if($q_slides->num_rows()>=1)
		{
			$data['result']['Slides']=$s_r;
		}


		if($data)
		{
			return $data;
		}
		else
		{
			return false;
		}


	}

}

