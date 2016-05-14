<?php

class Student_answers_model extends CI_Model {

    private $_table = 'student_answers';
    private static $db;

    public function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    public function save($data, $id = '') {
        if( $id ) {
            $this->db->update($this->_table, $data, array('id' => $id));
        } else {
            $sql = $this->db->set($data)->get_compiled_insert($this->_table);
            echo $sql;$this->db->insert($this->_table, $data);
            $id = $this->db->insert_id();
            
        }
        return $id;
    }

    public function getResults($res_id, $lesson_id, $identity) {
//$identity = 'e06387965fd9a9a4';
        $this->db->select();
        $this->db->from($this->_table);
        $this->db->where('resource_id', $res_id);
        $this->db->where('lesson_id', $lesson_id);
        //$this->db->where('identity', $identity);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAttained( $data ) {
        $student_id = isset( $data['student_id'] ) ? $data['student_id']: false;
        $resource_id = isset( $data['resource_id'] ) ? $data['resource_id']: false;
        $lesson_id = isset( $data['lesson_id'] ) ? $data['lesson_id']: false;
        $slide_id = isset( $data['slide_id'] ) ? $data['slide_id']: false;
        $identity = isset( $data['identity'] ) ? $data['identity']: false;//null;
        $this->db->select('attained');
        $this->db->from($this->_table);
        if( $resource_id ) { $this->db->where('resource_id', $resource_id); }
        if( $student_id ) { $this->db->where('student_id', $student_id); }
        if( $lesson_id ) { $this->db->where('lesson_id', $lesson_id); }
        if( $slide_id ) { $this->db->where('slide_id', $slide_id); }
        if( $identity ) { $this->db->where('identity', $identity); }
        $query = $this->db->get();
        $att = $query->row();
        if( $att->attained ) {
            return $att->attained;
        } else {
            return 0;
        }
    }

    public function isExist( $student_id, $resource_id, $lesson_id, $slide_id, $behavior )  {
        $this->db->select();
        $this->db->from($this->_table);
        if( $resource_id ) { $this->db->where('resource_id', $resource_id); }
        if( $student_id ) { $this->db->where('student_id', $student_id); }
        if( $lesson_id ) { $this->db->where('lesson_id', $lesson_id); }
        if( $slide_id ) { $this->db->where('slide_id', $slide_id); }
        if( $identity ) { $this->db->where('identity', $identity); }
        $query = $this->db->get();
        $exist = $query->row();
//echo '<pre>';var_dump( $exist );die;
        if( $exist ) {
            return true;
        } else {
            return false;
        }
    }

    public function searchAssessment( $where ) {
        $this->db->select();
        $this->db->from($this->_table);
        $query = 'SELECT * FROM '.$this->_table.' WHERE ';
            $_where = array();
            foreach( $where['conditions'] as $con ) {
                $_con = '';
                $_fld = $con['field'];
                $_opr = '=';
                $_val = '"'.$con['value'].'"';
                if( $con['value'] == 'all' ) { continue; }
                if( $con['condition'] == 'GROUP BY' ) {
                    $_opr = '';
                    $_val = '';
                } else {
                    if( $con['field'] == 'action_date' ) {
                        $_val = 'DATE("'.$con['value'].'")';
                    } else {
                        if( $_opr == 'like' ) {
                            $_val = '"%'.$con['value'].'%"';
                        }
                    }
                }
                $_where[] = $_con . ' ' . $_fld . ' ' . $_opr . ' ' . $_val . ' ';
            }
            $_where = implode(' AND ', $_where );

        $query .= $_where;
//        $query .= ' GROUP BY resource_id'; 
//echo '<pre>';var_dump( $query );die;
        $sql_query = $this->db->query($query);
        
        $arr = $sql_query->result_array();
        return $arr;
    }

