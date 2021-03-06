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
            $this->config->load('upload');
        }

        public function save($data = array(), $id = '', $escape = TRUE) {
            if( $id ) {
                if( $escape ) {
                    $this->db->set($data);
                } else {
                    foreach( $data as $key => $value ) {
                        $this->db->set($key, $value, FALSE);
                    }
                }
                $this->db->where('id', $id);
                $this->db->update($this->_table);
            } else {
                $data['created_date'] = date('Y-m-d H:i:s');
                $this->db->insert($this->_table, $data);
                $id = $this->db->insert_id();
            }

            if( isset( $data['class_id'] ) ) {
                $this->db->distinct();
                $this->db->from('student_classes');
                $this->db->where('student_classes.class_id IN ('.$data['class_id'].')');
                $this->db->group_by('student_id');
                $students = $this->db->get()->result();

                if( isset($data['base_assignment_id']) && $data['base_assignment_id'] == 0 && $data['publish'] == 1 ) {
                    // insert assignments from the new class

                    foreach( $students as $STUDENT ){
                        $checker = $this->db->get_where($this->_table, array('base_assignment_id' => $id, 'student_id' => $STUDENT->student_id ) )->row();
//                        $checker = $this->db->get_where($this->_table, array('base_assignment_id' => $id, 'student_id' => $STUDENT->student_id, 'class_id' => $STUDENT->class_id) )->row();

                        if( $checker ) {
                            $this->db->query('
                                UPDATE assignments 
                                SET 
                                title = '.$this->db->escape($data['title']).',
                                intro = '.$this->db->escape($data['intro']).',
                                grade_type = '.$this->db->escape($data['grade_type']).',
                                deadline_date = '.$this->db->escape($data['deadline_date']).',
                                active = '.$checker->active.',
                                exempt = '.$checker->exempt.',
                                publish_marks = '.$this->db->escape($data['publish_marks']).',
                                publish_date = '.$this->db->escape($data['publish_date']).'
                                WHERE
                                base_assignment_id = '.$id.' AND
                                student_id = '.$STUDENT->student_id.' AND
                                class_id = "'.$STUDENT->class_id.'"'                                   
                            );
                            $assignment_id = $checker->id;
                        } else {
                            $this->db->query('
                                INSERT INTO assignments 
                                SET 
                                base_assignment_id = '.$this->db->escape($id).',
                                teacher_id = '.$this->db->escape($data['teacher_id']).',
                                student_id = '.$STUDENT->student_id.',
                                class_id = '.$STUDENT->class_id.',
                                title = '.$this->db->escape($data['title']).',
                                intro = '.$this->db->escape($data['intro']).',
                                grade_type = '.$this->db->escape($data['grade_type']).',
                                deadline_date = '.$this->db->escape($data['deadline_date']).',
                                active = 0,
                                exempt = 0,
                                publish_marks = 0, 
                                publish_date = '.$this->db->escape($data['publish_date']).', 
                                created_date = "'.date("Y-m-d H:i:s").'"'
                            );
                            $assignment_id = $this->db->insert_id();
                            $json_visual_data = array();
                                $json_visual_data[] = array(
                                "items" => array(),
                                "picture" => false
                            );
                            $data_mark = array(
                                'screens_data' => json_encode($json_visual_data),
                                'resource_id' => 0,
                                'assignment_id' => $assignment_id,
                                'pagesnum' => 0,
                                'total_evaluation' => 0
                            );
                            $mark_id = $this->update_assignment_mark(-1, $data_mark);
                        }
                    }
                } else {
                    foreach( $students as $STUDENT ){
                        $checker = $this->db->get_where($this->_table, array('base_assignment_id' => $id, 'student_id' => $STUDENT->student_id, 'class_id' => $STUDENT->class_id) )->row();
                        if( $checker ) {
                            $assignment_id = $checker->id;
                            $this->db->where('id', $assignment_id);
                            $this->db->delete('assignments');
                            $this->db->flush_cache();
                            $this->db->where('assignment_id', $assignment_id);
                            $this->db->delete('assignments_marks');
                            $this->db->flush_cache();
                        }
                    }
                }
            }
            if( isset( $data['student_id'] ) && $data['student_id'] != '' ) {
                $students = explode( ',', $data['student_id'] );

/*                $this->db->distinct();
                $this->db->from('student_classes');
                $this->db->where('student_classes.class_id IN ('.$data['class_id'].')');
                $this->db->group_by('student_id');
                $students = $this->db->get()->result();
*/
                if( isset($data['base_assignment_id']) && $data['base_assignment_id'] == 0 && $data['publish'] == 1 ) {
                    // insert assignments from the new class

                    foreach( $students as $STUDENT ){
                        $checker = $this->db->get_where($this->_table, array('base_assignment_id' => $id, 'student_id' => $STUDENT ) )->row();
//                        $checker = $this->db->get_where($this->_table, array('base_assignment_id' => $id, 'student_id' => $STUDENT->student_id, 'class_id' => $STUDENT->class_id) )->row();

                        if( $checker ) {
                            $this->db->query('
                                UPDATE assignments 
                                SET 
                                title = '.$this->db->escape($data['title']).',
                                intro = '.$this->db->escape($data['intro']).',
                                grade_type = '.$this->db->escape($data['grade_type']).',
                                deadline_date = '.$this->db->escape($data['deadline_date']).',
                                active = '.$checker->active.',
                                exempt = '.$checker->exempt.',
                                publish_marks = '.$this->db->escape($data['publish_marks']).',
                                publish_date = '.$this->db->escape($data['publish_date']).'
                                WHERE
                                base_assignment_id = '.$id.' AND
                                student_id = '.$STUDENT
                            );
                            $assignment_id = $checker->id;
                        } else {
                            $this->db->query('
                                INSERT INTO assignments 
                                SET 
                                base_assignment_id = '.$this->db->escape($id).',
                                teacher_id = '.$this->db->escape($data['teacher_id']).',
                                student_id = '.$STUDENT.',
                                class_id = "",
                                title = '.$this->db->escape($data['title']).',
                                intro = '.$this->db->escape($data['intro']).',
                                grade_type = '.$this->db->escape($data['grade_type']).',
                                deadline_date = '.$this->db->escape($data['deadline_date']).',
                                active = 0,
                                exempt = 0,
                                publish_marks = 0, 
                                publish_date = '.$this->db->escape($data['publish_date']).', 
                                created_date = "'.date("Y-m-d H:i:s").'"'
                            );
                            $assignment_id = $this->db->insert_id();
                            $json_visual_data = array();
                                $json_visual_data[] = array(
                                "items" => array(),
                                "picture" => false
                            );
                            $data_mark = array(
                                'screens_data' => json_encode($json_visual_data),
                                'resource_id' => 0,
                                'assignment_id' => $assignment_id,
                                'pagesnum' => 0,
                                'total_evaluation' => 0
                            );
                            $mark_id = $this->update_assignment_mark(-1, $data_mark);
                        }
                    }
                } else {
                    foreach( $students as $STUDENT ){
                        $checker = $this->db->get_where($this->_table, array('base_assignment_id' => $id, 'student_id' => $STUDENT) )->row();
                        if( $checker ) {
                            $assignment_id = $checker->id;
                            $this->db->where('id', $assignment_id);
                            $this->db->delete('assignments');
                            $this->db->flush_cache();
                            $this->db->where('assignment_id', $assignment_id);
                            $this->db->delete('assignments_marks');
                            $this->db->flush_cache();
                        }
                    }
                }
            }
            return $id;
        }

        public function insert_assignment_resource($resource_id, $assignment_id) {
            $this->db->set('resource_id', $resource_id);
            $this->db->set('assignment_id', $assignment_id);
            $this->db->set('is_late', 0);
            
            $this->db->insert($this->_table_assignments_resources);
        }

        public function get_assignment($id) {
            $query = $this->db->get_where($this->_table, array('id' => $id ));
            return $query->row();
        }

        public function assignment_exist($id) {
            $query = $this->db->get_where($this->_table, array('id' => $id));

            return $query->num_rows();
        }

        public function get_draftSubmissions()  {
            $query = $this->db->get_where($this->_table, array('base_assignment_id !=' => '0', 'publish' => 0, 'deadline_date < ' => 'NOW()'));

            return $query->result();
        }

        public function get_assignments($where = array(), $or_where = array(), $type = null, $teacher_id = 0 ) {

            $sql_filter = "SELECT * FROM assignments_filter WHERE ";
            $sql_filter .= implode(' AND ', $where);
            if( count( $or_where ) ) {
                $sql_filter .= ' OR ('.implode(' AND ',$or_where).')';
            }
            $query = $this->db->query($sql_filter);
//echo $this->db->last_query();die;
            $result = $query->result();
            $query->free_result();
            
            return $result;
        }

        public function get_assignments_student( $studentid, $where = array(), $or_where = array() ) {
            $date_format = "'%a %D% %b %Y, %H:%i'";
            $sql = 'SELECT A.*,subjects.name subject_name, PA.status as status, PA.publish as parent_publish, DATE_FORMAT(A.deadline_date,'.$date_format.')as user_deadline_date 
                FROM assignments A 
                LEFT JOIN assignments_filter PA ON A.base_assignment_id=PA.id
                LEFT JOIN classes ON classes.id IN (A.class_id)
                LEFT JOIN subjects ON subjects.id = classes.subject_id
                WHERE A.student_id='.$studentid.' AND A.base_assignment_id != 0';
            //

            $WHERE_condition = '';
            $WHERE_condition = implode(' AND ', $where);
            if( $WHERE_condition != '' ) { $WHERE_condition = ' AND '.$WHERE_condition; }

            $sql .= $WHERE_condition;
            if( count( $or_where ) ) {
                $sql .= ' OR ('.implode(' AND ',$or_where).')';
            }
            $sql .= ' ORDER BY PA.order_weight ASC, A.deadline_date DESC';
            $query = $this->db->query($sql);
//echo $sql;die;
            $r = $query->result();

            return $r;
        }

        public function get_student_assignments($assignment_id) {
            $this->db->select('assignments.id,
                assignments.publish,
                assignments.active,
                assignments.exempt,
                assignments.submitted_date > 0 AS submitted, 
                assignments.submitted_date < assignments.deadline_date AS submitted_on_time, 
                assignments.grade_type, 
                assignments.grade, 
                assignments.student_id,
                assignments.class_id,
                users.first_name, 
                users.last_name
                ', FALSE);

            $this->db->from('assignments');
            $this->db->join('users', 'users.id = assignments.student_id', 'inner');		

            $this->db->where(array( 'base_assignment_id' => $assignment_id ));
/*
            $this->db->where(array(
                    'base_assignment_id' => $assignment_id,
                    'active' => '1'
                ));
//*/
            $query = $this->db->get();

            return $query->result();	
        }

        public function get_student_assignment_mark($student_assignment_id) {
            $this->db->select();
            $this->db->from('assignments_marks');
            $this->db->join( 'assignments_resources', 'assignments_resources.resource_id = assignments_marks.resource_id', 'LEFT');
            $this->db->join( 'resources', 'resources.id = assignments_resources.resource_id');
            $this->db->where('assignments_marks.assignment_id', $student_assignment_id);
            $query = $this->db->get();
//echo $this->db->last_query();
            return $query->result();

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

        public function get_assignment_resources($assignment_id) {        }

        public function add_overall_category( $assignment_id ) {
            $data = array(
                'category_marks' => 0,
                'category_name' => 'overall',
                'assignment_id' => $assignment_id
            );

            $this->db->insert($this->_table_assignments_categories, $data);
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
                        'category_marks' => $c->category_marks,
                        'category_name' => $c->category_name,
                        'assignment_id' => $assignment_id
                    );

                    if( $c->id ) {
                        $this->db->update($this->_table_assignments_categories, $data, array('id' => $c->id)); 
                        $real_ids[] = $c->id;
                    } else {
                        $this->db->insert($this->_table_assignments_categories, $data);
                        $real_ids[] = $this->db->insert_id();
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

        public function update_assignment_mark($id, $publish_marks) {
            if( $id == -1 ) {
                $this->db->insert($this->_table_assignments_marks, $publish_marks);
                $newid = $this->db->insert_id();
            } else {
                $this->db->update($this->_table_assignments_marks, $publish_marks, array('id' => $id)); 
                $newid = $id;      
            }
            return $newid;
        }

        public function calculateAttainment($M_average, $M_avail, $base_assignment, $submitted = 0 ) {
//echo '<pre>'; var_dump( $base_assignment->grade_type );die;
            if( $M_avail == 0 ) { $percent = 0; } else { $percent = round( ($M_average/$M_avail)*100 ); }
            if( $M_average == 0 ) { 
                if( $submitted ) {
                    if($base_assignment->grade_type == 'grade') {
                        $attainment = '';
                    } elseif( $base_assignment->grade_type == 'percentage') {
                        $attainment = '0%';
                    } elseif( $base_assignment->grade_type == 'mark_out_of_10') {
                        $attainment = '0 out of 10';
                    } elseif( $base_assignment->grade_type == 'offline') {
                        $attainment = $M_average;
                    } else {
                        $attainment = '0/'.$M_avail;
                    }
                    return $attainment;
                } else {
                    return '';
                }
            } else {
                if($base_assignment->grade_type == 'grade') {
                    $grades = $this->get_assignment_attributes($base_assignment->id); 
                    if(!empty($grades)) {
                        $c = count($grades)-1;
                        foreach( $grades as $k => $v ) {
                            if( $v->attribute_marks <= $percent ) {
                                $c = $k-1;
                                if( $c < 0 ) { $c = 0; }
                                break;
                            }
                        }
                        $attainment = $grades[$c]->attribute_name;
                    } else {
                        $attainment = '';
                    }
                } elseif( $base_assignment->grade_type == 'percentage') {
                    $attainment = $percent.'%';
                } elseif( $base_assignment->grade_type == 'mark_out_of_10') {
                    $xval = round( $percent/10 );
                    if( $xval == 0 ) $xval=1;
                    $attainment = $xval.' out of 10';
                } elseif( $base_assignment->grade_type == 'offline') {
                    $attainment = $M_average;
                } else {
                    $attainment = $M_average.'/'.$M_avail;
                }
                return $attainment;
            }
        }

        public function get_teacher_classes_assigment($teacher_id, $subject_id, $year) {
            $this->db->select('subjects.name AS subject_name, classes.id, classes.year, classes.group_name');

            $this->db->from('teacher_classes');
            $this->db->join('classes', 'classes.id = teacher_classes.class_id', 'inner');		
            $this->db->join('subjects', 'subjects.id = classes.subject_id', 'inner');		
            $this->db->join('users', 'users.id = teacher_classes.teacher_id', 'inner');

            $this->db->where('users.user_type', 'teacher');
            if($teacher_id!='all') {
                $this->db->where('users.id', $teacher_id);
            }
            $this->db->where('subjects.id', $subject_id);
            $this->db->where('classes.year', $year);

            $this->db->order_by('subjects.name, classes.year, classes.group_name');
            $query = $this->db->get();

            return $query->result();		
        }

        public function get_teacher_years_assigment($teacher_id,$in=false) {
            $this->db->select('classes.year,classes.id as class_id,GROUP_CONCAT(classes.subject_id SEPARATOR ",") as subjects_ids, GROUP_CONCAT( classes.id SEPARATOR ", " ) AS cls_ids',false);

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
            if($teacher_id!='all') {
                $this->db->where('users.id', $teacher_id);
            }
            $this->db->where('classes.year', $year);

            $this->db->group_by(array("classes.year","subjects.id"));

            //$this->db->order_by('classes.year');
            $this->db->order_by('subject_name');

            $query = $this->db->get();
//echo $this->db->last_query();
            $data = $query->result();


            return 	$data;	
        }

        public function get_teacher_subjects_not_assigned($teacher_id, $year) {
            $this->db->select('subjects.name AS subject_name, subjects.id AS subject_id');

            $this->db->from('teacher_classes');
            $this->db->join('classes', 'classes.id = teacher_classes.class_id', 'inner');		
            $this->db->join('subjects', 'subjects.id = classes.subject_id', 'inner');		
            $this->db->join('users', 'users.id = teacher_classes.teacher_id', 'inner');

            $this->db->where('users.user_type', 'teacher');
            if($teacher_id!='all') {
                $this->db->where('users.id <>', $teacher_id);
            }
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

        public function getYearsAssigment() {
            $this->db->select('classes.year,classes.id as class_id,GROUP_CONCAT(classes.subject_id SEPARATOR ",") as subjects_ids',false);

            $this->db->from('classes');
//            if( $in != false ) {
//                $this->db->where('classes.id IN (' . $in . ')');
//            }
            $this->db->group_by(array("classes.year"));
            $this->db->order_by('classes.year');
            $query = $this->db->get();
//echo  $this->db->last_query();
            return $query->result();
        }

        public function getSubjectsAssigment( $year ) {
            $this->db->select('subjects.name AS subject_name, subjects.id AS subject_id');

            $this->db->from('classes');
            $this->db->join('subjects', 'subjects.id = classes.subject_id', 'inner');        
            $this->db->where('classes.year', $year);
            $this->db->where('subjects.publish', 1);
            $this->db->group_by(array("classes.year","subjects.id"));
            //$this->db->order_by('classes.year');
            $this->db->order_by('subject_name');
            $query = $this->db->get();
//echo $this->db->last_query();
            $data = $query->result();

            return  $data;
        }

        public function getClassesAssigment( $subject_id, $year ) {
            $this->db->select('subjects.name AS subject_name, classes.id, classes.year, classes.group_name');

            $this->db->from('classes');
            $this->db->join('subjects', 'subjects.id = classes.subject_id', 'inner');        

            $this->db->where('subjects.id', $subject_id);
            $this->db->where('classes.year', $year);

            $this->db->order_by('subjects.name, classes.year, classes.group_name');
            $query = $this->db->get();

            return $query->result();        
        }

        public function get_student_assignments_active($student_id) {
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

        public function get_assignment_details($assignment_id, $type) {
            $this->db->from($this->_table_assignments_details);
            $this->db->where('assignment_id', $assignment_id);
            $this->db->where('assignment_detail_type', $type);
            $query = $this->db->get();
            $data = $query->result();
            return $data;	
        }

        public function save_assignment_details($assignment_id, $type, $val) {
            $detail_exist = $this->get_assignment_details($assignment_id, $type);

            if($detail_exist) {
                $this->db->update($this->_table_assignments_details, array('assignment_detail_value' => $val), array('id' => $detail_exist[0]->id)); 
            } else {
                $this->db->insert($this->_table_assignments_details, array('assignment_detail_value' => $val, 'assignment_id' => $assignment_id, 'assignment_detail_type' => $type)); 
            }
        }

        public function get_resource_mark( $resource_id ) {
            $this->db->from($this->_table_assignments_marks);
            $this->db->where('resource_id', $resource_id);
            $query = $this->db->get();
            $data = $query->result();
            return $data;    
        }

        public function get_overall_marks( $assignment_id ) {
            $this->db->from($this->_table_assignments_marks);
            $this->db->where('assignment_id', $assignment_id);
            $this->db->where('resource_id', 0);
            $query = $this->db->get();
            $data = $query->result();
            return $data;	
        }

        public function get_mark($mark_id) {
            $this->db->from($this->_table_assignments_marks);
            $this->db->where('id', $mark_id);
            $query = $this->db->get();
            $data = $query->result();
            return $data;    
        }

        public function get_mark_submission($assignment_id) {
            $this->db->from($this->_table_assignments_marks);
            $this->db->where('assignment_id', $assignment_id);
            $this->db->where('resource_id', 0);
            $query = $this->db->get();
            $data = $query->result();
            return $data;	
        }

        public function remove_all_marks($base_assignment_id) {
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

        public function refresh_assignment_marked_status($assignment_id, $base_assignment_id = 0 ) {
            $query = $this->db->query('SELECT SUM(total_evaluation) AS submission_mark FROM '.$this->_table_assignments_marks.' WHERE assignment_id='.$assignment_id);
            $result = $query->result();

            $submission_marked = 0;
            if( $result[0]->submission_mark != 0 ) {
                $submission_marked = 1;
            }

            $this->db->update($this->_table, array('grade'=>$submission_marked), array('id' => $assignment_id));
            
            $query1 = $this->db->query('SELECT COUNT(id) AS marked FROM assignments WHERE base_assignment_id = '.$base_assignment_id.' AND grade = 1');
            $result1 = $query1->result();
            $marked = $result1[0]->marked;
            if( $marked ) {
                $this->db->update('assignments_filter', array('marked'=>$marked), array('id' => $base_assignment_id));
            }
        }

        public function update_marks_status( $assignment, $publish_marks ) {

//echo '<pre>';var_dump( $assignment );die;
            $this->db->update($this->_table, array('publish_marks' => $publish_marks), array('id' => $assignment->id));
            $this->db->update($this->_table, array('publish_marks' => $publish_marks), array('base_assignment_id' => $assignment->id));
            if( $publish_marks ) {
                $this->db->update('assignments_filter', array('publish_marks'=>$publish_marks, 'status' => 'closed', 'order_weight' => 5), array('id' => $assignment->id));
            } else {
                $row_status = 'draft';
                $row_order_weight = '4';
                if( $assignment->publish == 0 ) {
                    $row_status = 'draft';
                    $row_order_weight = '4';
                } elseif( $assignment->publish == 1 && $assignment->publish_marks == 0 && strtotime( $assignment->publish_date ) > time() && strtotime( $assignment->deadline_date ) > time() ) {
                    $row_status = 'pending';
                    $row_order_weight = '2';
                } elseif( $assignment->publish == 1 && $assignment->publish_marks == 0 && strtotime( $assignment->deadline_date ) > time() ) {
                    $row_status = 'assigned';
                    $row_order_weight = '1';
                } elseif( $assignment->grade_type <> 'offline' && $assignment->publish == 1 && $assignment->publish_marks == 0 && strtotime( $assignment->deadline_date ) < time() ) {
                    $row_status = 'past';
                    $row_order_weight = '3';
                }
//echo '<pre>';var_dump( $publish_marks );die;
                $this->db->update('assignments_filter', array('publish_marks'=>$publish_marks, 'status' => $row_status, 'order_weight' => $row_order_weight), array('id' => $assignment->id));
            }
            return $this->db->last_query();
        }

        public function labelsAssigmnetType($v) {
            $labels = array(
                'test' => 'Online Test',
                'offline' => 'Offline Submission',
                'percentage'=>'File Upload - Percentage',
                'mark_out_of_10'=>'File Upload - Marks out of 10',
                'grade'=>'File Upload - Grade',
                'free_text'=>'File Upload - Free Text'
            );

            if( $v == '*' ) { return $labels; } else { return $labels[$v]; }
        }

        public function get_assigned_year($id) {
            $this->db->select('assignments.class_id,classes.*,subjects.name');
            $this->db->from('assignments');
            $this->db->join('classes','assignments.class_id=classes.id');
            $this->db->join('subjects','subjects.id=classes.subject_id');
            $this->db->where('assignments.id',$id);
            $q = $this->db->get();
            return $q->row_array();
        }

        public function get_assigned_classes($id) {
            $this->db->select('assignments.class_id,classes.*');
            $this->db->from('assignments');
            $this->db->join('classes','assignments.class_id=classes.id');

            $this->db->where('assignments.id',$id);
            $q = $this->db->get();
            return $q->row_array();
        }

        public function get_assigned_students( array $list ) {
            $query = $this->db->select("id, first_name, last_name")->where_in('id',$list)->order_by( 'first_name' )->get('users');
            return $query->result();
        }

        public function delete_assignment($id) {

            $this->db->where('id',$id);
            $this->db->delete('assignments');

            $this->db->where('base_assignment_id',$id);
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

            $this->db->where('id',$id);
            $this->db->delete('assignments_filter');

            return true;
        }

        public function exempt_student_assignment($id) {
            $data = array(
               'exempt' => 1,
            );
            $this->db->where('id',$id);
            $this->db->update('assignments', $data); // UPDATE `assignments` SET `active` = '0', `exempt` = '1' WHERE `active` = -1;

            return true;
        }

        public function add_student_assignment($id) {
            $data = array(
               'exempt' => 0,
            );
            $this->db->where('id',$id);
            $this->db->update('assignments', $data);
            return true;
        }

        public function add_offline_assignment($id) {
            $data = array(
               'active' => 1,
               'publish' => 1
            );
            $this->db->where('id',$id);
            $this->db->update('assignments', $data);
            return true;
        }

        public function add_offline_marks($id, $marks = 0) {
            $data = array(
               'total_evaluation' => $marks
            );
            $this->db->where('assignment_id',$id);
            $this->db->where('resource_id',0);
            $this->db->update('assignments_marks', $data);
            return true;
        }

        public function add_test_marks($id, $marks = 0) {
            $this->db->set('total_evaluation', '`total_evaluation` + '.$marks, FALSE);
            $this->db->where('assignment_id',$id);
            $this->db->where('resource_id',0);
            $this->db->update('assignments_marks');
            return true;
        }

        public function remove_offline_assignment($id) {
            $data = array(
               'active' => 0,
               'publish' => 0
            );
            $this->db->where('id',$id);
            $this->db->update('assignments', $data);
            return true;
        }

        public function remove_offline_marks($id) {
            $data = array(
               'total_evaluation' => 0
            );
            $this->db->where('assignment_id',$id);
            $this->db->where('resource_id',0);
            $this->db->update('assignments_marks', $data);
            return true;
        }

        public function checkRedirect( $assignment, $mode = 'assigned' ) {
            switch( $mode ) {
                case 'draft':
                    if( $assignment->publish == 0 ) {
                        return 1; // draft
                    } else {
                        if( $assignment->publish_date && strtotime( $assignment->publish_date ) > time() ) {
                            redirect(base_url('f2p_teacher/index/'.$assignment->id)); // pending
                        } else {
                            if( ( $assignment->publish_marks == 1 ) || ( ( $assignment->publish_marks == 0 ) && $assignment->grade_type == 'offline' && strtotime( $assignment->deadline_date ) < time() ) ) {
                                redirect(base_url('f2d_teacher/index/'.$assignment->id)); // closed
                            } else {
                                if( strtotime( $assignment->deadline_date ) > time() ) {
                                    redirect(base_url('f2b_teacher/edit/'.$assignment->id)); // assigned
                                } else {
                                    redirect(base_url('f2b_teacher/past/'.$assignment->id)); // past
                                }
                            }
                        }
                    }
                    break;
                case 'pending':
                    if( $assignment->publish == 0 ) {
                        redirect(base_url('f2c_teacher/index/'.$assignment->id)); // draft
                    } else {
                        if( strtotime( $assignment->publish_date ) > time() ) {
                            return 1; // pending
                        } else {
                            if( ( $assignment->publish_marks == 1 ) || ( ( $assignment->publish_marks == 0 ) && $assignment->grade_type == 'offline' && strtotime( $assignment->deadline_date ) < time() ) ) {
                                redirect(base_url('f2d_teacher/index/'.$assignment->id)); // closed
                            } else {
                                if( strtotime( $assignment->deadline_date ) > time() ) {
                                    redirect(base_url('f2b_teacher/edit/'.$assignment->id)); // assigned
                                } else {
                                    redirect(base_url('f2b_teacher/past/'.$assignment->id)); // past
                                }
                            }
                        }
                    }
                    break;
                case 'assigned':
                    if( $assignment->publish == 0 ) {
                        redirect(base_url('f2c_teacher/index/'.$assignment->id)); // draft
                    } else {
                        if( strtotime( $assignment->publish_date ) > time() ) {
                            redirect(base_url('f2p_teacher/index/'.$assignment->id)); // pending
                        } else {
                            if( ( $assignment->publish_marks == 1 ) || ( ( $assignment->publish_marks == 0 ) && $assignment->grade_type == 'offline' && strtotime( $assignment->deadline_date ) < time() ) ) {
                                redirect(base_url('f2d_teacher/index/'.$assignment->id)); // closed
                            } else {
                                if( strtotime( $assignment->deadline_date ) > time() ) {
                                    return 2; // assigned
                                } else {
                                    redirect(base_url('f2b_teacher/past/'.$assignment->id)); // past
                                }
                            }
                        }
                    }
                    break;
                case 'past':
                    if( $assignment->publish == 0 ) {
                        redirect(base_url('f2c_teacher/index/'.$assignment->id)); // draft
                    } else {
                        if( $assignment->publish_date && strtotime( $assignment->publish_date ) > time() ) {
                            redirect(base_url('f2p_teacher/index/'.$assignment->id)); // pending
                        } else {
                            if( ( $assignment->publish_marks == 1 ) || ( ( $assignment->publish_marks == 0 ) && $assignment->grade_type == 'offline' && strtotime( $assignment->deadline_date ) < time() ) ) {
                                redirect(base_url('f2d_teacher/index/'.$assignment->id)); // closed
                            } else {
                                if( strtotime( $assignment->deadline_date ) > time() ) {
                                    redirect(base_url('f2b_teacher/edit/'.$assignment->id)); // assigned
                                } else {
                                    return 2; // past
                                }
                            }
                        }
                    }
                    break;
                case 'closed':
                    if( $assignment->publish == 0 ) {
                        redirect(base_url('f2c_teacher/index/'.$assignment->id)); // draft
                    } else {
                        if( $assignment->publish_date && strtotime( $assignment->publish_date ) > time() ) {
                            redirect(base_url('f2p_teacher/index/'.$assignment->id)); // pending
                        } else {
                            if( ( $assignment->publish_marks == 1 ) || ( ( $assignment->publish_marks == 0 ) && $assignment->grade_type == 'offline' && strtotime( $assignment->deadline_date ) < time() ) ) {
                                return 1; // closed
                            } else {
                                if( strtotime( $assignment->deadline_date ) > time() ) {
                                    redirect(base_url('f2b_teacher/edit/'.$assignment->id)); // assigned
                                } else {
                                    redirect(base_url('f2b_teacher/past/'.$assignment->id)); // past
                                }
                            }
                        }
                    }
                    break;
                case 'index':
                    if( $assignment->publish == 0 ) {
                        redirect(base_url('f2c_teacher/index/'.$assignment->id)); // draft
                    } else {
                        if( $assignment->publish_date && strtotime( $assignment->publish_date ) > time() ) {
                            redirect(base_url('f2p_teacher/index/'.$assignment->id)); // pending
                        } else {
                            if( ( $assignment->publish_marks == 1 ) || ( ( $assignment->publish_marks == 0 ) && $assignment->grade_type == 'offline' && strtotime( $assignment->deadline_date ) < time() ) ) {
                                redirect(base_url('f2d_teacher/index/'.$assignment->id)); // closed
                            } else {
                                if( strtotime( $assignment->deadline_date ) > time() ) {
                                    redirect(base_url('f2b_teacher/edit/'.$assignment->id)); // assigned
                                } else {
                                    redirect(base_url('f2b_teacher/past/'.$assignment->id)); // past
                                }
                            }
                        }
                    }
                    break;
            }

        }

    }
