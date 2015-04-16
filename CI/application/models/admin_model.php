<?php

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @access public
     * @param str $username (valid email)
     * @param str $password (SHA1)
     * @return BOOL(FALSE)/OR Admin data
     * @ 
     * 
     */
    public function login($username, $password) {
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where(array('email' => $username, 'password' => $password));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    /**
     * @access public
     * @return BOOL 
     */
    public function check_object($objects) {
        foreach ($objects as $obj) {
            $this->db->select('*');
            $this->db->from('subjects');
            $this->db->where('name', $obj);
            $query = $this->db->get();
            if ($query->num_rows() == 0) {
                return array('result' => FALSE, 'field' => $obj);
            }
        }
        return array('result' => TRUE);
    }

//check for existing class or create it 
    public function map_subjects($subject_name, $unique_subj) {
        foreach ($unique_subj as $subject) {
            $this->db->select('id');
            $this->db->from('subjects');
            $this->db->where('name', $subject_name);
            $q = $this->db->get();
            $s_id = $q->row();
            $subject_id = $s_id->id;

            $this->db->select('*');
            $this->db->from('classes');
            $group_name = substr($subject, -1);
            $year = substr($subject, 0, -1);

            $this->db->where(array('subject_id' => $subject_id, 'year' => $year, 'group_name' => strtolower($group_name)));

            $query = $this->db->get();

            if ($query->num_rows() == 0) {
                $this->db->insert('classes', array('subject_id' => $subject_id, 'year' => $year, 'group_name' => strtolower($group_name)));
            }
        }
    }

    //import users in users column
    public function check_imp_user($user) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $user['email']);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            $this->db->insert('users', $user);
            return array('user_id' => $this->db->insert_id(), 'msg' => $user['email'] . '- Inserted');
        } else {
            $result = $query->row_array();
            $this->db->where('id', $result['id']);
            $this->db->update('users', $user);
            return array('user_id' => $result['id'], 'msg' => $user['email'] . '- Updated');
        }
    }

    public function check_student_year_group($user_id, $year_name, $subject_name) {
        //first get subject id from subjects
        $this->db->select('id');
        $this->db->from('subjects');
        $this->db->where('name', $subject_name);
        $qt = $this->db->get();
        $s_id = $qt->row();
        $subject_id = $s_id->id;

        $this->db->select('id');
        $this->db->from('classes');
        $group_name = substr($year_name, -1);
        $year = substr($year_name, 0, -1);
        $this->db->where(array('subject_id' => $subject_id, 'year' => $year, 'group_name' => strtolower($group_name)));
        $query = $this->db->get();
        $res = $query->row();
        if ($query->num_rows() == 1) {
            $class_id = $res->id;
            $this->db->select('*');
            $this->db->from('student_classes');
            $this->db->where(array('student_id' => $user_id, 'class_id' => $class_id));
            $q = $this->db->get();
            if ($q->num_rows() == 0) {
                $this->db->insert('student_classes', array('student_id' => $user_id, 'class_id' => $class_id));
            }
        }
    }

    /* SUBJECTS */

    //get all subjects
    public function get_all_subjects() {
        $this->db->select('id,name');
        $this->db->from('subjects');
        $this->db->where('name !=', '');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_subject_by_id($id) {
        $this->db->select('*');
        $this->db->from('subjects');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_subject_years($subject_id) {
        $query = $this->db->order_by("year", "asc")->get_where('subject_years', array('subject_id' => $subject_id));
        return $query->result_array();
    }

    public function get_subject_years_name($subject_id) {
        $q = "SELECT GROUP_CONCAT(year SEPARATOR ', ') as rst FROM subject_years WHERE subject_id='$subject_id'";
        $result = $this->db->query($q);

        return $result->row_array();
    }

    public function get_all_subject_years() {
        $this->db->select('year');
        $this->db->from('subject_years');
        $this->db->group_by('year');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_published_subject_years($subject_id) {
        $q = "SELECT GROUP_CONCAT(year SEPARATOR ', ') as rst FROM subject_years WHERE subject_id='$subject_id' AND publish=1";
        $query = $this->db->query($q);

        return $query->row_array();
    }

    public function add_subject($data) {
        if ($data['publish'] == false) {
            $publish = 0;
        } else {
            $publish = 1;
        }

        $this->db->insert('subjects', array('name' => $data['name'], 'publish' => $publish, 'logo_pic' => $data['icon']));

        return $this->db->insert_id();
    }

    public function update_subject($id, $data) {
        if ($data['publish'] == false) {
            $publish = 0;
        } else {
            $publish = 1;
        }

        $this->db->where('id', $id);
        $this->db->update('subjects', array('name' => $data['name'], 'publish' => $publish, 'logo_pic' => $data['icon']));

        return TRUE;
    }

    public function update_subject_years($years, $subject_id) {
        echo '<pre>';
        print_r($years);
        die();
        $this->db->where(array('subject_id' => $subject_id));
        $this->db->update('subject_years', array('publish' => 0));

        foreach ($years as $y) {
            $this->db->select('*');
            $this->db->from('subject_years');
            $this->db->where(array('subject_id' => $subject_id, 'year' => $y['year']));

            $q = $this->db->get();

            if ($q->num_rows() == 0) {
                $this->db->insert('subject_years', array('subject_id' => $subject_id, 'year' => $y['year'], 'publish' => 1));
            } else if ($q->num_rows() == 1) {
                $this->db->where(array('subject_id' => $subject_id, 'year' => $y['year']));
                $this->db->update('subject_years', array('publish' => 1));
            }
        }

        //update curriculum table
        foreach ($years as $y) {
            $this->db->select('*');
            $this->db->from('curriculum');
            $this->db->where(array('subject_id' => $subject_id, 'year_id' => $y['year']));
            $query = $this->db->get();

            if ($query->num_rows() == 0) {
                $this->db->insert('curriculum', array('subject_id' => $subject_id, 'year_id' => $y['year']));
            }
        }

        $this->db->select('*');
        $this->db->from('curriculum');
        $this->db->where(array('subject_id' => $subject_id, 'year_id' => 0));
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            $this->db->insert('curriculum', array('subject_id' => $subject_id, 'year_id' => 0));
        }

        return TRUE;
    }

    /* END SUBJECTS */

    /* USERS */

    public function searchUsers($firstName, $lastName, $emailAddress, $userType, $limit, $offset) {
        $this->db->select('id, first_name, last_name, email, user_type');
        $this->db->limit($limit, $offset);

        if ($firstName !== '') {
            $this->db->like('first_name', $firstName);
        }

        if ($lastName !== '') {
            $this->db->like('last_name', $lastName);
        }

        if ($emailAddress !== '') {
            $this->db->like('email', $emailAddress);
        }

        if ($userType !== 'all') {
            $this->db->where('user_type', $userType);
        }

        $q = $this->db->get('users');

        return $q->result_array();
    }

    public function countUsers($firstName, $lastName, $emailAddress, $userType) {
        if ($firstName !== '') {
            $this->db->like('first_name', $firstName);
        }

        if ($lastName !== '') {
            $this->db->like('last_name', $lastName);
        }

        if ($emailAddress !== '') {
            $this->db->like('email', $emailAddress);
        }

        if ($userType !== 'all') {
            $this->db->where('user_type', $userType);
        }

        $this->db->from('users');

        return $this->db->count_all_results();
    }

    public function getUser($id) {
        $this->db->select('user_type');
        $this->db->where('id', $id);
        $q = $this->db->get('users');

        return $q->row();
    }

    public function getUserIDByEmail($email) {
        $this->db->select('id');
        $this->db->where('email', $email);
        $q = $this->db->get('users');

        $row = $q->row();
        if ($row) {
            return intval($row->id);
        } else {
            return 0;
        }
    }

    public function createUserRecord($user) {
        $this->db->set('user_type', $user['user_type']);
        $this->db->set('password', md5($user['password']));
        $this->db->set('first_name', $user['first_name']);
        $this->db->set('last_name', $user['last_name']);
        $this->db->set('email', $user['email']);
        $this->db->set('student_year', $user['student_year']);

        $this->db->insert('users');

        return $this->db->insert_id();
    }

    public function updateUserRecord($id, $user) {
        $this->db->set('user_type', $user['user_type']);
        $this->db->set('password', md5($user['password']));
        $this->db->set('first_name', $user['first_name']);
        $this->db->set('last_name', $user['last_name']);
        $this->db->set('email', $user['email']);
        $this->db->set('student_year', $user['student_year']);

        $this->db->where('id', $id);

        $this->db->update('users');
    }

    public function getSubjectYearID($subjectID, $year) {
        $this->db->where('subject_id', $subjectID);
        $this->db->where('year', $year);

        $q = $this->db->get('subject_years');

        $row = $q->row();
        if ($row) {
            return intval($row->id);
        } else {
            return 0;
        }
    }

    public function createSubjectYearRecord($subjectID, $year) {
        $this->db->set('subject_id', $subjectID);
        $this->db->set('year', $year);
        $this->db->set('publish', 1);

        $this->db->insert('subject_years');

        return $this->db->insert_id();
    }

    public function getClassID($subject_id, $year, $group_name) {
        $this->db->where('subject_id', $subject_id);
        $this->db->where('year', $year);
        $this->db->where('lower(group_name) = lower(\'' . addslashes($group_name) . '\')', NULL);

        $q = $this->db->get('classes');

        $row = $q->row();
        if ($row) {
            return intval($row->id);
        } else {
            return 0;
        }
    }

    public function createClassRecord($class) {
        $this->db->set('subject_id', $class['subject_id']);
        $this->db->set('year', $class['class_year']);
        $this->db->set('group_name', $class['class_group_name']);

        $this->db->insert('classes');

        return $this->db->insert_id();
    }

    public function addUserToClass($userType, $userID, $classID) {
        if (trim(strtolower($userType)) === 'teacher') {
            $table = 'teacher_classes';
            $field = 'teacher_id';
        } else if (trim(strtolower($userType)) === 'student') {
            $table = 'student_classes';
            $field = 'student_id';
        } else {
            return false;
        }

        $this->db->where('class_id', $classID);
        $this->db->where($field, $userID);
        $this->db->delete($table);

        $this->db->set('class_id', $classID);
        $this->db->set($field, $userID);
        $this->db->insert($table);

        return $this->db->insert_id();
    }

    public function createUserOneLoginRecord($userID, $email, $password) {
        $this->db->delete('user_onelogins', array('oneloginid' => $email));

        $this->db->set('user_id', $userID);
        $this->db->set('oneloginid', $email);
        $this->db->set('system_password', $password);
        $this->db->insert('user_onelogins');

        return $this->db->insert_id();
    }

    public function deleteTeacher($id) {
        $this->db->delete('teacher_classes', array('teacher_id' => $id));
        $this->db->delete('user_onelogins', array('id' => $id));
        $this->db->delete('user_openids', array('id' => $id));
        $this->db->delete('users', array('id' => $id));
    }

    public function deleteStudent($id) {
        $this->db->delete('student_classes', array('student_id' => $id));
        $this->db->delete('user_onelogins', array('id' => $id));
        $this->db->delete('user_openids', array('id' => $id));
        $this->db->delete('users', array('id' => $id));
    }

    /* END USERS */
}

?>
