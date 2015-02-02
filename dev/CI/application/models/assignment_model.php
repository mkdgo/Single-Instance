<?php

class Assignment_model extends CI_Model {

	private $_table = 'assignments';
	private $_table_assignments_resources = 'assignments_resources';
        private $_table_assignments_categories = 'assignments_grade_categories';
        private $_table_assignments_attributes = 'assignments_grade_attributes';
        private $_table_assignments_details = 'assignments_details';

        

	public function __construct() {
		parent::__construct();
	}

	public function save($data = array(), $id = '', $escape = TRUE) {

              
                if($id)
                {
                	if ($escape) {
				$this->db->set($data);
			} else {
				foreach ($data as $key => $value) {
					$this->db->set($key, $value, FALSE);
				}
			}
			$this->db->where('id', $id);
			$this->db->update($this->_table);
                }
                else
                {
                	$this->db->insert($this->_table, $data);
			$id = $this->db->insert_id();
                }
		
		if (isset($data['base_assignment_id']) && $data['base_assignment_id'] == 0) {
			// insert assignments from the new class
              
                        $this->db->update($this->_table, array('active' => 0), array('base_assignment_id' => $id)); 

                        $this->db->from('student_classes');
                        $this->db->where('student_classes.class_id IN ('.$data['class_id'].')');

                        $students = $this->db->get()->result();


                        foreach($students as $STUDENT)
                        {    
                            $checker = $this->db->get_where($this->_table, array('base_assignment_id' => $id, 'student_id'=>$STUDENT->student_id, 'class_id'=>$STUDENT->class_id))->row();

                            if($checker)
                            {
                                $this->db->query('
                                        UPDATE
                                                assignments 
                                                SET 
                                                title='.$this->db->escape($data['title']).',
                                                intro='.$this->db->escape($data['intro']).',
                                                grade_type='.$this->db->escape($data['grade_type']).',
                                                deadline_date='.$this->db->escape($data['deadline_date']).',
                                                active=1
                                                WHERE
                                                base_assignment_id='.$id.' AND
                                                student_id='.$STUDENT->student_id.' AND
                                                class_id="'.$STUDENT->class_id.'"'                                   
                                  );
                            }else
                            {
                                $this->db->query('
                                        INSERT INTO
                                                assignments 
                                                SET 
                                                base_assignment_id='.$this->db->escape($id).',
                                                teacher_id='.$this->db->escape($data['teacher_id']).',
                                                student_id='.$STUDENT->student_id.',
                                                class_id='.$STUDENT->class_id.',
                                                title='.$this->db->escape($data['title']).',
                                                intro='.$this->db->escape($data['intro']).',
                                                grade_type='.$this->db->escape($data['grade_type']).',
                                                deadline_date='.$this->db->escape($data['deadline_date']).',
                                                active=1'
                                  );
                            }
                        }
                 
		}
                
                if($data['publish']==0) $this->db->update($this->_table, array('active' => 0), array('base_assignment_id' => $id)); 
				
		return $id;
	}

	public function get_assignment($id) {
		$query = $this->db->get_where($this->_table, array('id' => $id, 'active' => '1'));
		return $query->row();
	}

	public function assignment_exist($id) {
		$query = $this->db->get_where($this->_table, array('id' => $id));

		return $query->num_rows();
	}
        
        public function get_draftSubmissions()
        {
            $query = $this->db->get_where($this->_table, array('base_assignment_id !='=>'0', 'publish'=>0, 'deadline_date < '=>'NOW()'));
            
            return $query->result();
            
        }

