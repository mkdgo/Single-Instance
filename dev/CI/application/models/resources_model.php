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
		$this->db->order_by("name", "asc");
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
		$this->db->select(array('resources.id as res_id', 'resources.name', 'resources.resource_name', 'resources.is_remote', 'resources.link'));
		$this->db->from($this->_table);
		$this->db->join($this->_table_mod_resources, 'resources.id = modules_resources.resource_id');
		$this->db->where('modules_resources.module_id', $module_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_lesson_resources($lesson_id = '') {
		$this->db->select(array('resources.id as res_id', 'resources.name', 'resources.resource_name', 'resources.is_remote', 'resources.link'));
		$this->db->from($this->_table);
		$this->db->join($this->_table_les_resources, 'resources.id = lessons_resources.resource_id');
		$this->db->where('lessons_resources.lesson_id', $lesson_id);
		$query = $this->db->get();
log_message('error', "sql: ".$this->db->last_query());
		return $query->result();
	}

	public function get_cont_page_resources($cont_page_id = '') {
		$this->db->select(array('resources.id as res_id', 'resources.name', 'resources.resource_name', 'resources.is_remote', 'resources.link'));
		$this->db->from($this->_table);
		$this->db->join($this->_cont_page_resources, 'resources.id = cont_page_resources.resource_id');
		$this->db->where('cont_page_resources.cont_page_id', $cont_page_id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function get_assignment_resources($assignment_id) {
		$this->db->select(array('assignments_resources.is_late AS is_late', 'resources.id AS res_id', 'resources.name', 'resources.resource_name', 'resources.is_remote', 'resources.link'));
		$this->db->from($this->_table);
		$this->db->join($this->_table_assignments_resources, 'resources.id = assignments_resources.resource_id');
		$this->db->where('assignments_resources.assignment_id', $assignment_id);
		$query = $this->db->get();

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
        
        public function assignment_resource_set_late($id, $late)
        {
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
                
                //
            
                $this->db->where('id', $resource_id);
		$this->db->delete($this->_table); 
        }

}

