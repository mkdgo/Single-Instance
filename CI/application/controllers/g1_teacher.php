<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class G1_teacher extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('subjects_model');
        $this->load->library('breadcrumbs');
    }

    public function index() {
        $user_type = strval($this->session->userdata('user_type'));
        if ($user_type !== 'teacher') {
            redirect('b1', 'refresh');
        }

        $this->_data['back'] = '/b2';

        $publishedSubjects = $this->subjects_model->get_subjects('name, id, logo_pic');

        $loopIdx = 1;
        foreach ($publishedSubjects as $key => $val) {
            $this->_data['subjects'][$key]['name'] = $val->name;
            $this->_data['subjects'][$key]['id'] = $val->id;
            $this->_data['subjects'][$key]['logo_pic'] = $val->logo_pic;

            if ($loopIdx == 6) {
                $this->_data['subjects'][$key]['plus_class'] = 'sixth_subject';
            } elseif ($loopIdx > 5) {
                $this->_data['subjects'][$key]['plus_class'] = 'subject_second_row';
            } else {
                $this->_data['subjects'][$key]['plus_class'] = '';
            }
            $loopIdx++;
        }

        //Home > Students > Subjects
        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Students', '/g1_teacher');
        $this->breadcrumbs->push('Subjects', '/g1_teacher');

        $this->_data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->_paste_public();
    }

    public function subjects($subject_id = '') {
        $this->_validateSubject($subject_id);

        $this->_data['subject_id'] = $subject_id;
        $subject = $this->subjects_model->get_single_subject($subject_id);
        $this->_validateSubjectExistance($subject);

        $this->_data['subject_title'] = $subject->name;
        $this->_data['subject_intro'] = $subject->name;
        $this->_data['subject_objectives'] = $subject->name;

        $subjectYears = $this->subjects_model->get_subject_years($subject_id);

        $loopIdx = 1;
        foreach ($subjectYears as $subjectYear) {
            $this->_data['years'][$subjectYear->id]['year'] = $subjectYear->year;
            $this->_data['years'][$subjectYear->id]['id'] = $subjectYear->id;

            if ($loopIdx == 6) {
                $this->_data['years'][$subjectYear->id]['plus_class'] = 'sixth_subject';
            } elseif ($loopIdx > 5) {
                $this->_data['years'][$subjectYear->id]['plus_class'] = 'subject_second_row';
            } else {
                $this->_data['years'][$subjectYear->id]['plus_class'] = '';
            }
            $loopIdx++;
        }

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Students', '/g1_teacher');
        $this->breadcrumbs->push('Subjects', '/g1_teacher/subjects');
        $this->breadcrumbs->push($subject->name, '/g1_teacher' . $subject->id);

        $this->_data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->_paste_public('g1_teacher_subjects');
    }

    public function years($subject_id = '', $year_id = '') {
        $this->_validateYear($subject_id, $year_id);

        $subject = $this->subjects_model->get_single_subject($subject_id);
        $this->_validateSubjectExistance($subject);

        $subjectYear = $this->subjects_model->get_year($year_id);
        $this->_validateYearExistance($subject_id, $subjectYear);

        $year = $subjectYear->year;

        $this->load->model('classes_model');

        $this->_data['subject_id'] = $subject_id;
        $this->_data['year_id'] = $year_id;

        $classes = $this->classes_model->get_classes_for_subject_year($subject_id, $year);
        foreach ($classes as $class) {
            $this->_data['classes'][] = array(
                'id' => $class['id'],
                'subject_id' => $class['subject_id'],
                'year' => $class['year'],
                'group_name' => str_replace( $class['year'], '', $class['group_name'] )
            );
        }

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Students', '/g1_teacher');
        $this->breadcrumbs->push('Subjects', '/g1_teacher/subjects');
        $this->breadcrumbs->push($subject->name, '/g1_teacher/subjects/' . $subject->id);
        $this->breadcrumbs->push($this->_ordinal($year) . ' grade', '/g1_teacher' . $subject->id);

        $this->_data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->_paste_public('g1_teacher_years');
    }

    public function studentclass($subject_id = '', $year_id = '', $class_id = '') {
        $this->_validateClass($subject_id, $year_id, $class_id);

        $subject = $this->subjects_model->get_single_subject($subject_id);
        $this->_validateSubjectExistance($subject);

        $subjectYear = $this->subjects_model->get_year($year_id);
        $this->_validateYearExistance($subject_id, $subjectYear);

        $year = $subjectYear->year;

        $this->load->model('classes_model');
        $studentClass = $this->classes_model->get_single_class_by_subject_and_year($subject_id, $year, $class_id);
        $this->_validateClassExistance($subject_id, $subjectYear, $studentClass);

        $this->load->model('user_model');
        $studentsInClass = $this->user_model->get_students_in_class($class_id);

        $this->_data['subject_id'] = $subject_id;
        $this->_data['year_id'] = $year_id;
        $this->_data['class_id'] = $class_id;
        $this->_data['class_name'] = $studentClass['year'] . str_replace( $year_id, '', $studentClass['group_name'] );
        $this->_data['class_grade'] = $this->_ordinal($year) . ' Grade';
        $this->_data['class_subject'] = $subject->name;
        $this->_data['students'] = $studentsInClass;

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Students', '/g1_teacher');
        $this->breadcrumbs->push('Subjects', '/g1_teacher/subjects');
        $this->breadcrumbs->push($subject->name, '/g1_teacher/subjects/' . $subject->id);
        $this->breadcrumbs->push($this->_ordinal($year) . ' grade', '/g1_teacher/years/' . $subject_id . '/' . $year_id);
        $this->breadcrumbs->push('Class ' . $studentClass['year'] . str_replace( $studentClass['year'], '', $studentClass['group_name'] ), '/g1_teacher/studentclass/' . $subject_id . '/' . $year_id . '/' . $class_id);

        $this->_data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->_paste_public('g1_teacher_studentclass');
    }

    public function student($subject_id = '', $year_id = '', $class_id = '', $student_id = '') {
        $this->_validateClass($subject_id, $year_id, $class_id);

        $subject = $this->subjects_model->get_single_subject($subject_id);
        $this->_validateSubjectExistance($subject);

        $subjectYear = $this->subjects_model->get_year($year_id);
        $this->_validateYearExistance($subject_id, $subjectYear);

        $year = $subjectYear->year;

        $this->load->model('classes_model');
        $studentClass = $this->classes_model->get_single_class_by_subject_and_year($subject_id, $year, $class_id);
        $this->_validateClassExistance($subject_id, $subjectYear, $studentClass);

        $this->load->model('classes_model');
        $exists = $this->classes_model->get_student_in_class($student_id, $class_id);
        if (!$exists) {
            redirect('g1_teacher/studentclass/' . $subject_id . '/' . $year_id . '/' . $class_id, 'refresh');
        }

        $this->load->model('user_model');
        $student = $this->user_model->get_user($student_id);
        if (!$student) {
            redirect('g1_teacher/studentclass/' . $subject_id . '/' . $year_id . '/' . $class_id, 'refresh');
        }

        $studentClasses = $this->user_model->get_student_classes($student_id);
        $this->load->model('assignment_model');

        $this->_data['classes'] = array();
        $cnt = 0;
        foreach ($studentClasses as $std) {
            $cnt++;
            $extraCSSClass = '';
            if ($cnt == 1) {
                $extraCSSClass = 'in';
            }
            $this->_data['classes'][] = array(
                'class_name' => $std->subject_name,
                'class_id' => $std->id,
                'css_class' => $extraCSSClass,
                'assignments' => $this->assignment_model->get_assignments_student($student_id, array(
                    'A.active = 1',
                    'A.publish = 0',
                    'A.class_id = ' . $std->id
                ))
            );
        }

        $this->_data['first_name'] = $student->first_name;
        $this->_data['last_name'] = $student->last_name;

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Students', '/g1_teacher');
        $this->breadcrumbs->push('Subjects', '/g1_teacher/subjects');
        $this->breadcrumbs->push($subject->name, '/g1_teacher/subjects/' . $subject->id);
        $this->breadcrumbs->push($this->_ordinal($year) . ' grade', '/g1_teacher/years/' . $subject_id . '/' . $year_id);
        $this->breadcrumbs->push('Class ' . $studentClass['year'] . str_replace( $studentClass['year'], '', $studentClass['group_name'] ), '/g1_teacher/studentclass/' . $subject_id . '/' . $year_id . '/' . $class_id);
        $this->breadcrumbs->push($student->first_name . ' ' . $student->last_name, '/g1_teacher/student/' . $subject_id . '/' . $year_id . '/' . $class_id . '/' . $student_id);

        $this->_data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->_paste_public('g1_teacher_student');
    }

