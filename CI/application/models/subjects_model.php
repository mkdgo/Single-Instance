<?php

class Subjects_model extends CI_Model {

    private $_table = 'subjects';
    private $_year_table = 'subject_years';
    private static $db;

    public function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    public function get_subjects($fields = '*') {
        $this->db->select($fields);
        $this->db->from($this->_table);
        $this->db->where('publish', 1);
        $query = $this->db->get();
        return $query->result();
    }


    public function get_teacher_subjects($teacher_id) {
        $this->db->select('subjects.id,subjects.name,GROUP_CONCAT(DISTINCT classes.id  SEPARATOR ",") as classes_ids',false);

        $this->db->from('teacher_classes');
        $this->db->join('classes','classes.id = teacher_classes.class_id');
        $this->db->join('subjects','subjects.id = classes.subject_id');
        if($teacher_id!='all') {
            $this->db->where(array('subjects.publish' => 1, 'teacher_classes.teacher_id' => $teacher_id));
        }
        else{
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
        //$q = "SELECT `subjects`.`id`, `subjects`.`name`, `subjects`.`logo_pic`, `subjects`.`publish`, `subject_years`.`subject_id`, `subject_years`.`year` ,(SELECT COUNT(*) FROM modules WHERE subject_id=`subject_years`.`subject_id` AND publish=1)ccn FROM (`subjects`) JOIN `subject_years` ON `subject_years`.`subject_id`=`subjects`.`id` WHERE `subject_years`.`year` = $student_year AND `subjects`.`publish` = 1";
        $q = "SELECT DISTINCT `subjects`.`id`, `subjects`.`name`, `subjects`.`logo_pic`, `subjects`.`publish`, `subject_years`.`subject_id`, `subject_years`.`year`,
                (SELECT COUNT(*) FROM modules WHERE subject_id=`subject_years`.`subject_id` AND publish=1)ccn FROM (`subjects`) JOIN `subject_years` ON `subject_years`.`subject_id`=`subjects`.`id` 
			    RIGHT JOIN `classes` on `classes`.`subject_id` = `subjects`.`id`
				RIGHT JOIN `student_classes` on `student_classes`.`class_id`=`classes`.`id`
				WHERE `subject_years`.`year` = $student_year 
				AND `student_classes`.`student_id`= $student_id
				AND `subjects`.`publish` = 1";
//echo $q;die;
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

    public function save($data, $id = '') {
        if ($id) {
            $this->db->update($this->_table, $data, array('id' => $id));
        } else {
            $this->db->insert($this->_table, $data);
            $id = $this->db->insert_id();
        }

        return $id;
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
        $this->db->where('subject_id',$subject_id);}
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

    public function get_all_classes_ids_query($teacher_id) {
        if($teacher_id!='all') {
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

        return $all_classes_ids_query->row();
    }

    public function get_classes_list($classes_ids,$teacher_id) {
        if($teacher_id!='all') {
            $r = $this->db->query("SELECT * FROM classes JOIN teacher_classes ON ( class_id = id ) JOIN subjects ON ( subjects.id = classes.subject_id ) WHERE class_id IN ($classes_ids) AND teacher_id = $teacher_id");
        } else {
            $r = $this->db->query("SELECT * FROM classes JOIN teacher_classes ON ( class_id = id ) JOIN subjects ON ( subjects.id = classes.subject_id ) WHERE class_id IN ($classes_ids) ");
        }
        return $r->result();
    }


    public function get_classes_lists($find,$subject_id,$class_id,$year,$teacher_id)
    {
        if($find=='all')
        {
            $end_q = $subject_id=='all'? '' : "and subjects.id = $subject_id";
            $teacher_exists=	$teacher_id=='all'?'':"teacher_classes.teacher_id=$teacher_id AND";

            $qu =$this->db->query( "SELECT classes.id AS class_id,year,group_name,subjects.name as subject_name FROM `classes`
JOIN teacher_classes ON(classes.id=teacher_classes.class_id)
JOIN subjects ON(subjects.id=classes.subject_id)
where  $teacher_exists class_id IN($class_id) $end_q GROUP BY class_id");

}
        else
        {
            $end_q = $subject_id=='all'? '' : "and subjects.id = $subject_id";
            $teacher_exists=	$teacher_id=='all'?'':"AND teacher_classes.teacher_id=$teacher_id";
            $qu =$this->db->query( "SELECT classes.id AS class_id,year,group_name,subjects.name as subject_name FROM `classes`
JOIN teacher_classes ON(classes.id=teacher_classes.class_id)
JOIN subjects ON(subjects.id=classes.subject_id)
where year IN ($year) $teacher_exists $end_q GROUP BY class_id");
        }

        return  $qu->result();


    }

}
