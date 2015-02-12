<?php

class Lessons_model extends CI_Model {

	private $_table = 'lessons';

	public function __construct() {
		parent::__construct();
	}

	public function get_lessons_by_module($where = array()) {
		$where['active'] = '1';
		$query = $this->db->order_by("order", "asc")->get_where($this->_table, $where);
                
                //die($this->db->last_query());
		return $query->result();
	}

	public function get_all_lessons() 
	{
		//$query = $this->db->order_by("order", "asc")->get_where($this->_table, array('active'=>'1'));

		$this->db->select('lessons.*,modules.subject_id subid');
		$this->db->from('lessons');
		$this->db->join('modules','modules.id=lessons.module_id');
		$this->db->where('lessons.active',1);

		$query = $this->db->get();



		return $query->result();
	}

    public function get_lesson($id) {
        $query = $this->db->get_where($this->_table, array('id' => $id, 'active' => '1'));
        return $query->row();
    }

	public function get_lesson_token($lesson_id) {
		$query = $this->db->select('token')->get_where($this->_table, array('id' => $lesson_id));
		return $query->row();
	}

	public function save($data = array(), $id = '') {
		$data['teacher_id'] = $this->session->userdata('id');
		if ($id) {
			$this->db->update($this->_table, $data, array('id' => $id));
		} else {
			$this->db->insert($this->_table, $data);
			$id = $this->db->insert_id();
		}
		
		return $id;
	}

	public function lesson_exist($id) {
		$query = $this->db->get_where($this->_table, array('id' => $id));

		return $query->num_rows();
	}
	
	public function interactive_lesson_published($id) {
		$this->db->select('id');
		$this->db->from($this->_table);
		$this->db->where('id', $id);
		$this->db->where('published_interactive_lesson', 1);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function interactive_lesson_exists($id) {
		$this->db->select('id');
		$this->db->from($this->_table);
		$this->db->where('id', $id);
		$this->db->where('interactive_lesson_exists', 1);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_classes_for_lesson($lesson_id) {
		$this->db->select('class_id');
		$this->db->from($this->_table);
		$this->db->join('lessons_classes', 'lesson_id = id', 'inner');		
		$this->db->where('id', $lesson_id);
		$query = $this->db->get();

		//log_message('error', $this->db->last_query());
		return $query->result();		
	}
	
	public function set_classes_for_lesson($lesson_id, $classes) {
		$this->db->delete('lessons_classes', array('lesson_id' => $lesson_id));
		
		foreach($classes as $value) {
			$data = array(
				'lesson_id' => $lesson_id,
				'class_id' => $value,
			);
			$this->db->insert('lessons_classes', $data);
		}
	}
	
	public function get_running_lesson_for_student($student_id) {
		$this->db->select('lessons.*, modules.subject_id, teacher.first_name, teacher.last_name');
		$this->db->from('users');
		$this->db->join('student_classes', 'student_classes.student_id = users.id', 'inner');
		$this->db->join('classes', 'classes.year = users.student_year', 'inner');
		$this->db->join('lessons_classes', 'lessons_classes.class_id = student_classes.class_id', 'inner');
		$this->db->join('lessons', 'lessons.id = lessons_classes.lesson_id', 'inner');
		$this->db->join('modules', 'modules.id = lessons.module_id', 'inner');
		$this->db->join('users AS teacher', 'lessons.teacher_id = teacher.id', 'inner');
		
		$this->db->where('users.id', $student_id);
		$this->db->where('users.user_type', 'student');
		//$this->db->where('lessons.published_interactive_lesson', 1);
//		$this->db->where('lessons.running_page >', 0);
        $this->db->where('lessons.token IS NOT NULL');
		$query = $this->db->get();
			
		return $query->row();
	}

	public function get_free_lesson_for_student($student_id) {
		$this->db->select('lessons.*, modules.subject_id, teacher.first_name, teacher.last_name');
		$this->db->from('users');
		$this->db->join('student_classes', 'student_classes.student_id = users.id', 'inner');
		$this->db->join('classes', 'classes.year = users.student_year', 'inner');
		$this->db->join('lessons_classes', 'lessons_classes.class_id = student_classes.class_id', 'inner');
		$this->db->join('lessons', 'lessons.id = lessons_classes.lesson_id', 'inner');
		$this->db->join('modules', 'modules.id = lessons.module_id', 'inner');
		$this->db->join('users AS teacher', 'lessons.teacher_id = teacher.id', 'inner');
		
		$this->db->where('users.id', $student_id);
		$this->db->where('users.user_type', 'student');
		$this->db->where('lessons.published_interactive_lesson', 1);
		$this->db->where('lessons.teacher_led >', 0);
		$query = $this->db->get();

		//log_message('error', "query: ".$this->db->last_query());
		return $query->row();
	}

	public function get_running_lesson_for_teacher($teacher_id) {
		$this->db->select('lessons.*, modules.subject_id');
		$this->db->from('lessons');
		$this->db->join('modules', 'modules.id = lessons.module_id', 'inner');
		$this->db->join('users', 'lessons.teacher_id = users.id', 'inner');
		
		$this->db->where('users.id', $teacher_id);
		$this->db->where('users.user_type', 'teacher');
		//$this->db->where('lessons.published_interactive_lesson', 1);
//        $this->db->where('lessons.running_page >', 0);
		$this->db->where('lessons.token IS NOT NULL');
		$query = $this->db->get();
			
		return $query->row();
	}

    public function delete($lesson_id = '' ){
		$this->db->where('id', $lesson_id);
		$this->db->delete($this->_table); 
	}
}