	public function get_assignments($where = array()) {
		$sql = '
			SELECT 
				*
			FROM
				(SELECT
					a1.*, 
					subjects.name AS subject_name,
					(SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.active = 1) AS total,
					(SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.active = 1  AND a2.publish >= 1) AS submitted,
					(SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.grade != \'\' AND a2.active >= 1 AND a2.publish >= 1) AS marked
				FROM
					assignments a1
                                        LEFT JOIN classes ON classes.id IN (a1.class_id)
					LEFT JOIN subjects ON subjects.id = classes.subject_id
				WHERE
					active = 1) ss
			WHERE
		';
		//
                
		$sql .= implode(' AND ', $where);
		
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	public function get_student_assignments($assignment_id) {
		$this->db->select('assignments.id,
                        assignments.publish,
			assignments.submitted_date > 0 AS submitted, 
			assignments.submitted_date < assignments.deadline_date AS submitted_on_time, 
			assignments.grade_type, 
			assignments.grade, 
			users.first_name, 
			users.last_name
		', FALSE);
	
		$this->db->from('assignments');
		$this->db->join('users', 'users.id = assignments.student_id', 'inner');		
	
		$this->db->where(array(
			'base_assignment_id' => $assignment_id,
			'active' => '1'
		));
		$query = $this->db->get();

		return $query->result();	
	}
        
        public function get_assignment_categories($assignment_id) {
            $this->db->select('
                        assignment_id,
                        category_marks,
                        category_name
		', FALSE);
	
		$this->db->from($this->_table_assignments_categories);	
	
		$this->db->where(array(
			'assignment_id' => $assignment_id
		));
                
		$query = $this->db->get();

		return $query->result();
        }
        
         public function get_assignment_attributes($assignment_id) {
            $this->db->select('
                        assignment_id,
                        attribute_marks,
                        attribute_name
		', FALSE);
	
		$this->db->from($this->_table_assignments_attributes);	
	
		$this->db->where(array(
			'assignment_id' => $assignment_id
		));
                
		$query = $this->db->get();

		return $query->result();
        }
        
        
        
        public function update_assignment_categories($assignment_id, $categories, $grade_type)
        {
              $this->db->where('assignment_id', $assignment_id);
              $this->db->delete($this->_table_assignments_categories);
              
             // if($grade_type=='grade')
              //{     
                  foreach($categories as$k=>$c)
                  {
                      $data = array(
                          'category_marks'=>$c->category_marks,
                          'category_name'=>$c->category_name,
                          'assignment_id'=>$assignment_id
                      );
                      
                      $this->db->insert($this->_table_assignments_categories, $data);
                  }
              //}
        }
        
        public function update_assignment_attributes($assignment_id, $attributes, $grade_type)
        {
              $this->db->where('assignment_id', $assignment_id);
              $this->db->delete($this->_table_assignments_attributes);
              
              if($grade_type=='grade' || true)
              { 
                  foreach($attributes as$k=>$a)
                  {
                      $data = array(
                          'attribute_marks'=>$a->attribute_marks,
                          'attribute_name'=>$a->attribute_name,
                          'assignment_id'=>$assignment_id
                      );
                      
                      $this->db->insert($this->_table_assignments_attributes, $data);
                  }
             }
        }
        
        
          public function get_teacher_classes_assigment($teacher_id, $subject_id, $year) {
		$this->db->select('subjects.name AS subject_name, classes.id, classes.year, classes.group_name');
	
		$this->db->from('teacher_classes');
		$this->db->join('classes', 'classes.id = teacher_classes.class_id', 'inner');		
		$this->db->join('subjects', 'subjects.id = classes.subject_id', 'inner');		
		$this->db->join('users', 'users.id = teacher_classes.teacher_id', 'inner');

		$this->db->where('users.user_type', 'teacher');
		$this->db->where('users.id', $teacher_id);
                $this->db->where('subjects.id', $subject_id);
                $this->db->where('classes.year', $year);
                
		$this->db->order_by('subjects.name, classes.year, classes.group_name');
		$query = $this->db->get();
		
		return $query->result();		
	}
        
         public function get_teacher_years_assigment($teacher_id) {
		$this->db->select('classes.year');
	
		$this->db->from('teacher_classes');
		$this->db->join('classes', 'classes.id = teacher_classes.class_id', 'inner');		
		$this->db->join('users', 'users.id = teacher_classes.teacher_id', 'inner');

		$this->db->where('users.user_type', 'teacher');
		$this->db->where('users.id', $teacher_id);
                $this->db->group_by(array("classes.year"));
		$this->db->order_by('classes.year');
		$query = $this->db->get();
		
		return $query->result();		
	}
        
        public function get_teacher_subjects_assigment($teacher_id, $year) {
		$this->db->select('subjects.name AS subject_name, subjects.id AS subject_id');
	
                $this->db->from('teacher_classes');
		$this->db->join('classes', 'classes.id = teacher_classes.class_id', 'inner');		
		$this->db->join('subjects', 'subjects.id = classes.subject_id', 'inner');		
		$this->db->join('users', 'users.id = teacher_classes.teacher_id', 'inner');

		$this->db->where('users.user_type', 'teacher');
		$this->db->where('users.id', $teacher_id);
                $this->db->where('classes.year', $year);
                
                $this->db->group_by(array("classes.year","subjects.id"));
                
		$this->db->order_by('classes.year');
                
		$query = $this->db->get();
		
                $data = $query->result();
                
                
		return 	$data;	
	}
        
        public function get_student_assignments_active($student_id)
        {
		//$this->db->select('*');
                $this->db->from($this->_table);
		$this->db->where('student_id', $student_id);
		$this->db->where('active', 1);
                $this->db->where('publish', 0);
                $this->db->group_by(array("base_assignment_id"));
                $this->db->order_by('title');
                $query = $this->db->get();
		$data = $query->result();
                return 	$data;	
	}
        
        public function get_assignment_details($assignment_id, $type)
        {
            $this->db->from($this->_table_assignments_details);
            $this->db->where('assignment_id', $assignment_id);
            $this->db->where('assignment_detail_type', $type);
            $query = $this->db->get();
            $data = $query->result();
            return $data;	
        }
         
        public function save_assignment_details($assignment_id, $type, $val)
        {
                $detail_exist = $this->get_assignment_details($assignment_id, $type);
            
                if($detail_exist)
                {
                        $this->db->update($this->_table_assignments_details, array('assignment_detail_value' => $val), array('id' => $detail_exist[0]->id)); 
                }
                else
                {
                        $this->db->insert($this->_table_assignments_details, array('assignment_detail_value' => $val, 'assignment_id' => $assignment_id, 'assignment_detail_type' => $type)); 
                }
         }
        
        
}