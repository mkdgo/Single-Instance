<?php

class Classes_model extends CI_Model {

    private $_table = 'classes';
    private $_student_classes_table = 'student_classes';

    public function __construct() {
        parent::__construct();
    }

    public function get_class_name( $class_id) {
        $this->db->select('group_name');
        $this->db->from($this->_table);
        $this->db->where('id', $class_id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_groupname_list( $class_ids_list ) {
        $this->db->select('group_name');
        $this->db->from($this->_table);
        $this->db->where('classes.id IN(' . $class_ids_list . ')');
//        $this->db->where('id', $class_id);
        $query = $this->db->get();
        $lists = $query->result_array();
        foreach( $lists as $item ) {
            $group_list .= $item['group_name'].', ';
        }
//echo '<pre>'; var_dump( $query->result_array() );//die;
        return rtrim( $group_list, ', ' );
    }

    public function get_classes_for_subject_year($subject, $year) {
        $this->db->select('classes.id, classes.year, classes.group_name');
        $this->db->from($this->_table);
        $this->db->where('subject_id', $subject);
        if ($year !== 'all') {
            $this->db->where('year', $year);
        }
        $this->db->order_by('group_name', 'asc');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_classes_for_subject_year_class($subject, $class_id, $year) {
        $this->db->select('classes.id, classes.year, classes.group_name');
        $this->db->from($this->_table);
        $this->db->where('subject_id', $subject);
        $this->db->where('classes.id IN(' . $class_id . ')');
        $this->db->order_by('group_name', 'asc');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_classes_for_subject_year_by_filter($teacher_id, $subject, $year) {
        $this->db->select('classes.id, classes.year, classes.group_name');
        $this->db->from($this->_table);
        $this->db->join('teacher_classes', 'teacher_classes.class_id = classes.id', 'inner');
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('subject_id', $subject);
        $this->db->where('year', $year);
        $this->db->order_by('group_name', 'asc');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_years_filter($teacher_id, $subject_id, $year) {
        $this->db->select('classes.*,teacher_classes.*');
        $this->db->from('classes,teacher_classes');

        if ($subject_id != 'all') {
            $this->db->where(array('subject_id' => $subject_id));
        }

        if ($teacher_id != 'all') {
            $this->db->where(array('teacher_classes.teacher_id' => $teacher_id));
        }
        if ($year != 'all') {
            $this->db->where(array('year' => $year));
        }

        $this->db->group_by('group_name');
        $this->db->order_by('year', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_single_class_by_subject_and_year($subject, $year, $class_id) {
        $this->db->from($this->_table);
        $this->db->where('subject_id', $subject);
        $this->db->where('year', $year);
        $this->db->where('id', $class_id);

        return $this->db->get()->row_array();
    }

    public function get_classes_for_teacher($teacher_id) {
        $this->db->select('classes.id, classes.year, classes.group_name');
        $this->db->from($this->_table);
        $this->db->join('teacher_classes', 'teacher_classes.class_id = classes.id', 'inner');
        $this->db->where('teacher_id', $teacher_id);
        $this->db->group_by('classes.year');
        $this->db->order_by('year', 'asc');
        $this->db->order_by('group_name', 'asc');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_classes_for_student($student_id) {
        
    }

    public function getAllYears() {
        $this->db->select('year');
        $this->db->distinct();
        $this->db->from($this->_table);
        $this->db->order_by("year", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_student_in_class($student_id, $class_id) {
        $this->db->where('student_id', $student_id);
        $this->db->where('class_id', $class_id);
        return $this->db->get($this->_student_classes_table)->result();
    }

    public function get_subject_name($classID) {
        $this->db->select('name');
        $this->db->from('subjects');
        $this->db->join('classes', 'classes.subject_id = subjects.id');
        $this->db->where('classes.id', $classID);

        $query = $this->db->get();
        return $query->row('name');
    }

    public function get_subject_id($classID) {
        $this->db->select('subjects.id');
        $this->db->from('subjects');
        $this->db->join('classes', 'classes.subject_id = subjects.id');
        $this->db->where('classes.id', $classID);

        $query = $this->db->get();
        return $query->row('id');
    }

    public function get_subject_by_class_id($classID) {
        $this->db->select('subjects.id, subjects.name');
        $this->db->from('subjects');
        $this->db->join('classes', 'classes.subject_id = subjects.id');
        $this->db->where('classes.id', $classID);

        $query = $this->db->get();
        return $query->row();
    }

    public function get_class_teachers($class_id) {
        $this->db->select('users.first_name, users.last_name');
        $this->db->from('users');
        $this->db->join('teacher_classes', 'users.id = teacher_classes.teacher_id');
        $this->db->where('teacher_classes.class_id', $class_id);

        $query = $this->db->get();
        return $query->result();
    }

}