// <editor-fold defaultstate="collapsed" desc="validators">
    private function _validateSubject($subject_id) {
        if (strval(($subject_id) === '')) {
            redirect('g1_teacher', 'refresh');
        }
    }

    private function _validateSubjectExistance($subject) {
        if (!$subject) {
            redirect('g1_teacher', 'refresh');
        }
    }

    private function _validateYear($subject_id, $year_id) {
        $this->_validateSubject($subject_id);

        if (strval(($year_id) === '')) {
            redirect('g1_teacher/subjects/' . $subject_id, 'refresh');
        }
    }

    private function _validateYearExistance($subject_id, $year) {
        if (!$year) {
            redirect('g1_teacher/subjects/' . $subject_id, 'refresh');
        }
    }

    private function _validateClass($subject_id, $year_id, $class_id) {
        $this->_validateSubject($subject_id);
        $this->_validateYear($subject_id, $year_id);

        if (strval(($class_id) === '')) {
            redirect('g1_teacher/years/' . $subject_id . '/' . $year_id, 'refresh');
        }
    }

    private function _validateClassExistance($subject_id, $year_id, $studentClass) {
        if (!$studentClass) {
            redirect('g1_teacher/years/' . $subject_id . '/' . $year_id, 'refresh');
        }
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="helpers">
    private function _ordinal($number) {
        $ones = $number % 10;
        $tens = floor($number / 10) % 10;
        if ($tens == 1) {
            $suffix = "th";
        } else {
            switch ($ones) {
                case 1 : $suffix = "st";
                    break;
                case 2 : $suffix = "nd";
                    break;
                case 3 : $suffix = "rd";
                    break;
                default : $suffix = "th";
            }
        }
        return $number . $suffix;
    }

// </editor-fold>
}
