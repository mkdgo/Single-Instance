<?php

    class Filter_assignment_model extends CI_Model {

        private $_table_assignments_filter = 'assignments_filter';
        private $_table_assignments = 'assignments';
        private $_table_assignments_resources = 'assignments_resources';
        private $_table_assignments_categories = 'assignments_grade_categories';
        private $_table_assignments_attributes = 'assignments_grade_attributes';
        private $_table_assignments_details = 'assignments_details';
        private $_table_assignments_marks = 'assignments_marks';


        public function __construct() {
            parent::__construct();
        }

        public function updateRecord( $row, $id ) {

            $totals = $this->getTotal( $id );
            $class_names = $this->getClassNames( $row['class_id'] );
            $sql = "INSERT INTO assignments_filter (id, base_assignment_id, teacher_id, publish_date, subject_id, subject_name, year, class_id, title, intro, grade_type, grade, deadline_date, feedback, active, publish, publish_marks, total, submitted, marked, status, order_weight, teacher_name, class_name )
                    VALUES ( '".$row['id']."', '".$row['base_assignment_id']."', '".$row['teacher_id']."', '".$row['publish_date']."', '".$row['subject_id']."', '".$row['subject_name']."', '".$row['year']."', '".$row['class_id']."', '".$row['title']."', '".$row['intro']."', '".$row['grade_type']."', '".$row['grade']."', '".$row['deadline_date']."', '".$row['feedback']."', '".$row['active']."', '".$row['publish']."', '".$row['publish_marks']."', '".$totals['total']."', '".$totals['submitted']."', '".$totals['marked']."', '".$row['status']."', '".$row['order_weight']."', '".$row['teacher_name']."', '".$class_names."')
                    ON DUPLICATE KEY UPDATE 
                        base_assignment_id=VALUES(base_assignment_id), 
                        teacher_id=VALUES(teacher_id), 
                        publish_date=VALUES(publish_date), 
                        subject_id=VALUES(subject_id), 
                        subject_name=VALUES(subject_name), 
                        year=VALUES(year), 
                        class_id=VALUES(class_id), 
                        title=VALUES(title), 
                        intro=VALUES(intro), 
                        grade_type=VALUES(grade_type), 
                        grade=VALUES(grade), 
                        deadline_date=VALUES(deadline_date), 
                        submitted_date=VALUES(submitted_date), 
                        feedback=VALUES(feedback), 
                        active=VALUES(active), 
                        publish=VALUES(publish), 
                        publish_marks=VALUES(publish_marks), 
                        total=VALUES(total), 
                        submitted=VALUES(submitted), 
                        marked=VALUES(marked), 
                        status=VALUES(status),
                        order_weight=VALUES(order_weight),
                        teacher_name=VALUES(teacher_name),
                        class_name=VALUES(class_name)";

            $query = $this->db->query($sql);
//echo $this->db->last_query();die;
        }

        function getTotal( $assignment_id ) {
            $sql = 'SELECT a1.*, 
                        (SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.active != -1) AS total,
                        (SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.active = 1 AND a2.publish >= 1) AS submitted,
                        (SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.grade = 1) AS marked
                    FROM assignments a1
                    WHERE id = '.$assignment_id;
            $query = $this->db->query($sql);
            $result = $query->row_array();
            return $result;
        }

        function getClassNames($class_id) {
            $sql = "SELECT `group_name` FROM `classes` WHERE `classes`.`id` IN(".$class_id.")";
            $query = $this->db->query($sql);
            $results = $query->result_array();
            foreach( $results as $result ) {
                $arr[] = $result['group_name'];
            }
            if( count($arr) ) {
                $imp_class_names = implode( ', ',$arr );
            } else {
                $imp_class_names = '';
            }
            return $imp_class_names;
        }

        public function get_filtered_assignments( $teacher_id = 'all', $subject_id = 'all', $year = 'all', $class_id = 'all', $status = 'all' ) {
            $where = array();
            $sql_filter = "SELECT * FROM assignments_filter ";
            if( $teacher_id != 'all' ) { $where[] = ' teacher_id = '.$teacher_id; }
            if( $subject_id != 'all' ) { $where[] = ' subject_id = '.$subject_id; }
            if( $year != 'all' ) { $where[] = ' year = '.$year; }
            if( $class_id != 'all' ) {
                if( $class_id != 'no classes' ) {
                    $where[] = ' class_name LIKE "%' . $class_id . '%"'; 
                } else {
                    $where[] = ' class_name = "" '; 
                }
            }
            if( $status != 'all' ) { $where[] = ' status = "'.$status.'"'; }
            if( count( $where ) ) {
                $sql_filter .= ' WHERE ' . implode( ' AND ', $where );
            }
            $query = $this->db->query($sql_filter);
            $result = $query->result();
            $query->free_result();
            
            return $result;
        }

        public function filterTeachers( array $filters, $order_by = 'first_name' ) {
            $where = array();
            if( $order_by == 'last_name' ) {
                $sql_filter = "SELECT af.teacher_id, CONCAT( users.last_name, ', ', users.first_name ) as teacher_name FROM `assignments_filter` as af ";
            } else {
                $sql_filter = "SELECT af.teacher_id, CONCAT( users.first_name, ' ', users.last_name ) as teacher_name FROM `assignments_filter` as af ";
            }
            $sql_filter .= "LEFT JOIN users ON users.id = af.teacher_id ";
            if( $filters['subject_id'] != 'all' ) { $where[] = ' subject_id = '.$filters['subject_id']; }
            if( $filters['year'] != 'all' ) { $where[] = ' year = '.$filters['year']; }
            if( $filters['status'] != 'all' ) { $where[] = ' status = "'.$filters['status'].'"'; }
            if( $filters['class_id'] != 'all' ) {
                if( $filters['class_id'] != 'no classes' ) {
                    $where[] = ' class_name LIKE "%' . $filters['class_id'] . '%"'; 
                } else {
                    $where[] = ' class_name = "" '; 
                }
            }

            if( count( $where ) ) {
                $sql_filter .= ' WHERE ';
                $sql_filter .= implode( ' AND ', $where );
            }
            $sql_filter .= " GROUP BY teacher_id ";
            $sql_filter .= " ORDER BY teacher_name ASC ";

            $query = $this->db->query($sql_filter);
            $result = $query->result_array();
//echo $this->db->last_query();die;
            return $result;
        }

        public function filterSubjects( $teacher_id = 'all', $subject_id = 'all', $year = 'all', $class_id = 'all', $status = 'all' ) {
            $where = array();
            $sql_filter = "SELECT subject_id, subject_name FROM `assignments_filter` ";
            if( $teacher_id != 'all' ) { $where[] = ' teacher_id = '.$teacher_id; }
            if( $year != 'all' ) { $where[] = ' year = '.$year; }
            if( $class_id != 'all' ) {
                if( $class_id != 'no classes' ) {
                    $where[] = ' class_name LIKE "%' . $class_id . '%"'; 
                } else {
                    $where[] = ' class_name = "" '; 
                }
            }
//            if( $class_id != 'all' ) { $where[] = ' class_id IN(' . $class_id . ')'; }
            if( $status != 'all' ) { $where[] = ' status = "'.$status.'"'; }
            if( count( $where ) ) {
                $sql_filter .= ' WHERE ';
                $sql_filter .= implode( ' AND ', $where );
            }
            $sql_filter .= " GROUP BY subject_name ";
            $sql_filter .= " ORDER BY subject_name ASC ";

            $query = $this->db->query($sql_filter);
            $result = $query->result_array();
            return $result;
        }

        public function filterYears( $teacher_id = 'all', $subject_id = 'all', $year = 'all', $class_id = 'all', $status = 'all' ) {
            $where = array();
            $sql_filter = "SELECT year FROM `assignments_filter` ";
            if( $teacher_id != 'all' ) { $where[] = ' teacher_id = '.$teacher_id; }
            if( $subject_id != 'all' ) { $where[] = ' subject_id = '.$subject_id; }
            if( $class_id != 'all' ) {
                if( $class_id != 'no classes' ) {
                    $where[] = ' class_name LIKE "%' . $class_id . '%"'; 
                } else {
                    $where[] = ' class_name = "" '; 
                }
            }
            if( $status != 'all' ) { $where[] = ' status = "'.$status.'"'; }
            if( count( $where ) ) {
                $sql_filter .= ' WHERE ';
                $sql_filter .= implode( ' AND ', $where );
            }
            $sql_filter .= " GROUP BY year ";
            $sql_filter .= " ORDER BY year ASC ";

            $query = $this->db->query($sql_filter);
            $result = $query->result_array();
            return $result;
        }

        public function filterClasses( $teacher_id = 'all', $subject_id = 'all', $year = 'all', $class_id = 'all', $status = 'all' ) {
            $where = array();
//            $where = array( " af.class_name LIKE ( '%c.group_name%' ) " );
//            $where = array( " af.class_id IN ( c.id ) " );
            $sql_filter = "SELECT af.class_id, af.class_name FROM `assignments_filter` af";
//            $sql_filter = "SELECT af.class_id, c.group_name FROM `assignments_filter` af, classes c";
            if( $teacher_id != 'all' ) { $where[] = ' af.teacher_id = '.$teacher_id; }
            if( $subject_id != 'all' ) { $where[] = ' af.subject_id = '.$subject_id; }
            if( $year != 'all' ) { $where[] = ' af.year = '.$year; }
            if( $status != 'all' ) { $where[] = ' af.status = "'.$status.'"'; }
            if( count( $where ) ) {
                $sql_filter .= ' WHERE ';
                $sql_filter .= implode( ' AND ', $where );
            }
            $sql_filter .= " GROUP BY af.class_id ";
//            $sql_filter .= " GROUP BY c.group_name ";
            $sql_filter .= " ORDER BY af.class_name ASC ";
//            $sql_filter .= " ORDER BY c.group_name ASC ";

            $query = $this->db->query($sql_filter);
            $result = $query->result_array();
//echo $this->db->last_query();die;
            return $result;
        }

        public function get_assignment($id) {
            $sql_filter = "SELECT * FROM `assignments_filter` WHERE id = ".$id." LIMIT 1";
            $query = $this->db->query($sql_filter);
//            $query = $this->db->get_where($this->_table_assignments_filter, array('id' => $id ));
            return $query->result_array();
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

            if( isset($data['base_assignment_id']) && $data['base_assignment_id'] == 0 && $data['publish'] == 1 ) {
                // insert assignments from the new class

//                $this->db->update($this->_table, array('active' => 0), array('base_assignment_id' => $id)); 

                $this->db->distinct();
                $this->db->from('student_classes');
                $this->db->where('student_classes.class_id IN ('.$data['class_id'].')');
                $this->db->group_by('student_id');
                
                $students = $this->db->get()->result();

                foreach($students as $STUDENT){
                    $checker = $this->db->get_where($this->_table, array('base_assignment_id' => $id, 'student_id'=>$STUDENT->student_id, 'class_id'=>$STUDENT->class_id))->row();
//echo '<pre>'; var_dump( $checker );//die;

                    if( $checker ) {
//echo '<pre>'; var_dump( $checker->active );//die;
                        $this->db->query('
                            UPDATE assignments 
                            SET 
                            title='.$this->db->escape($data['title']).',
                            intro='.$this->db->escape($data['intro']).',
                            grade_type='.$this->db->escape($data['grade_type']).',
                            deadline_date='.$this->db->escape($data['deadline_date']).',
                            active='.$checker->active.',
                            publish_marks='.$this->db->escape($data['publish_marks']).'
                            WHERE
                            base_assignment_id='.$id.' AND
                            student_id='.$STUDENT->student_id.' AND
                            class_id="'.$STUDENT->class_id.'"'                                   
                        );
                    } else {
                        $this->db->query('
                            INSERT INTO assignments 
                            SET 
                            base_assignment_id='.$this->db->escape($id).',
                            teacher_id='.$this->db->escape($data['teacher_id']).',
                            student_id='.$STUDENT->student_id.',
                            class_id='.$STUDENT->class_id.',
                            title='.$this->db->escape($data['title']).',
                            intro='.$this->db->escape($data['intro']).',
                            grade_type='.$this->db->escape($data['grade_type']).',
                            deadline_date='.$this->db->escape($data['deadline_date']).',
                            publish_marks=0'
                        );
                    }
                }
            }
//die;
//            if( $data['publish'] == 0 ) $this->db->update($this->_table, array('active' => 0), array('base_assignment_id' => $id)); 

            return $id;
        }

        public function assignment_exist($id) {
            $query = $this->db->get_where($this->_table, array('id' => $id));

            return $query->num_rows();
        }

        public function get_draftSubmissions()  {
            $query = $this->db->get_where($this->_table, array('base_assignment_id !='=>'0', 'publish'=>0, 'deadline_date < '=>'NOW()'));

            return $query->result();
        }

        public function get_assignments( $where = array(), $or_where = array(), $type = null, $teacher_id = 0 ) {

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

        public function get_assignments_teacher( $studentid, $where = array(), $or_where = array() ) {
            $date_format = "'%a %D% %b %Y, %H:%i'";
            $sql = 'SELECT A.*,subjects.name subject_name, PA.publish as parent_publish,DATE_FORMAT(A.deadline_date,'.$date_format.')as user_deadline_date FROM assignments A LEFT JOIN assignments PA ON A.base_assignment_id=PA.id
            LEFT JOIN classes ON classes.id IN (A.class_id)
            LEFT JOIN subjects ON subjects.id = classes.subject_id

            WHERE A.student_id='.$studentid.'';
            //

            $WHERE_condition = '';
            $WHERE_condition = implode(' AND ', $where);
            if( $WHERE_condition != '' ) { $WHERE_condition = ' AND '.$WHERE_condition; }

            $sql .= $WHERE_condition;
            if( count( $or_where ) ) {
                $sql .= ' OR ('.implode(' AND ',$or_where).')';
            }
            $query = $this->db->query($sql);

            $r = $query->result();

            return $r;
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
            $this->db->select('classes.year,classes.id as class_id,GROUP_CONCAT(classes.subject_id SEPARATOR ",") as subjects_ids, GROUP_CONCAT( classes.id
SEPARATOR ", " ) AS cls_ids',false);

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

        public function get_teacher_subjects($teacher_id) {
            $this->db->select('subject_name, subject_id, GROUP_CONCAT(DISTINCT class_id  SEPARATOR ",") as classes_ids',false);
//            $this->db->select('subjects_name, subject_id, class_id as classes_ids');

            $this->db->from( $this->_table_assignments_filter );

            if( $teacher_id != 'all' ) {
                $this->db->where('teacher_id', $teacher_id);
            }
//            $this->db->where('classes.year', $year);

            $this->db->group_by(array("subject_id"));

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
            if($in !=false) {
                $this->db->where('classes.id IN (' . $in . ')');
            }
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


        public function labelsAssigmnetType($v) {
            $labels = array(
                'offline' => 'Offline Submission',
                'grade'=>'Grade',
                'free_text'=>'Free Text',
                'percentage'=>'Percentage'
            );

            if($v=='*')return $labels;else return $labels[$v];
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

    }