    public function renderSearchResults( $results, $students, $resources, $class_id, $behavior = 'homework' ) {
        $stud = array();
        $html = '';
        $count_resources = count($resources);
//echo '<pre>';var_dump( $resources );die;
        $tres = '';
        for($i=0; $i < $count_resources; $i++ ) {
            $tres .= '<th><span class="question">Q'.($i+1).'</span></th>';
        }
        $th = '<tr><th></th>'.$tres.'<th><span class="question">MARKS</span></th><th><span class="question">(%)</span></th></tr>';
//echo '<pre>';var_dump( $students );die;
        $student_id = '';
        foreach( $students as $st_row ) {
            if( $behavior == 'homework' ) {
                if( $st_row->exempt == 1 ) { continue; }
                if( $class_id != 'all' ) {
                    if( $st_row->class_id != $class_id ) {
                        continue;
                    }
                }
                $student_id = $st_row->student_id;
            } else {
                $student_id = $st_row->id;
            }
//echo '<pre>';var_dump( $st_row->first_name );//die;

            $stud[$student_id]['name'] = $st_row->first_name.' '.$st_row->last_name;
            $stud[$student_id]['class'] = '';
            $stud[$student_id]['assignment_id'] = $st_row->id;
            $stud[$student_id]['resources'] = array();
            $stud[$student_id]['available'] = 0;
            $stud[$student_id]['attained'] = 0;
            $stud[$student_id]['percent'] = 0;

//echo '<pre>';var_dump( $resources );//die;
            foreach( $resources as $res ) {
                $stud[$student_id]['resources'][$res->res_id] = array( 'marks'=>'','class'=>'' );
                $stud[$student_id]['resources'][$res->res_id]['marks'] = '0/'.$res->marks_available;
                $stud[$student_id]['resources'][$res->res_id]['class'] = 'score1';
                $stud[$student_id]['available'] += $res->marks_available;
            }
        }

//echo '<pre>';var_dump( $stud );die;
        foreach( $results as $att ) {
            $stud[$att['student_id']]['resources'][$att['resource_id']]['marks'] = $att['attained'].'/'.$att['marks_available'];
            $stud[$att['student_id']]['resources'][$att['resource_id']]['class'] = $this->setCssClass($att['attained'],$att['marks_available']);
            $stud[$att['student_id']]['attained'] += $att['attained'];
            $stud[$att['student_id']]['percent'] = '';
            if( $stud[$att['student_id']]['available'] ) {
                $stud[$att['student_id']]['percent'] = number_format( ( $stud[$att['student_id']]['attained'] * 100 ) / $stud[$att['student_id']]['available'] );
            }
        }
        $tr = '';
        foreach( $stud as $st ) {
            $tdres = '';
            foreach( $st['resources'] as $v_res ) {
                $cls = $v_res['class'];
                $mrk = $v_res['marks'];
                $tdres .= '<td><span class="'.$cls.'">'.$mrk.'</span></td>';
            }
            $overall_marks = $this->setCssClass($st['attained'],$st['available']);
            
            $tr .= '<tr><td><span class="student">'.$st['name'].'</span></td>'.$tdres.'<td><span class="'.$overall_marks.'">'.$st['attained'].'/'.$st['available'].'</span></td><td><span class="'.$overall_marks.'">('.$st['percent'].'%)</span></td></tr>';
        }
        $html = '<table class="assesment_result">'.$th.$tr.'</table>';
        return $html;
    }

    private function setCssClass( $attained, $available ) {
        if( $available == 0 ) {
            return '';
        }
        $score = number_format( ( $attained * 100 ) / $available );
        if( $score > 74 ) {
            $class = 'score4';
        } elseif( $score > 49 ) {
            $class = 'score3';
        } elseif( $score > 24 ) {
            $class = 'score2';
        } else {
            $class = 'score1';
        }
        return $class;
    }


        public function filterTeachers( array $filters, $order_by = 'first_name' ) {
            $where = array();
            if( $order_by == 'last_name' ) {
                $sql_filter = "SELECT af.teacher_id, CONCAT( users.last_name, ', ', users.first_name ) as teacher_name FROM `student_answers` as af ";
            } else {
                $sql_filter = "SELECT af.teacher_id, CONCAT( users.first_name, ' ', users.last_name ) as teacher_name FROM `student_answers` as af ";
            }
            $sql_filter .= "LEFT JOIN users ON users.id = af.teacher_id ";
            $where[] = ' behavior = "'.$filters['behavior'].'"';
            if( $filters['subject_id'] != 'all' ) { $where[] = ' subject_id = '.$filters['subject_id']; }
            if( $filters['year'] != 'all' ) { $where[] = ' year = '.$filters['year']; }
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
            return $result;
        }

