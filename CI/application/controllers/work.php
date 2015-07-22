<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'libraries/AES/aes.class.php';
require_once APPPATH . 'libraries/AES/aesctr.class.php';

class Work extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function uuid() {
        $user_id = $this->session->userdata('id');

        $subjects = array();

        if (strtolower($this->session->userdata('user_type')) === 'student') {
            $this->load->model('subjects_model');
            $this->load->model('assignment_model');
            $this->load->model('classes_model');

            $studentSubjects = $this->subjects_model->get_students_subjects($this->session->userdata('student_year'), $user_id);
            foreach ($studentSubjects as $subject) {
                $subjects[] = array(
                    'id' => $subject->id,
                    'name' => $subject->name
                );
            }
        }

        echo json_encode(array(
            'identifier' => time() . 'U' . $user_id,
            'subjects' => $subjects,
            'hasSubjects' => (count($subjects) > 0 ? true : false),
        ));
    }

    public function get_students_common_subjects() {
        $this->load->model('user_model');
        $this->load->model('subjects_model');

        $subjects = array();

        $studentIDs = array();
        $yearIDs = array();

        $postedStudents = explode('-', $this->input->post('students'));
        foreach ($postedStudents as $student) {
            $id = intval($student);
            if ($id > 0) {
                $studentIDs[] = $id;
                $yearIDs[] = User_model::get_student_year(intval($id));
            }
        }

        if ((count($studentIDs) > 0) && (count($yearIDs) > 0)) {
            $dbSubjects = $this->subjects_model->get_students_common_subjects(implode(',', $yearIDs), implode(',', $studentIDs));
            foreach ($dbSubjects as $subject) {
                if (!array_key_exists($subject->id, $subjects)) {
                    $subjects[$subject->id] = $subject->name;
                }
            }
        }

        echo json_encode(array(
            'hasCommonSubjects' => (count($subjects) > 0 ? true : false),
            'subjects' => $subjects
        ));
    }

    public function delete_temp_item() {
        $this->load->model('work_model');

        $id = $this->input->post('id');
        $uuid = $this->input->post('uuid');

        $this->work_model->delete_temp_work_item($id, $uuid);

        echo json_encode(array('status' => 'success'));
    }

    public function url_upload() {
        $this->load->model('work_model');
        $this->load->model('search_model');

        $link = $this->input->post('url');
        $uuid = $this->input->post('uuid');

        if ((substr($link, 0, 7) == 'http://')) {
            $prefix = 'http://';
            $url = explode($prefix, $link);
            $link = $prefix . $url[1];
        } else if ((substr($link, 0, 8) == 'https://')) {
            $prefix = 'https://';
            $url = explode($prefix, $link);
            $link = $prefix . $url[1];
        } else if ((substr($link, 0, 4) == 'www.')) {
            $prefix = 'www.';
            $url = explode($prefix, $link);
            $link = 'http://' . $prefix . $url[1];
        }

        $originalFileType = $this->search_model->getURLResourceType($link);

        $temp_id = $this->work_model->insert_temp_work_item($uuid, $link, $originalFileType[0], null, 1, $link);

        $elipses = $link;
        if (strlen($elipses) > 45) {
            $elipses = substr($elipses, 0, 45) . '...';
        }
        $json['status'] = 'success';
        $json['id'] = $temp_id;
        $json['name'] = $elipses;
        $json['fullname'] = $link;
        $json['type'] = $originalFileType[0];

        echo json_encode($json);
    }

    public function item_upload() {
        $key = 'dcrptky@)!$2014dcrpt';

        $this->config->load('upload');
        $this->load->library('upload');
        $this->load->model('work_model');
        $this->load->model('search_model');

        $originalFileName = $this->input->post('filename');
        $originalFileType = $this->search_model->getFileResourceType($originalFileName);
        $uuid = $this->input->post('uuid');

        $CPT_POST = AesCtr::decrypt($this->input->post('qqfile'), $key, 256);
        $CPT_DATA = explode("::", $CPT_POST);

        $dir = $this->config->item('upload_path');
        $funm = explode('.', $_FILES['qqfile']['name']);
        $ext = $funm[count($funm) - 1];
        array_pop($funm);
        $NAME = md5(implode('.', $funm)) . time() . '.' . $ext;

        $uploadfile = $dir . $NAME;

        if (move_uploaded_file($_FILES['qqfile']['tmp_name'], $uploadfile)) {
            $NF_NAME = $dir . $NAME . '_tmp';

            rename($uploadfile, $NF_NAME);

            $img_dataurl = base64_encode(file_get_contents($NF_NAME));

            if ($CPT_DATA[0] == 1) {
                $decrypt = AesCtr::decrypt($img_dataurl, $key, 256);
            } else {
                $half = $CPT_DATA[1];
                $SZ = $CPT_DATA[2];
                $CPT_l = $CPT_DATA[3];

                $crypter_middle = substr($img_dataurl, $half - $SZ, $CPT_l);
                $crypter_middle_decr = AesCtr::decrypt($crypter_middle, $key, 256);

                $decrypt = str_replace($crypter_middle, $crypter_middle_decr, $img_dataurl);
            }

            file_put_contents($uploadfile, base64_decode($decrypt));
            if (is_file($uploadfile))
                unlink($NF_NAME);

            $temp_id = $this->work_model->insert_temp_work_item($uuid, $originalFileName, $originalFileType[0], $NAME, 0);

            $elipses = $originalFileName;
            if (strlen($elipses) > 45) {
                $elipses = substr($elipses, 0, 45) . '...';
            }
            $json['status'] = 'success';
            $json['id'] = $temp_id;
            $json['name'] = $elipses;
            $json['fullname'] = $originalFileName;
            $json['type'] = $originalFileType[0];

            echo json_encode($json);
        } else {
            return false;
        }
    }

    public function suggest_students() {
        $this->load->model('user_model');

        $q = trim($this->input->get('q'));

        // allow characters only
        $parsed = preg_replace("/[^A-Za-z]/", '', $q);

        $where = "user_type = 'student' AND (first_name LIKE '%" . $parsed . "%' OR last_name LIKE '%" . $parsed . "%')";
        $students = $this->user_model->get_users_custom_search($where, 'first_name ASC, last_name ASC');

        $result = array();
        foreach ($students as $student) {
            $result[] = array(
                'id' => $student->id,
                'name' => trim($student->first_name) . ' ' . trim($student->last_name)
            );
        }

        echo json_encode($result);
    }

    public function save_work() {
        $this->load->model('work_model');

        $taggerID = strtolower($this->session->userdata('id'));
        $taggerType = strtolower($this->session->userdata('user_type'));
        $isTeacher = ($taggerType === 'teacher');
        $isStudent = ($taggerType === 'student');

        if (!$isTeacher && !$isStudent) {
            show_error('Server Error');
        }

        $taggedStudents = explode('-', $this->input->post('taggedStudents'));
        $title = trim($this->input->post('title'));
        $subject = intval($this->input->post('subject'));
        $assignment = intval($this->input->post('assignment'));
        $uuid = $this->input->post('uuid');

        $workID = $this->work_model->insert_work($title, $subject, $taggerID);

        $insertedItemIDs = array();
        $tempItems = $this->work_model->get_work_temp_items_by_uuid($uuid);
        foreach ($tempItems as $item) {
            $insertedItemIDs[] = $this->work_model->insert_work_item($workID, $item['item_name'], $item['item_type'], strval($item['item_hash_name']), intval($item['remote']), strval($item['link']));
        }
        $this->work_model->delete_work_temp_items_by_uuid($uuid);

        foreach ($taggedStudents as $student) {
            $id = intval($student);
            if ($id > 0) {
                $this->work_model->insert_work_taggee($workID, $id);
            }
        }

        if ($assignment > 0) {
            $this->work_model->insert_work_assignment($workID, $assignment);
        }

        $this->load->helper('my_helper', false);
        $this->load->model('assignment_model');
        $this->load->model('resources_model');

        foreach ($insertedItemIDs as $wiID) {
            $wi = $this->work_model->get_work_item_by_id($wiID);

            $data = array(
                'teacher_id' => 0,
                'resource_name' => $wi->item_hash_name,
                'name' => $wi->item_name,
                'type' => 'workitem',
                'is_remote' => intval($wi->remote),
                'active' => 0
            );

            $resource_id = $this->resources_model->save($data);
            $this->assignment_model->insert_assignment_resource($resource_id, $assignment);

            $this->work_model->update_work_item_with_resource_id($wi->id, $resource_id);

            if (intval($wi->remote) === 0) {
                My_helpers::homeworkGenerate(array(
                    $wi->item_hash_name,
                    ($assignment > 0) ? $assignment : "work_" . $workID,
                    $resource_id,
                    $_SERVER['HTTP_HOST']
                ));
            }
        }

        echo json_encode(array('status' => true));
    }

    public function load_student_assignments() {
        $this->load->model('assignment_model');
        $this->load->model('classes_model');

        $student_id = $this->input->get('student_id');
        $subject_id = $this->input->get('subject_id');

        $assignments = array();

        $opened = $this->assignment_model->get_assignments_student($student_id, array('A.active = 1', 'A.deadline_date > NOW()'));
        $past = $this->assignment_model->get_assignments_student($student_id, array('A.active = 1', 'A.publish_marks = 0', 'A.deadline_date < NOW()'));
        $all = array_merge($opened, $past);

        foreach ($all as $v) {
            $subject = $this->classes_model->get_subject_by_class_id($v->class_id);
            if (intval($subject->id) === intval($subject_id)) {
                $assignments[] = array(
                    'id' => $v->id,
                    'title' => $v->title,
                    'subject' => $this->classes_model->get_subject_name($v->class_id)
                );
            }
        }

        $combined = array();
        foreach ($assignments as $a) {
            $combined[$a['subject']][] = array(
                'id' => $a['id'],
                'title' => $a['title']
            );
        }

        echo json_encode(array(
            'hasAssignments' => (count($combined) > 0 ? true : false),
            'assignments' => $combined
        ));
    }

    public function get_student_data() {
        $this->load->model('user_model');
        $this->load->model('assignment_model');
        $this->load->model('classes_model');
        $this->load->model('subjects_model');

        $studentID = intval($this->input->get('student_id'));
        $student = $this->user_model->get_user($studentID);
        $yearID = $student->student_year;

        $subjects = array();
        $dbSubjects = $this->subjects_model->get_students_common_subjects($yearID, $studentID);
        foreach ($dbSubjects as $subject) {
            if (!array_key_exists($subject->id, $subjects)) {
                $subjects[$subject->id] = $subject->name;
            }
        }

        echo json_encode(array(
            'identifier' => time() . 'U' . $this->session->userdata('id'),
            'student' => array(
                'fullname' => trim($student->first_name) . ' ' . trim($student->last_name),
                'hasSubjects' => (count($subjects) > 0 ? true : false),
                'subjects' => $subjects
            )
        ));
    }

}
