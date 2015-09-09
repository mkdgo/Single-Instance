<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Imports extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('admin_model');
        $this->load->model('user_model');

        if ($this->session->userdata('admin_logged') != true) {
            redirect(base_url() . 'admin/login');
        }
    }

    function index() {
        $this->_paste_admin(false, 'admin/imports');
    }

    public function import_users() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $autocreate = $this->input->post('autocreate', true);
            $file = $this->input->post('file', true);

            require_once(APPPATH . 'libraries/phpexcel/PHPExcel.php');
            require_once(APPPATH . 'libraries/phpexcel/PHPExcel/IOFactory.php');

            $filePath = './uploads_excel/' . $file;

            $objPHPExcel = PHPExcel_IOFactory::load($filePath);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestColumn = $objWorksheet->getHighestColumn();
            $highestRow = $objWorksheet->getHighestRow();

            $this->load->model('subjects_model');
            $subjects = $this->subjects_model->get_subjects();

            $columnMappings = array();
            for ($i = 'A'; $i <= $highestColumn; $i++) {
                $val = trim($objWorksheet->getCell($i . '1')->getValue());
                $columnMappings[$i] = $this->_mapColumn(strtolower($val), $subjects);
            }

//            $users = array();
            $classes = array();
            $subjectYears = array();
            $teachers = array();
            $output = array();
            for ($i = 2; $i <= $highestRow; $i++) {
                $user = array('classes' => array());
                for ($j = 'A'; $j <= $highestColumn; $j++) {
                    if ($columnMappings[$j]['mapped']) {
                        if ($columnMappings[$j]['type'] === 'profile') {
                            $user[$columnMappings[$j]['field']] = trim($objWorksheet->getCell($j . $i)->getCalculatedValue());
                        } else if ($columnMappings[$j]['type'] === 'subject') {
                            $classNames = explode(',', trim($objWorksheet->getCell($j . $i)->getCalculatedValue()));
                            foreach ($classNames as $v) {
                                $className = trim($v);
                                if ($className !== '') {
                                    $subject = $columnMappings[$j]['subject'];
                                    $user['classes'][] = array(
                                        'subject_id' => $subject->id,
                                        'subject_name' => $subject->name,
                                        'class_name' => $className,
                                        'class_year' => $this->_getDigits($className),
                                        'class_group_name' => $this->_getLetters($className),
                                    );
                                }
                            }
                        }
                    }
                }

                foreach ($user['classes'] as &$class) {
                    $class['class_year'] = $user['student_year'];
                }

                $status = 'Row ' . $i . ': ';
                if ($user['user_type'] != 'teacher' && $user['user_type'] != 'student') {
                    $status .= '<span class="text-red">Not imported as it contains invalid user type. Allowed values are "teacher" and "student".</span>';
                    $output[] = $status;
                    continue;
                }
                // create/update user record
                $userID = $this->admin_model->getUserIDByEmail($user['email']);
                if ($userID > 0) {
                    // update user record
                    $this->admin_model->updateUserRecord($userID, $user);
                    $status .= ucfirst($user['user_type']) . ' ' . $user['first_name'] . ' ' . $user['last_name'] . ' <span class="text-ediface-golden">updated</span>.';
                } else {
                    // create user record
                    $userID = $this->admin_model->createUserRecord($user);
                    $status .= ucfirst($user['user_type']) . ' ' . $user['first_name'] . ' ' . $user['last_name'] . ' <span class="text-ediface-green">created</span>.';
                }

                // create record in table "user_onelogins"
                $this->admin_model->createUserOneLoginRecord($userID, $user['email'], $this->user_model->generatePassword(8));

                // create/update classes (STUDENTS ONLY)
                if ($user['user_type'] == 'student') {
                    foreach ($user['classes'] as $class) {
                        if ($autocreate) {
                            if (!array_key_exists($class['subject_id'] . '-' . $class['class_year'], $subjectYears)) {
                                $subjectYearID = $this->admin_model->getSubjectYearID($class['subject_id'], $class['class_year']);
                                if ($subjectYearID === 0) {
                                    $subjectYearID = $this->admin_model->createSubjectYearRecord($class['subject_id'], $class['class_year']);
                                }

                                $subjectYears[$class['subject_id'] . '-' . $class['class_year']] = $subjectYearID;
                            }
                        }

                        if (array_key_exists($class['subject_name'] . '-' . $class['class_name'], $classes)) {
                            $classID = $classes[$class['subject_name'] . '-' . $class['class_name']];
                        } else {
//                            $classID = $this->admin_model->getClassID($class['subject_id'], $class['class_year'], $class['class_group_name']);
                            $classID = $this->admin_model->getClassID($class['subject_id'], $class['class_year'], $class['class_name']);
                        }

                        if ($classID === 0 && $autocreate) {
                            $classID = $this->admin_model->createClassRecord($class);
                        }

                        if ($classID > 0) {
                            $classes[$class['subject_name'] . '-' . $class['class_name']] = $classID;
                            $this->admin_model->addUserToClass($user['user_type'], $userID, $classID);
                            $status .= ' The ' . $user['user_type'] . ' was added to ' . $class['subject_name'] . ' class ' . $class['class_name'] . '.';
                        }
                    }
                } else if ($user['user_type'] == 'teacher') {
                    $user['user_id'] = $userID;
                    $teachers[] = $user;
                }

                $output[] = $status;
            }

            foreach ($teachers as $teacher) {
                $status = '';
                foreach ($teacher['classes'] as $class) {
                    if (array_key_exists($class['subject_name'] . '-' . $class['class_name'], $classes)) {
                        $classID = $classes[$class['subject_name'] . '-' . $class['class_name']];
                    } else {
                        $classID = $this->admin_model->getClassID($class['subject_id'], 0, $class['class_name']);
                    }

                    if ($classID > 0) {
                        $classes[$class['subject_name'] . '-' . $class['class_name']] = $classID;
                        $this->admin_model->addUserToClass('teacher', $teacher['user_id'], $classID);
                        $status .= 'Teacher ' . $teacher['first_name'] . ' ' . $teacher['last_name'] . ' (' . $teacher['email'] . ') was added to ' . $class['subject_name'] . ' class ' . $class['class_name'] . '. ';
//                    } else {
//                        $status .= 'Teacher NOT ADDED' . $teacher['first_name'] . ' ' . $teacher['last_name'] . ' (' . $classID . ')  ' . $class['class_name'] . '. ';
                    }
                }
//if( $status == '' ){ $stts = var_dump( $teacher ); }
//                $output[] = $stts;
                $output[] = $status;
            }

            $this->indexStudentsInElastic();
            
            echo json_encode(array(
                'status' => true,
                'log' => $output
            ));
        } else {
            echo 'You shall not pass!';
        }
    }

    private function _getDigits($str) {
        preg_match_all('/\d+/', $str, $matches);
        return implode('', $matches[0]);
    }

    private function _getLetters($str) {
        preg_match_all('/[a-zA-Z]/', $str, $matches);
        return implode('', $matches[0]);
    }

    private function _mapColumn($val, $subjects) {
        $map = array(
            'mapped' => false
        );

        if ($val === 'type') {
            $map['mapped'] = true;
            $map['type'] = 'profile';
            $map['field'] = 'user_type';

            return $map;
        }

        if ($val === 'email' || $val === 'emailaddress' || $val === 'email address') {
            $map['mapped'] = true;
            $map['type'] = 'profile';
            $map['field'] = 'email';

            return $map;
        }

        if ($val === 'password') {
            $map['mapped'] = true;
            $map['type'] = 'profile';
            $map['field'] = 'password';

            return $map;
        }

        if ($val === 'first' || $val === 'firstname' || $val === 'first name') {
            $map['mapped'] = true;
            $map['type'] = 'profile';
            $map['field'] = 'first_name';

            return $map;
        }

        if ($val === 'last' || $val === 'lastname' || $val === 'last name') {
            $map['mapped'] = true;
            $map['type'] = 'profile';
            $map['field'] = 'last_name';

            return $map;
        }

        if ($val === 'year') {
            $map['mapped'] = true;
            $map['type'] = 'profile';
            $map['field'] = 'student_year';

            return $map;
        }

        foreach ($subjects as $subject) {
            if (strtolower(trim($subject->name)) === $val) {
                $map['mapped'] = true;
                $map['type'] = 'subject';
                $map['subject'] = $subject;

                return $map;
            }
        }

        return $map;
    }

    public function test_excel() {
        $this->output->enable_profiler(TRUE);
        require_once(APPPATH . 'libraries/phpexcel/PHPExcel.php');
        require_once(APPPATH . 'libraries/phpexcel/PHPExcel/IOFactory.php');
        $file_name = './uploads_excel/' . $_GET['file'];

        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();

        //Email/Password/First/Last/Year
        if ($objWorksheet->getCell('A1')->getValue() != 'Email' ||
                $objWorksheet->getCell('B1')->getValue() != 'Password' ||
                $objWorksheet->getCell('C1')->getValue() != 'First' ||
                $objWorksheet->getCell('D1')->getValue() != 'Last' ||
                $objWorksheet->getCell('E1')->getValue() != 'Year') {
            $resp['error'] = 'Mismatched Fields: Email/Password/First/Last/Year ';
            echo json_encode($resp);
            exit();
        } else {
            //Get column to letter Z
            for ($i = 'F'; $i < 'Z'; ++$i) {
                if ($objWorksheet->getCell($i . '1')->getValue() != '') {
                    $classes[].=trim($objWorksheet->getCell($i . '1')->getValue());
                    $classes_letter[].=$i;
                }
            }
            echo "Classes";
            echo '<br><pre>';
            print_r($classes);
            echo '<br></pre>';
            echo "Classes Letter";
            echo '<br><pre>';
            print_r($classes_letter);
            echo '<br></pre>';

            $result_check = $this->admin_model->check_object($classes);
            if (!$result_check['result']) {
                $resp['error'] = 'Mismatched subject ' . $result_check['field'];
                $resp['status'] = 'false';
                echo json_encode($resp);
                exit();
            }
        }

        //FIELDS PASSED Continue
        //$subjects = $this->admin_model->get_all_subjects(); --it retutrn all subjects //Math, English, LAtin etc.
        //map subjects
        //$classes letter examplle F G H
        foreach ($classes_letter as $class_lt) {
            $subject_name = trim($objWorksheet->getCell($class_lt . '1')->getValue());
            for ($i = 2; $i <= $highestRow; $i++) {
                //$subject_name =  Math or English or Music Art etc
                if ($objWorksheet->getCell($class_lt . $i)->getValue() != '') {
                    $r[].= $objWorksheet->getCell($class_lt . $i)->getValue();
                }
            }

            $unique_subj = array_filter(array_unique($r));
            $this->admin_model->map_subjects($subject_name, $unique_subj);
        }
        echo "Unique Subjects";
        echo '<br><pre>';
        print_r($unique_subj);
        echo '<br></pre>';
        die();

        $msg = '';

        for ($i = 2; $i <= $highestRow; $i++) {
            $user_type = strtolower($objWorksheet->getCellByColumnAndRow(0, $i)->getValue());

            if (substr($user_type, 0, 7) == 'teacher') {
                $user['password'] = sha1($objWorksheet->getCellByColumnAndRow(0, $i)->getValue());
                $user['first_name'] = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
                $user['last_name'] = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
                $user['email'] = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue() . '@ediface.org';
                $user['student_year'] = 0;
                $user['user_type'] = 'teacher';
            } else {
                $user['password'] = sha1($objWorksheet->getCellByColumnAndRow(0, $i)->getValue());
                $user['first_name'] = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
                $user['last_name'] = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
                $user['email'] = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue() . '@ediface.org';
                $user['student_year'] = trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue());
                $user['user_type'] = 'student';
            }

            $user_data = $this->admin_model->check_imp_user($user);
            $msg[].=$user_data['msg'];

            //lets return user id and loop again to update student classes table
            if ($user['user_type'] == 'student') {
                foreach ($classes_letter as $class_lt) {
                    $subject_name = $objWorksheet->getCell($class_lt . '1')->getValue();
                    $year_name = $objWorksheet->getCell($class_lt . $i)->getValue();

                    $this->admin_model->check_student_year_group($user_data['user_id'], $year_name, $subject_name);
                }
            }
        }
        $resp['import_results'] = $msg;
        $resp['status'] = 'true';
        echo json_encode($resp);
    }

    public function save_excel() {
        require_once(APPPATH . 'libraries/phpexcel/PHPExcel.php');
        require_once(APPPATH . 'libraries/phpexcel/PHPExcel/IOFactory.php');

        if ($_POST && $_POST['save_excel']) {
            $file_name = './uploads_excel/' . $_POST['file'];

            $objPHPExcel = PHPExcel_IOFactory::load($file_name);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow();

            //Email/Password/First/Last/Email/Year
            if ($objWorksheet->getCell('A1')->getValue() != 'Email' && $objWorksheet->getCell('B1')->getValue() != 'Password' && $objWorksheet->getCell('C1')->getValue() != 'First' && $objWorksheet->getCell('D1')->getValue() != 'Last' && $objWorksheet->getCell('F1')->getValue() != 'Year') {
                $resp['error'] = 'Mismatched Fields: Email/Password/First/Last/Email/Year ';
            } else {
                //Get column to letter Z
                for ($i = 'F'; $i < 'Z'; ++$i) {
                    if ($objWorksheet->getCell($i . '1')->getValue() != '') {
                        $classes[].=trim($objWorksheet->getCell($i . '1')->getValue());
                        $classes_letter[].=$i;
                    }
                }

                $result_check = $this->admin_model->check_object($classes);
                if (!$result_check['result']) {
                    $resp['error'] = 'Mismatched subject ' . $result_check['field'];

                    $resp['status'] = 'false';
                    echo json_encode($resp);
                    exit();
                }
            }

            //FIELDS PASSED Continue
            //$subjects = $this->admin_model->get_all_subjects(); --it retutrn all subjects //Math, English, LAtin etc.
            //map subjects
            //$classes letter examplle F G H
            foreach ($classes_letter as $class_lt) {
                for ($i = 2; $i <= $highestRow; $i++) {
                    //$subject_name =  Math or English or Music Art etc
                    $subject_name = trim($objWorksheet->getCell($class_lt . '1')->getValue());
                    if ($objWorksheet->getCell($class_lt . $i)->getValue() != '') {
                        $r[].= $objWorksheet->getCell($class_lt . $i)->getValue();
                    }
                }

                $unique_subj = array_filter(array_unique($r));
                $this->admin_model->map_subjects($subject_name, $unique_subj);
            }

            $msg = '';
            for ($i = 2; $i <= $highestRow; $i++) {
                $user_type = strtolower($objWorksheet->getCellByColumnAndRow(0, $i)->getValue());
                if (substr($user_type, 0, 7) == 'teacher') {
                    $user['password'] = sha1($objWorksheet->getCellByColumnAndRow(0, $i)->getValue());
                    $user['first_name'] = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
                    $user['last_name'] = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
                    $user['email'] = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue() . '@ediface.org';
                    $user['student_year'] = 0;
                    $user['user_type'] = 'teacher';
                } else {
                    $user['password'] = sha1($objWorksheet->getCellByColumnAndRow(0, $i)->getValue());
                    $user['first_name'] = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
                    $user['last_name'] = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
                    $user['email'] = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue() . '@ediface.org';
                    $user['student_year'] = trim($objWorksheet->getCellByColumnAndRow(4, $i)->getValue());
                    $user['user_type'] = 'student';
                }

                $user_data = $this->admin_model->check_imp_user($user);
                $msg[].=$user_data['msg'];

                //lets return user id and loop again to update student classes table
                if ($user['user_type'] == 'student') {
                    foreach ($classes_letter as $class_lt) {
                        $subject_name = $objWorksheet->getCell($class_lt . '1')->getValue();
                        $year_name = $objWorksheet->getCell($class_lt . $i)->getValue();
                        $this->admin_model->check_student_year_group($user_data['user_id'], $year_name, $subject_name);
                    }
                }
            }
            $resp['import_results'] = $msg;
            $resp['status'] = 'true';
            echo json_encode($resp);
        }
    }

    private function indexStudentsInElastic() {
        $this->load->model('user_model');
        $this->load->model('settings_model');

        $indexName = trim($this->settings_model->getSetting('elastic_index'));
        if ($indexName === '') {
            return;
        }

        $host = $this->settings_model->getSetting('elastic_url');
        $client = new \Elastica\Client(array(
            'host' => $host
        ));

        $index = $client->getIndex($this->settings_model->getSetting('elastic_index'));
        if (!$index->exists()) {
            return;
        }

        $type = $index->getType('students');
        if (!$type->exists()) {
            return;
        }

        $documents = array();
        $students = $this->user_model->get_all_students();
        if (count($students) === 0) {
            return;
        }

        foreach ($students as $student) {
            $documents[] = new \Elastica\Document(intval($student->id), array(
                'id' => intval($student->id),
                'fullname' => trim($student->first_name) . ' ' . trim($student->last_name))
            );
        }

        $type->addDocuments($documents);
        $type->getIndex()->refresh();
    }

}

?>