        public function filterSubjects( $teacher_id = 'all', $subject_id = 'all', $year = 'all', $class_id = 'all', $behavior = 'homework' ) {
            $where = array();
            $sql_filter = "SELECT subject_id, subject_name FROM `student_answers` ";
            $where[] = ' behavior = "'.$behavior.'"';
            if( $teacher_id != 'all' ) { $where[] = ' teacher_id = '.$teacher_id; }
            if( $year != 'all' ) { $where[] = ' year = '.$year; }
            if( $class_id != 'all' ) {
                if( $class_id != 'no classes' ) {
                    $where[] = ' class_name LIKE "%' . $class_id . '%"'; 
                } else {
                    $where[] = ' class_name = "" '; 
                }
            }
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

        public function filterYears( $teacher_id = 'all', $subject_id = 'all', $year = 'all', $class_id = 'all', $behavior = 'homework' ) {
            $where = array();
            $sql_filter = "SELECT year FROM `student_answers` ";
            $where[] = ' behavior = "'.$behavior.'"';
            if( $teacher_id != 'all' ) { $where[] = ' teacher_id = '.$teacher_id; }
            if( $subject_id != 'all' ) { $where[] = ' subject_id = '.$subject_id; }
            if( $class_id != 'all' ) {
                if( $class_id != 'no classes' ) {
                    $where[] = ' class_name LIKE "%' . $class_id . '%"'; 
                } else {
                    $where[] = ' class_name = "" '; 
                }
            }
            if( count( $where ) ) {
                $sql_filter .= ' WHERE ';
                $sql_filter .= implode( ' AND ', $where );
            }
            $sql_filter .= " GROUP BY year ";
            $sql_filter .= " ORDER BY year ASC ";

            $query = $this->db->query($sql_filter);
            $result = $query->result_array();
//echo '<pre>'; var_dump( $behavior );die;
            return $result;
        }

        public function filterClasses( $teacher_id = 'all', $subject_id = 'all', $year = 'all', $class_id = 'all', $behavior = 'homework' ) {
            $where = array();
            $sql_filter = "SELECT af.class_id, af.class_name FROM `student_answers` af";
            $where[] = ' behavior = "'.$behavior.'"';
            if( $teacher_id != 'all' ) { $where[] = ' af.teacher_id = '.$teacher_id; }
            if( $subject_id != 'all' ) { $where[] = ' af.subject_id = '.$subject_id; }
            if( $year != 'all' ) { $where[] = ' af.year = '.$year; }
            if( count( $where ) ) {
                $sql_filter .= ' WHERE ';
                $sql_filter .= implode( ' AND ', $where );
            }
            $sql_filter .= " GROUP BY af.class_id ";
            $sql_filter .= " ORDER BY af.class_name ASC ";

            $query = $this->db->query($sql_filter);
            $result = $query->result_array();
            return $result;
        }

        public function filterBehavior( $teacher_id = 'all', $subject_id = 'all', $year = 'all', $class_id = 'all', $behavior = 'homework' ) {
/*
            $where = array();
            $sql_filter = "SELECT behavior FROM `student_answers` ";
            if( $teacher_id != 'all' ) { $where[] = ' teacher_id = '.$teacher_id; }
            if( $year != 'all' ) { $where[] = ' year = '.$year; }
            if( $class_id != 'all' ) {
                if( $class_id != 'no classes' ) {
                    $where[] = ' class_name LIKE "%' . $class_id . '%"'; 
                } else {
                    $where[] = ' class_name = "" '; 
                }
            }
            if( count( $where ) ) {
                $sql_filter .= ' WHERE ';
                $sql_filter .= implode( ' AND ', $where );
            }
            $sql_filter .= " GROUP BY behavior ";
            $sql_filter .= " ORDER BY behavior ASC ";

            $query = $this->db->query($sql_filter);
            $result = $query->result_array();
//echo '<pre>'; var_dump( $result );die;
//*/
            $result = array( 0 => array( 'id' => 'homework', 'behavior' => 'Homework'), 1 => array( 'id' => 'online', 'behavior' => 'Lesson Quiz'), 2 => array( 'id' => 'offline', 'behavior' => 'Offline') );
            return $result;
        }

        public function filterAssignment( $teacher_id = 'all', $subject_id = 'all', $year = 'all', $class_id = 'all', $behavior = 'homework' ) {

            $where = array();
            $sql_filter = "SELECT lesson_id as assignment_id, lesson_title as assignment_name FROM `student_answers` ";
            $where[] = ' behavior = "'.$behavior.'"';
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
            if( count( $where ) ) {
                $sql_filter .= ' WHERE ';
                $sql_filter .= implode( ' AND ', $where );
            }
            $sql_filter .= " GROUP BY assignment_name ";
            $sql_filter .= " ORDER BY assignment_name ASC ";

            $query = $this->db->query($sql_filter);
            $result = $query->result_array();
//echo '<pre>'; var_dump( $query );die;
            return $result;
        }

    public function getStudentAnswer( $where ) {
        $query = 'SELECT * FROM '.$this->_table.' WHERE ';
            $_where = array();
            foreach( $where as $k => $v ) {
                $_where[] = $k . ' = ' . $v;
            }
            $_where = implode(' AND ', $_where );

        $query .= $_where;
        $sql_query = $this->db->query($query);
        
        $arr = $sql_query->result_array();
        return $arr;
    }

    public function hasAnswersForLesson( $lesson_id ) {
        $this->db->select();
        $this->db->from($this->_table);
        $this->db->where('lesson_id', $lesson_id);
        $this->db->where('behavior', 'online');

        $has = $this->db->count_all_results();
//echo '<pre>'; var_dump( $has );die;
        return $has;
    }








    public function get_subjects($fields = '*', $ordered = true) {
        $this->db->select($fields);
        $this->db->from($this->_table);
        $this->db->where('publish', 1);
        if ($ordered) {
            $this->db->order_by('name', 'ASC');
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_teacher_subjects($teacher_id) {
        $this->db->select('subjects.id,subjects.name,GROUP_CONCAT(DISTINCT classes.id  SEPARATOR ",") as classes_ids',false);

        $this->db->from('teacher_classes');
        $this->db->join('classes','classes.id = teacher_classes.class_id');
        $this->db->join('subjects','subjects.id = classes.subject_id');
        if($teacher_id != 'all') {
            $this->db->where(array('subjects.publish' => 1, 'teacher_classes.teacher_id' => $teacher_id));
        } else {
            $this->db->where(array('subjects.publish' => 1));
        }
        $this->db->group_by('subjects.name');
        $this->db->order_by('subjects.id','asc');
        $query = $this->db->get();
//echo $this->db->last_query();

        return $query->result();
    }

    public function get_teacher_assigned_subjects($teacher_id) {
        $this->db->select('subjects.id,subjects.name,subjects.logo_pic',false);
        $this->db->from('teacher_classes');
        $this->db->join('classes','classes.id = teacher_classes.class_id');
        $this->db->join('subjects','subjects.id = classes.subject_id');
        $this->db->where(array('subjects.publish'=> 1,'teacher_classes.teacher_id'=>$teacher_id));
        $this->db->group_by('subjects.name');
        $this->db->order_by('subjects.name','asc');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_teacher_filtered_subjects_by_subj($teacher_id,$subject_id) {
        $this->db->select('subjects.id,subjects.name,subjects.logo_pic',false);
        $this->db->from('teacher_classes');
        $this->db->join('classes','classes.id = teacher_classes.class_id');
        $this->db->join('subjects','subjects.id = classes.subject_id');
if($teacher_id!='all') {
    $this->db->where(array('subjects.publish' => 1, 'teacher_classes.teacher_id' => $teacher_id));
}else{
    $this->db->where(array('subjects.publish' => 1));
}
        $this->db->where('subjects.id IN('.$subject_id.')');
        $this->db->group_by('subjects.name');
        $this->db->order_by('subjects.name','asc');
        $query = $this->db->get();
//echo $this->db->last_query();
        return $query->result();
    }

    public function get_teacher_filtered_subjects_by_subj_and_year($teacher_id,$subject_id,$years_id) {

        $this->db->select('subjects.id,subjects.name,subjects.logo_pic',false);
        $this->db->from('teacher_classes');
        $this->db->join('classes','classes.id = teacher_classes.class_id');
        $this->db->join('subjects','subjects.id = classes.subject_id');
        if($teacher_id!='all') {
            $this->db->where(array('subjects.publish' => 1, 'teacher_classes.teacher_id' => $teacher_id));
        }else{
            $this->db->where(array('subjects.publish' => 1));
        }
        if($subject_id!='all'){
            $this->db->where('subjects.id',$subject_id);
            //$this->db->where('classes.id IN ('.$years_id.')');
        }

        //

        $this->db->group_by('subjects.name');
        $this->db->order_by('subjects.name','asc');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_teacher_filtered_subjects_by_subj_and_year_and_class($teacher_id,$subject_id,$classes_id) {

        $this->db->select('subjects.id,subjects.name,subjects.logo_pic',false);
        $this->db->from('teacher_classes');
        $this->db->join('classes','classes.id = teacher_classes.class_id');
        $this->db->join('subjects','subjects.id = classes.subject_id');
        if($teacher_id!='all') {
            $this->db->where(array('subjects.publish' => 1, 'teacher_classes.teacher_id' => $teacher_id));
        }else{
            $this->db->where(array('subjects.publish' => 1));
        }
        if($subject_id!='all'){
            $this->db->where('subjects.id',$subject_id);
            //$this->db->where('classes.id IN ('.$years_id.')');
        }

        //

        $this->db->group_by('subjects.name');
        $this->db->order_by('subjects.name','asc');
        $query = $this->db->get();
//die($this->db->last_query());
        return $query->result();
    }

    public function get_teacher_notassigned_subjects($teacher_id) {
       $q= $this->db->query('select * from subjects where id NOT IN(SELECT subjects.id  as idd FROM `teacher_classes`,classes,subjects where teacher_classes.teacher_id='.$teacher_id.' and classes.id=teacher_classes.class_id and classes.subject_id=subjects.id group by subjects.id) and  publish=1 ORDER BY subjects.name ASC');



        return $q->result();
    }

    public function get_students_subjects($student_year, $student_id = 0) {
        $q = "
            SELECT
                DISTINCT `subjects`.`id`, `subjects`.`name`, `subjects`.`logo_pic`,
                `subjects`.`publish`, `subject_years`.`subject_id`, `subject_years`.`year`,
                (SELECT COUNT(*) FROM modules WHERE subject_id=`subject_years`.`subject_id` AND publish=1) ccn
            FROM
                (`subjects`)
            JOIN
                `subject_years` ON `subject_years`.`subject_id`=`subjects`.`id`
            RIGHT JOIN
                `classes` on `classes`.`subject_id` = `subjects`.`id`
            RIGHT JOIN
                `student_classes` on `student_classes`.`class_id`=`classes`.`id`
            WHERE
                `subject_years`.`year` = $student_year "
                . "AND `student_classes`.`student_id`= $student_id "
                . "AND `subjects`.`publish` = 1";

        $query = $this->db->query($q);

        return $query->result();
    }

    public function get_teacher_years_subjects($teacher_id, $subject_id, $all=false) {
        $q = "SELECT * FROM `teacher_classes`
        join classes on classes.id = class_id
        join subjects on subject_id=subjects.id
        where ";
        if($all == false) {
        $q.="teacher_id = ".$teacher_id."
        and ";
        }
        $q.="subject_id=".$subject_id."
        and publish = 1
        group by year";

        $query = $this->db->query($q);

        return $query->result();
    }

    public function get_teacher_classes_years_subjects($teacher_id, $subject_id, $year, $all=false) {
        $q = "SELECT * FROM `teacher_classes`
        join classes on classes.id = class_id
        join subjects on subject_id=subjects.id
        where ";
        if($all == false) {
        $q.="teacher_id = ".$teacher_id."
        and ";
        }
        $q.="subject_id=".$subject_id."
        and publish = 1
        and year = ".$year."
        group by group_name";

        $query = $this->db->query($q);

        return $query->result();
    }

    public function get_students_common_subjects($student_years, $student_ids) {
        $q = "
            SELECT
                DISTINCT `subjects`.`id`, `subjects`.`name`, `subjects`.`logo_pic`,
                `subjects`.`publish`, `subject_years`.`subject_id`, `subject_years`.`year`,
                (SELECT COUNT(*) FROM modules WHERE subject_id=`subject_years`.`subject_id` AND publish=1) ccn
            FROM
                (`subjects`)
            JOIN
                `subject_years` ON `subject_years`.`subject_id`=`subjects`.`id`
            RIGHT JOIN
                `classes` on `classes`.`subject_id` = `subjects`.`id`
            RIGHT JOIN
                `student_classes` on `student_classes`.`class_id`=`classes`.`id`
            WHERE
                `subjects`.`publish` = 1 "
                . "AND `student_classes`.`student_id` IN ($student_ids) "
                . "AND `subject_years`.`year` IN ($student_years)
            ORDER BY `subjects`.`name` ASC";
        

        $query = $this->db->query($q);

        return $query->result();
    }

    public function get_subject_by_id($id = '') {
        $where_arr = array('id' => $id);
        $this->db->where($where_arr);
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    public function get_single_subject($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->_table);
        return $query->row();
    }

    public function get_student_subject_years($student_year) {
        $query = $this->db->query("SELECT GROUP_CONCAT(id SEPARATOR ', ') subs
            FROM (`subject_years`)
            WHERE `year` =  $student_year AND publish =1 ");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_allowed_modules_for_student($student_year) {
        $query = $this->db->query(" SELECT GROUP_CONCAT( lessons.id
            SEPARATOR ',' ) AS l_id
            FROM `subject_years`
            JOIN modules ON ( subject_years.id = modules.year_id )
            JOIN lessons ON ( lessons.module_id = modules.id )
            WHERE subject_years.year =$student_year
            AND modules.publish =1");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_main_curriculum($subject_id) {
        $this->db->select('*');
        $this->db->from('curriculum');
        $this->db->where(array('subject_id' => $subject_id, 'year_id' => 0));
        $query = $this->db->get();

        return $query->row();
    }

    public function get_subject_curriculum($subject_id, $year_id) {
        $this->db->select('*');
        $this->db->from('curriculum');
        $this->db->where(array('subject_id' => $subject_id, 'year_id' => $year_id));
        $query = $this->db->get();

        return $query->row();
    }

    public function save_curriculum($data, $subject_id, $id = '', $year_id = 0) {
        $this->db->select('*');
        $this->db->from('curriculum');
        $this->db->where(array('year_id' => $year_id, 'subject_id' => $subject_id));
        $q = $this->db->get();
        if ($q->num_rows() == 0) {
            $this->db->insert('curriculum', array('year_id' => $year_id, 'subject_id' => $subject_id));
            $ins_id = $this->db->insert_id();
            $this->db->update('curriculum', $data, array('id' => $ins_id, 'subject_id' => $subject_id));
        } else {
            $this->db->update('curriculum', $data, array('id' => $id, 'subject_id' => $subject_id));
        }
        return TRUE;
    }

    public function get_subject_years($subject_id) {

        $query = $this->db->order_by("year", "asc")->get_where($this->_year_table, array('subject_id' => $subject_id, 'publish' => 1));

        return $query->result();
    }

    public function get_distinct_subject_years($subject_id) {

        $query = $this->db->query("SELECT  *
FROM (`classes`)
WHERE `subject_id` IN($subject_id)

GROUP BY `year`
ORDER BY `year` asc");
        return $query->result();
    }

    public function get_subject_filtered_years($subject_id, $years_id) {

        $this->db->select('*');
        $this->db->from('classes');
        if($subject_id!=='all'){
            $this->db->where('subject_id', $subject_id);
        }
        $this->db->where('classes.id IN('.$years_id.')');


        $query = $this->db->get();

//echo($this->db->last_query());
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

    public function get_student_subject_year($subject_id, $year_id) {

        $where_arr = array('subject_id' => $subject_id, 'year' => $year_id);
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

    public function get_all_classes_ids_query($teacher_id) {
        if( $teacher_id != 'all' ) {
            $all_classes_ids_query = $this->db->query("SELECT GROUP_CONCAT(DISTINCT classes.id SEPARATOR ',') as cls_id
                FROM `subjects`
                JOIN classes ON ( subjects.id = classes.subject_id )
                JOIN teacher_classes ON ( teacher_classes.class_id = classes.id )
                WHERE subjects.publish =1 AND teacher_classes.teacher_id =$teacher_id");
        } else {
            $all_classes_ids_query = $this->db->query("SELECT GROUP_CONCAT(DISTINCT classes.id SEPARATOR ',') as cls_id
                FROM `subjects`
                JOIN classes ON ( subjects.id = classes.subject_id )
                JOIN teacher_classes ON ( teacher_classes.class_id = classes.id )
                WHERE subjects.publish =1");
        }
        if( $all_classes_ids_query->row() ) {
            return $all_classes_ids_query->row();
        } else {
            return null;
        }
        return $all_classes_ids_query->row();
    }

    public function get_classes_list($classes_ids,$teacher_id) {
        if( $teacher_id != 'all' ) {
            $r = $this->db->query("SELECT * FROM classes JOIN teacher_classes ON ( class_id = id ) JOIN subjects ON ( subjects.id = classes.subject_id ) WHERE class_id IN ($classes_ids) AND teacher_id = $teacher_id");
        } else {
            $r = $this->db->query("SELECT * FROM classes JOIN teacher_classes ON ( class_id = id ) JOIN subjects ON ( subjects.id = classes.subject_id ) WHERE class_id IN ($classes_ids) ");
        }
        return $r->result();
    }

    public function get_classes_lists($find, $subject_id, $class_id, $year, $teacher_id) {
        if ($find == 'all') {
            $end_q = $subject_id == 'all' ? '' : "and subjects.id = $subject_id";
            $teacher_exists = $teacher_id == 'all' ? '' : "teacher_classes.teacher_id = $teacher_id AND";

            $qu = $this->db->query("SELECT classes.id AS class_id,year,group_name,subjects.name as subject_name 
                                    FROM `classes`
                                    JOIN teacher_classes ON(classes.id=teacher_classes.class_id)
                                    JOIN subjects ON(subjects.id=classes.subject_id)
                                    WHERE $teacher_exists class_id IN($class_id) $end_q 
                                    GROUP BY class_id");
        } else {
            $end_q = $subject_id == 'all' ? '' : "and subjects.id = $subject_id";
            $teacher_exists = $teacher_id == 'all' ? '' : "AND teacher_classes.teacher_id = $teacher_id";
            $qu = $this->db->query("SELECT classes.id AS class_id,year,group_name,subjects.name as subject_name 
                                    FROM `classes`
                                    JOIN teacher_classes ON(classes.id=teacher_classes.class_id)
                                    JOIN subjects ON(subjects.id=classes.subject_id)
                                    WHERE year IN ($year) $teacher_exists $end_q 
                                    GROUP BY class_id");
        }

        return  $qu->result();
    }

    static public function unpublish_modules($subject_id, $year_id) {
        $modules = self::$db->get_where('modules', array('subject_id' => $subject_id, 'year_id' => $year_id));

        foreach ($modules->result() as $row) {
            Modules_model::unpublish_module($row->id);
            Lessons_model::unpublish_module_lessons($row->id);
        }
        return $res;
    }

    static public function unpublish_subject($subject_id) {
        $res = self::$db->update('curriculum', array('publish' => 0), array('subject_id' => $subject_id));
        $modules = self::$db->get_where('modules', array('subject_id' => $subject_id));

        foreach ($modules->result() as $row) {
            Modules_model::unpublish_module($row->id);
            Lessons_model::unpublish_module_lessons($row->id);
        }
        return $res;
    }

    static public function get_subject_logo( $subject_id ) {
        self::$db->select( 'logo_pic' );
        self::$db->from( 'subjects' );
        self::$db->where('id', $subject_id);
        $query = self::$db->get();
        $return = $query->row();
        return $return->logo_pic;
    }

    static public function get_subject_title( $subject_id ) {
        self::$db->select( 'name' );
        self::$db->from( 'subjects' );
        self::$db->where('id', $subject_id);
        $query = self::$db->get();
        $return = $query->row();
        return $return->name;
    }

}
