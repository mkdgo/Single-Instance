<?php

class User_model extends CI_Model {

    private $_table = 'users';
    private $_pictures_table = 'pictures';
    private $_user_type_table = 'nc_user_types';
    private $_lang_table = 'langs';
    private $_lang_content_table = 'lang_content';
    private static $db;

    public function __construct() {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    public function get_users_list($filter = array(), $order = array(), $fields = array('id', 'nickname', 'last_name', 'email', 'user_type_id', 'ip')) {
        if (count($filter) > 0) {
            $this->db->or_like($filter);
        } $query = $this->db->select($fields)->order_by($order['field'], $order['method'])->get($this->_table);
        return $query->result();
    }

    public function get_users($where = array()) {
        $this->db->where($where);
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    public function get_users_for_demo_login( $user_type, $order = array(), $fields = array( 'first_name', 'last_name', 'email', 'user_type', 'student_year') ) {
//        $this->db->where($where);
//        $query = $this->db->get($this->_table);
        $query = $this->db->select($fields)->where(array('user_type' => $user_type))->order_by( 'user_type, first_name' )->get($this->_table);
        return $query->result();
    }

    public function get_user($id) {
        $query = $this->db->get_where($this->_table, array('id' => $id));
        return $query->row();
    }

    public function get_user_by_nickname($nickname) {
        $query = $this->db->get_where($this->_table, array('nickname' => $nickname), 1);
        return $query->result();
    }

    public function get_user_by_email($email) {
        $query = $this->db->get_where($this->_table, array('email' => $email));
        return $query->row_array();
    }

    public function get_user_by_password_recovery_token($token) {
        $query = $this->db->get_where($this->_table, array('password_recovery_token' => $token));
        return $query->row_array();
    }

    public function update_user_password($id, $password) {
        $this->db->set('password', $password);
        $this->db->where('id', $id);
        $this->db->update($this->_table);
    }

    public function save_user($data = array(), $id = '') {
        if ($id) {
            $this->db->update($this->_table, $data, array('id' => $id));
        } else {
            $this->db->insert($this->_table, $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function setPasswordRecoveryToken($id, $token) {
        $this->db->set('password_recovery_token', $token);
        $this->db->where('id', $id);
        $this->db->update($this->_table);
    }

    public function get_last_id() {
        $query = $this->db->select(array('id'))->order_by('id', 'desc')->get($this->_table, 1);
        return $query->result();
    }

    public function delete_user($id) {
        $this->db->delete($this->_table, array('id' => $id));
    }

    function check_user($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->_table);
        if ($query->num_rows() === 1) {
            return true;
        } return false;
    }

    function check_user_by_nickname($nickname) {
        $this->db->where(array('nickname' => $nickname));
        $query = $this->db->get($this->_table);
        if ($query->num_rows() === 1) {
            return true;
        } return false;
    }

    public function check_unique_email($mail, $id) {
        $this->db->where('id !=', $id);
        $this->db->where('email', $mail);
        $query = $this->db->get($this->_table);
        if ($query->num_rows() > 0) {
            return true;
        } return false;
    }

    public function check_unique_nickname($nickname, $id) {
        $this->db->where('id !=', $id);
        $this->db->where('nickname', $nickname);
        $query = $this->db->get($this->_table);
        if ($query->num_rows() > 0) {
            return true;
        } return false;
    }

    public function get_picture_type($object_id, $type_id, $object_type = 'user') {
        $where = array('object_id' => $object_id, 'object_type' => $object_type, 'type' => $type_id,);
        $this->db->where($where);
        $query = $this->db->get($this->_pictures_table);
        return $query->result();
    }

    public function get_pictures($object_id, $object_type = 'user') {
        $where = array('object_id' => $object_id, 'object_type' => $object_type,);
        $this->db->where($where);
        $query = $this->db->get($this->_pictures_table);
        return $query->result();
    }

    public function get_user_permissions($user_id) {
        $this->db->select(array($this->_table . '.moderator', $this->_table . '.suggested', $this->_table . '.model', $this->_table . '.live_girl', $this->_lang_table . '.key', $this->_lang_content_table . '.content'));
        $this->db->from(array($this->_table, $this->_lang_table));
        $this->db->where(array($this->_table . '.id' => $user_id, $this->_lang_content_table . '.object_table' => $this->_user_type_table, $this->_lang_table . '.key' => 'en'));
        $this->db->join($this->_user_type_table, $this->_user_type_table . '.id = ' . $this->_table . '.user_type_id');
        $this->db->join($this->_lang_content_table, $this->_lang_content_table . '.object_id = ' . $this->_user_type_table . '.id');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    public function check_user_exist($email, $password) {
//        if( DEMO == 1 ) {
        if( $this->_school['site_type'] == 'demo' ) {
            $where_arr = array('email' => $email);
        } else {
            $where_arr = array('email' => $email, 'password' => md5($password));
        }
        $this->db->select('*');
        $this->db->where($where_arr);
        $this->db->from($this->_table);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    public function check_accept_chat($user_id) {
        $where_arr = array('id' => $user_id);
        $this->db->where($where_arr);
        $this->db->select(array('accept_chat'));
        $this->db->limit(1);
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    public function disable_audio_video($user_id) {
        $where_arr = array('id' => $user_id);
        $this->db->where($where_arr);
        $this->db->select(array('disable_audio_video'));
        $this->db->limit(1);
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    public function update_last_seen($user_id) {
        $this->db->set('last_seen', 'NOW()', FALSE);
        $this->db->where('id', $user_id);
        $this->db->update($this->_table);
    }

    public function update_online($user_id) {
        $this->db->set('is_online', '1', FALSE);
        $this->db->where('id', $user_id);
        $this->db->update($this->_table);
    }

    public function update_password($user_id, $password) {
        $this->db->set('password', $password);
        $this->db->where('id', $user_id);
        $this->db->update($this->_table);
    }

    public function reset_online($user_id) {
        $this->db->set('is_online', '0', FALSE);
        $this->db->where('id', $user_id);
        $this->db->update($this->_table);
    }

    public function get_students_for_lesson($lesson_id, $online = false) {
        $this->db->select('DISTINCT users.id, users.first_name, users.last_name, users.is_online AS online', FALSE);
//        $this->db->select('DISTINCT users.id, users.first_name, users.last_name, IFNULL(3 - TIME_TO_SEC(TIMEDIFF(NOW(), users.last_seen)), 0) > 0 AS online', FALSE);
        $this->db->from('lessons');
        $this->db->join('lessons_classes', 'lessons_classes.lesson_id = lessons.id', 'inner');
        $this->db->join('student_classes', 'student_classes.class_id = lessons_classes.class_id', 'inner');
        $this->db->join('classes', 'classes.id = student_classes.class_id', 'inner');
        //$this->db->join('users', 'users.student_year = classes.year AND users.id = student_classes.student_id', 'inner');
        $this->db->join('users', 'users.id = student_classes.student_id', 'inner');
        $this->db->where('lessons.id', $lesson_id);
        $this->db->where('users.user_type', 'student');
        if ($online) {
            $this->db->where('users.is_online = 1');
//            $this->db->where('IFNULL(3 - TIME_TO_SEC(TIMEDIFF(NOW(), users.last_seen)), 0) >', '0', FALSE);
        }
        $this->db->order_by('users.first_name, users.last_name');
        $query = $this->db->get();
        return $query->result();
    }

    public function assign_user_openid($openid, $user_id, $sys_pass) {
        $this->db->insert('user_openids', array('openid' => $openid, "user_id" => $user_id, 'system_password' => $sys_pass));
        $this->db->insert_id();
    }

    public function assign_user_oneloginid($oneloginid, $user_id, $sys_pass) {
        $this->db->insert('user_onelogins', array('oneloginid' => $oneloginid, "user_id" => $user_id, 'system_password' => $sys_pass));
        $this->db->insert_id();
    }

    public function get_user_by_openid($openid) {
        $this->db->from('user_openids');
        $this->db->join('users', 'users.id = user_openids.user_id', 'left');
        $this->db->where('user_openids.openid', $openid);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_user_by_oneloginid($oneloginid) {
        $this->db->from('user_onelogins');
        $this->db->join('users', 'users.id = user_onelogins.user_id', 'left');
        $this->db->where('user_onelogins.oneloginid', $oneloginid);
        $query = $this->db->get();

        return $query->result();
    }

    public function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

    public function get_students_for_teacher($teacher_id) {
        $this->db->select('users.id, users.first_name, users.last_name');

        $this->db->from('teacher_classes');
        $this->db->join('student_classes', 'student_classes.class_id = teacher_classes.class_id', 'inner');
        $this->db->join('classes', 'classes.id = student_classes.class_id', 'inner');
        $this->db->join('users', 'users.student_year = classes.year AND users.id = student_classes.student_id', 'inner');

        $this->db->where('teacher_classes.teacher_id', $teacher_id);
        $this->db->where('users.user_type', 'student');
        $this->db->order_by('users.first_name, users.last_name');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_teacher_classes($teacher_id) {
        $this->db->select('subjects.name AS subject_name, classes.id, classes.year, classes.group_name');

        $this->db->from('teacher_classes');
        $this->db->join('classes', 'classes.id = teacher_classes.class_id', 'inner');
        $this->db->join('subjects', 'subjects.id = classes.subject_id', 'inner');
        $this->db->join('users', 'users.id = teacher_classes.teacher_id', 'inner');

        $this->db->where('users.user_type', 'teacher');
        $this->db->where('users.id', $teacher_id);
        $this->db->order_by('subjects.name, classes.year, classes.group_name');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_student_classes($student_id) {

        $this->db->select('subjects.name AS subject_name, subjects.id AS subject_id,subjects.logo_pic, classes.id, classes.year, classes.group_name');
        $this->db->from('student_classes');
        $this->db->join('classes', 'classes.id = student_classes.class_id', 'inner');
        $this->db->join('subjects', 'subjects.id = classes.subject_id', 'inner');
        $this->db->join('users', 'users.id = student_classes.student_id', 'inner');

        $this->db->where('users.user_type', 'student');
        $this->db->where('users.id', $student_id);

        $this->db->order_by('classes.year, subjects.name');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_student_class_by_subject($student_id, $subject_id) {

        $this->db->select('subjects.name AS subject_name, subjects.id AS subject_id,subjects.logo_pic, classes.id as class_id, classes.year, classes.group_name as class_name');
        $this->db->from('student_classes');
        $this->db->join('classes', 'classes.id = student_classes.class_id', 'inner');
        $this->db->join('subjects', 'subjects.id = classes.subject_id', 'inner');
        $this->db->join('users', 'users.id = student_classes.student_id', 'inner');

        $this->db->where('users.user_type', 'student');
        $this->db->where('users.id', $student_id);
        $this->db->where('subjects.id', $subject_id);

        $this->db->order_by('classes.year, subjects.name');
        $query = $this->db->get();

        return $query->first_row();
    }


    public function get_student_classes_profile($student_id) {
        $this->db->select('subjects.name AS subject_name, classes.id as cls_id, classes.year, classes.group_name, classes.subject_id as subj_id,subject_years.id as years_ids');

        $this->db->from('student_classes');
        $this->db->join('classes', 'classes.id = student_classes.class_id', 'inner');
        $this->db->join('subjects', 'subjects.id = classes.subject_id', 'inner');
        $this->db->join('users', 'users.id = student_classes.student_id', 'inner');
        $this->db->join('subject_years', 'subject_years.subject_id=classes.subject_id', 'inner');

        $this->db->where('users.user_type', 'student');
        $this->db->where('users.id', $student_id);
        $this->db->group_by('classes.subject_id');
        $this->db->order_by('classes.year, subjects.name');
        $query = $this->db->get();
        if($query->num_rows()>0) {
            return $query->row();
        } else {
            return false;
        }
    }


    public function get_students_in_class($class_id) {
        $this->db->select('users.id, users.first_name, users.last_name');
        $this->db->from('student_classes');
        $this->db->order_by('users.first_name ASC, users.last_name ASC');
        $this->db->join('users', 'users.id = student_classes.student_id', 'inner');
        $this->db->where('users.user_type', 'student');
        $this->db->where('student_classes.class_id', $class_id);

        $query = $this->db->get();

        return $query->result();
    }

    public function get_all_students() {
        $this->db->select('id,first_name,last_name');
        $this->db->from('users');
        $this->db->where('user_type', 'student');
        $q = $this->db->get();
        return $q->result();
    }

    public function get_teachers($id, $order = 'first_name') {
        $this->db->select('id,first_name,last_name');
        $this->db->from('users');
        $this->db->where(array('user_type' => 'teacher', 'id !=' => $id));
        $this->db->order_by($order, "asc"); 
//        $this->db->order_by("first_name", "asc"); 
        $q = $this->db->get();
        return $q->result();
    }

    static public function get_teacher($id) {
        self::$db->select('id,first_name,last_name');
        self::$db->from('users');
        self::$db->where(array('user_type' => 'teacher', 'id' => $id));
        $q = self::$db->get();
        return $q->row();
    }

    static public function getUserName($id) {
        self::$db->select('first_name,last_name');
        self::$db->from('users');
        self::$db->where(array('id' => $id));
        $q = self::$db->get();
        $user = $q->row();
        $name = trim( $user->first_name ) . ' ' . trim( $user->last_name );
        return $name;
    }

    static public function get_student_year($id) {
        self::$db->select('student_year');
        self::$db->from('users');
        self::$db->where('id', $id);
        $query = self::$db->get();
        $return = $query->row();
        return $return->student_year;
    }
    
    public function get_users_custom_search($where, $order = null) {
        $this->db->select('id,first_name,last_name');
        $this->db->from('users');
        $this->db->where($where);
        if( $order ) {
            $this->db->order_by($order);
        }
        $q = $this->db->get();
        return $q->result();
    }

}
