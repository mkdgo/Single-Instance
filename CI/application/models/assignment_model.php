<?php

    class Assignment_model extends CI_Model {

        private $_table = 'assignments';
        private $_table_assignments_resources = 'assignments_resources';
        private $_table_assignments_categories = 'assignments_grade_categories';
        private $_table_assignments_attributes = 'assignments_grade_attributes';
        private $_table_assignments_details = 'assignments_details';
        private $_table_assignments_marks = 'assignments_marks';




        public function __construct() {
            parent::__construct();
        }

        public function save($data = array(), $id = '', $escape = TRUE) {

            if($id) {
                if ($escape) {
                    $this->db->set($data);
                } else {
                    foreach ($data as $key => $value) {
                        $this->db->set($key, $value, FALSE);
                    }
                }
                $this->db->where('id', $id);
                $this->db->update($this->_table);
            } else {
                $this->db->insert($this->_table, $data);
                $id = $this->db->insert_id();
            }

            if (isset($data['base_assignment_id']) && $data['base_assignment_id'] == 0) {
                // insert assignments from the new class

                $this->db->update($this->_table, array('active' => 0), array('base_assignment_id' => $id)); 

                $this->db->distinct();
                $this->db->from('student_classes');
                $this->db->where('student_classes.class_id IN ('.$data['class_id'].')');
                $this->db->group_by('student_id');
                
                $students = $this->db->get()->result();


                foreach($students as $STUDENT){    
                    $checker = $this->db->get_where($this->_table, array('base_assignment_id' => $id, 'student_id'=>$STUDENT->student_id, 'class_id'=>$STUDENT->class_id))->row();

                    if($checker) {
                        $this->db->query('
                            UPDATE
                            assignments 
                            SET 
                            title='.$this->db->escape($data['title']).',
                            intro='.$this->db->escape($data['intro']).',
                            grade_type='.$this->db->escape($data['grade_type']).',
                            deadline_date='.$this->db->escape($data['deadline_date']).',
                            active=1,
                            publish_marks='.$this->db->escape($data['publish_marks']).'
                            WHERE
                            base_assignment_id='.$id.' AND
                            student_id='.$STUDENT->student_id.' AND
                            class_id="'.$STUDENT->class_id.'"'                                   
                        );
                    }else {
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
                            active=1,
                            publish_marks=0'
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

        public function get_draftSubmissions()  {
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
            (SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.active = 1 AND a2.publish >= 1 AND a2.grade != 0 AND a2.grade != "") AS marked
            FROM
            assignments a1
            LEFT JOIN classes ON classes.id IN (a1.class_id)
            LEFT JOIN subjects ON subjects.id = classes.subject_id
            LEFT JOIN assignments_marks ON assignments_marks.assignment_id = a1.id
            WHERE
            active = 1) ss
            WHERE
            ';
            //

            $sql .= implode(' AND ', $where);

            $query = $this->db->query($sql);
//echo $this->db->last_query();
            //die();
            return $query->result();
        }

        public function get_assignments_student( $studentid, $where=array() ) {
            $sql = 'SELECT A.*, PA.publish as parent_publish FROM assignments A LEFT JOIN assignments PA ON A.base_assignment_id=PA.id WHERE A.student_id='.$studentid.'';
            //

            $WHERE_condition = '';
            $WHERE_condition = implode(' AND ', $where);
            if($WHERE_condition != '')$WHERE_condition = ' AND '.$WHERE_condition;

            $sql .= $WHERE_condition;

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

        public function get_student_assignment_mark($student_assignment_id) {

        }

        public function get_assignment_categories($assignment_id) {
            $this->db->select('
                assignment_id,
                category_marks,
                category_name,
                id
                ', FALSE);

            $this->db->from($this->_table_assignments_categories);	

            $this->db->where(array(
                    'assignment_id' => $assignment_id
                ));

            $query = $this->db->get();

            return $query->result();
        }

        public function get_assignment_attributes($assignment_id) {
            $this->db->select(' assignment_id, attribute_marks, attribute_name', FALSE);
            $this->db->from($this->_table_assignments_attributes);	
            $this->db->where(array( 'assignment_id' => $assignment_id ));
            $this->db->order_by('attribute_marks', 'desc');
            $query = $this->db->get();

            return $query->result();
        }


        public function update_assignment_categories($assignment_id, $categories, $grade_type) {
            //$this->db->where('assignment_id', $assignment_id);
            //$this->db->delete($this->_table_assignments_categories);

            // if($grade_type=='grade')
            //{     

            $real_ids = array(-1);
            foreach( $categories as $k => $c ) {
                $cat_name = trim( $c->category_name );
                if( $c->category_marks > 0 && !empty( $cat_name ) ) {
                    $data = array(
                        'category_marks'=>$c->category_marks,
                        'category_name'=>$c->category_name,
                        'assignment_id'=>$assignment_id
                    );

                    if($c->id) {
                        $this->db->update($this->_table_assignments_categories, $data, array('id' => $c->id)); 
                        $real_ids[] = $c->id;
                    }else {
                        $this->db->insert($this->_table_assignments_categories, $data);
                        $real_ids[]=$this->db->insert_id();
                    }
                }
            }

            $del_ids = implode(',', $real_ids);

            $this->db->where(array('assignment_id' => $assignment_id));
            $this->db->where('id NOT IN ('.$del_ids.')');
            $this->db->delete($this->_table_assignments_categories);

            //}
        }

        public function update_assignment_attributes($assignment_id, $attributes, $grade_type) {
            $this->db->where('assignment_id', $assignment_id);
            $this->db->delete($this->_table_assignments_attributes);

            if($grade_type=='grade' || true) { 
                foreach($attributes as $k=>$a) {
                    $data = array(
                        'attribute_marks'=>$a->attribute_marks,
                        'attribute_name'=>$a->attribute_name,
                        'assignment_id'=>$assignment_id
                    );

                    $this->db->insert($this->_table_assignments_attributes, $data);
                }
            }
        }

        public function update_assignment_mark($id, $data) {
            if($id==-1) {
                $this->db->insert($this->_table_assignments_marks, $data);
                $newid = $this->db->insert_id();
            }else {
                $this->db->update($this->_table_assignments_marks, $data, array('id' => $id)); 
                $newid = $id;      
            }

            return $newid;
        }

        public function calculateAttainment($M_average, $M_avail, $base_assignment) {
            if($M_avail==0)$percent = 0;else $percent = round( ($M_average/$M_avail)*100 );

            if($M_average==0)return '-';

            if($base_assignment->grade_type=='grade') {
                $grades = $this->get_assignment_attributes($base_assignment->id); 
                if(!empty($grades)) {
                    $c=count($grades)-1;
                    foreach($grades as $k=>$v) {
                        if($v->attribute_marks<=$percent) {
                            $c=$k-1;
                            if($c<0)$c=0;
                            break;
                        }
                    }
                    $attainment = $grades[$c]->attribute_name;
                }else {
                    $attainment = '';
                }
            }elseif($base_assignment->grade_type=='percentage') {
                $attainment = $percent.'%';
            }elseif($base_assignment->grade_type=='mark_out_of_10') {
                $xval = round( $percent/10 );
                if($xval==0)$xval=1;
                $attainment = $xval.' out of 10';
            }else {
                $attainment = $M_average.'/'.$M_avail;
            }

            return $attainment;
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

        public function get_teacher_years_assigment($teacher_id,$in=false) {
            $this->db->select('classes.year,classes.id as class_id,GROUP_CONCAT(classes.subject_id SEPARATOR ",") as subjects_ids',false);

            $this->db->from('teacher_classes');
            $this->db->join('classes', 'classes.id = teacher_classes.class_id', 'inner');		
            $this->db->join('users', 'users.id = teacher_classes.teacher_id', 'inner');

            $this->db->where('users.user_type', 'teacher');
            if($teacher_id!='all') {
                $this->db->where('users.id', $teacher_id);
            }
            if($in !=false) {
                $this->db->where('classes.id IN (' . $in . ')');
            }
            $this->db->group_by(array("classes.year"));
            $this->db->order_by('classes.year');
            $query = $this->db->get();
//echo  $this->db->last_query();
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
//echo $this->db->last_query();
            $data = $query->result();


            return 	$data;	
        }

        public function get_teacher_year_letters_assigment($teacher_id, $year,$subjects_ids) {
            $this->db->select('subjects.name AS subject_name, subjects.id ,subject_id,year, classes.group_name');

            $this->db->from('teacher_classes');
            $this->db->join('classes', 'classes.id = teacher_classes.class_id', 'inner');
            $this->db->join('subjects', 'subjects.id = classes.subject_id', 'inner');
            $this->db->join('users', 'users.id = teacher_classes.teacher_id', 'inner');

            $this->db->where('users.user_type', 'teacher');
            $this->db->where('users.id', $teacher_id);
            $this->db->where('classes.year', $year);
            $this->db->where('classes.subject_id IN ('.$subjects_ids.') ');
            //$this->db->group_by(array("classes.year","subjects.id"));

            $this->db->order_by('classes.year','asc');

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

        public function get_resource_mark($resource_id)
        {
            $this->db->from($this->_table_assignments_marks);
            $this->db->where('resource_id', $resource_id);
            $query = $this->db->get();
            $data = $query->result();
            return $data;	
        }

        public function get_mark($mark_id)
        {
            $this->db->from($this->_table_assignments_marks);
            $this->db->where('id', $mark_id);
            $query = $this->db->get();
            $data = $query->result();
            return $data;	
        }

        public function remove_all_marks($base_assignment_id)
        {
            $this->db->select('id');
            $this->db->from($this->_table);
            $this->db->where('base_assignment_id', $base_assignment_id);
            $query = $this->db->get();
            $data = $query->result();
            $dataids = array(-1);

            foreach($data as $k=>$v)$dataids[]=$v->id;

            $this->db->where('assignment_id IN ('.implode(',', $dataids).')');
            $this->db->delete($this->_table_assignments_marks);

            foreach($data as $k=>$v)$this->refresh_assignment_marked_status($v->id);

            return $this->db->last_query();
        }


        public function refresh_assignment_marked_status($assignment_id)
        {
            $query = $this->db->query('SELECT SUM(total_evaluation) AS submission_mark FROM '.$this->_table_assignments_marks.' WHERE assignment_id='.$assignment_id);
            $result = $query->result();

            $submission_marked = 0;
            if($result[0]->submission_mark!=0)$submission_marked=1;

            $this->db->update($this->_table, array('grade'=>$submission_marked), array('id' => $assignment_id)); 
        }

        public function labelsAssigmnetType($v)
        {
            $labels = array(
                'grade'=>'Grade',
                'free_text'=>'Free Text',
                'percentage'=>'Percentage'
            );

            if($V=='*')return $labels;else return $labels[$v];
        }


                        public function get_assigned_year($id)
        {
            $this->db->select('assignments.class_id,classes.*,subjects.name');
            $this->db->from('assignments');
            $this->db->join('classes','assignments.class_id=classes.id');
            $this->db->join('subjects','subjects.id=classes.subject_id');
            $this->db->where('assignments.id',$id);
            $q = $this->db->get();
            return $q->row_array();
        }


        public function get_assigned_classes($id)
        {
            $this->db->select('assignments.class_id,classes.*');
            $this->db->from('assignments');
            $this->db->join('classes','assignments.class_id=classes.id');

            $this->db->where('assignments.id',$id);
            $q = $this->db->get();
            return $q->row_array();
        }


        public function delete_assignment($id)
        {

            $this->db->where('id',$id);
            $this->db->delete('assignments');

            $this->db->where('assignment_id',$id);
            $this->db->delete('assignments_details');

            $this->db->where('assignment_id',$id);
            $this->db->delete('assignments_grade_attributes');

            $this->db->where('assignment_id',$id);
            $this->db->delete('assignments_grade_categories');

            $this->db->where('assignment_id',$id);
            $this->db->delete('assignments_marks');

            $this->db->where('assignment_id',$id);
            $this->db->delete('assignments_resources');

            return true;
        }


    }
