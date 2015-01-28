<?php

class Interactive_assessment_model extends CI_Model {

	private $_table = 'questions';
	private $_answers_table = 'answers';
	private $_int_assessments_table = 'interactive_assessments_slides';

	public function __construct() {
		parent::__construct();
	}

	public function create_int_assessment($data = array()) {
		$this->db->insert($this->_int_assessments_table, $data);
	}

	public function save_temp_data($data = array(), $assesment_id = '') {
		$this->db->where('id', $assesment_id);
		$this->db->update($this->_int_assessments_table, $data);
	}

	public function save_question($data = array()) {
		//log_message('error', implode(", ", $data));
		$this->db->insert($this->_table, $data);
		return $this->db->insert_id();
	}

	public function save_answer($data = array(), $id = '') {
		if ($id) {
			$this->db->update($this->_answers_table, $data, array('id' => $id));
		} else {
			$this->db->insert($this->_answers_table, $data);
			$id = $this->db->insert_id();
		}
		return $id;
	}

	public function answer_exist($id, $question_id = '') {
		$query = $this->db->get_where($this->_answers_table, array('id' => $id, 'question_id' => $question_id));

		return $query->num_rows();
	}

	public function delete($int_assessment_id = '') {
		$this->db->where('id', $int_assessment_id);
		$this->db->delete($this->_table);
	}
	public function get_ia_temp_data($assessment_id = ''){
		$this->db->select('temp_data');
		$this->db->from($this->_int_assessments_table);
		$this->db->where('id', $assessment_id);
		$query = $this->db->get();
		if(isset($query->row()->temp_data)){
			
		return $query->row()->temp_data;
		}else{
			return false;
		}
	}
	public function get_ia_questions($int_assessment_id = '') {

		$query = $this->db->get_where($this->_table, array('int_assessment_id' => $int_assessment_id));

		return $query->result();
	}

	public function get_ia_answers($question_id = '') {

		$query = $this->db->get_where($this->_answers_table, array('question_id' => $question_id));

		return $query->result();
	}

	public function delete_questions($int_assessment_id = '') {
		$this->db->where('int_assessment_id', $int_assessment_id);
		$this->db->delete($this->_table);
	}

	public function delete_int_assessment($int_assessment_id = '') {
		$this->db->where('id', $int_assessment_id);
		$this->db->delete($this->_int_assessments_table);
	}
        
        public function delete_answers($question_id = '') {
		$this->db->where('question_id', $question_id);
		$this->db->delete($this->_answers_table);
	}

        
}
