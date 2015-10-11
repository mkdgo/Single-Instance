<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class G1_teacher extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('subjects_model');
        $this->load->model('classes_model');
        $this->load->model('user_model');
        $this->load->library('breadcrumbs');
    }

    public function index() {
        $user_type = strval($this->session->userdata('user_type'));
        if ($user_type !== 'teacher') {
            redirect('b1', 'refresh');
        }

        $this->_data['back'] = '/b2';

        $publishedSubjects = $this->subjects_model->get_subjects('name, id, logo_pic');
        $publishedSubjectsTeacher = $this->subjects_model->get_teacher_assigned_subjects($this->session->userdata('id'));

        if (!empty($publishedSubjectsTeacher[0])) {
            $classes = '';
            foreach ($publishedSubjectsTeacher as $su) {
                $classes .= $su->id . ', ';
            }
            $list_classes = rtrim($classes, ', ');
        } else {
            $list_classes = 'false';
        }

        if (!empty($publishedSubjectsTeacher)) {
            $this->_data['all_subjects'] = $list_classes;
            foreach ($publishedSubjectsTeacher as $key => $val) {
                $this->_data['t_subjects'][$key]['name'] = $val->name;
                $this->_data['t_subjects'][$key]['classes_ids'] = $val->id;
                $this->_data['t_subjects'][$key]['id'] = $val->id;
            }
        }

        $this->_data['data_counter'] = "";
        foreach ($publishedSubjectsTeacher as $key => $val) {
            $this->_data['subjects_list'][$key]['name'] = $val->name;
            $this->_data['subjects_list'][$key]['id'] = $val->id;
            $this->_data['subjects_list'][$key]['logo_pic'] = $val->logo_pic;

            //$subjectYears = $this->subjects_model->get_subject_years($val->id);
            $subjectYears = $this->subjects_model->get_teacher_years_subjects($this->session->userdata('id'),$val->id);

            foreach ($subjectYears as $k => $subjectYear) {
                $this->_data['subjects_list'][$key]['subject_years'][$k]['year'] = $subjectYear->year;
                $this->_data['subjects_list'][$key]['subject_years'][$k]['id'] = $subjectYear->subject_id;
                
                //$classes = $this->classes_model->get_classes_for_subject_year($subjectYear->subject_id, $subjectYear->year);
                $classes = $this->subjects_model->get_teacher_classes_years_subjects($this->session->userdata('id'),$subjectYear->subject_id, $subjectYear->year);

                foreach ($classes as $cl_key => $class) {
                    $this->_data['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['id'] = $class->class_id;
                    $this->_data['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['subject_id'] = $class->subject_id;
                    $this->_data['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['subject_year'] = $class->year;
                    $this->_data['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['group_name'] = $class->group_name;

                    $studentsInClass = $this->user_model->get_students_in_class($class->class_id);
                    foreach ($studentsInClass as $st_key => $st_val) {
                        $this->_data['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['ids'] = $st_val->id;
                        $this->_data['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['subject_ids'] = $val->id;
                        $this->_data['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['year_id'] = $subjectYear->id;
                        $this->_data['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['class_id'] = $class->id;
                        $this->_data['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['first_name'] = $st_val->first_name;
                        $this->_data['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['last_name'] = $st_val->last_name;
                    }
                }
            }
        }

        $teachers = $this->get_teachers();
        $this->get_subjects($this->session->userdata('id'));
        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Students', '/g1_teacher');
        //$this->breadcrumbs->push('Subjects', '/g1_teacher');

        $this->_data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->_paste_public();
    }

    public function get_teachers() {
        $user_id = $this->session->userdata('id');
        $teachers = $this->user_model->get_teachers($user_id, 'last_name');
        foreach ($teachers as $key => $value) {
            $this->_data['teachers'][$key]['id'] = $value->id;
//            $this->_data['teachers'][$key]['teacher_name'] = $value->first_name.' '.$value->last_name;
            $this->_data['teachers'][$key]['teacher_name'] = $value->last_name.', '.$value->first_name;
        }
    }

    public function get_subjects($id) {
        $subjects = $this->subjects_model->get_teacher_subjects($id);

        if (!empty($subjects[0])) {
            $classes = '';
            foreach ($subjects as $su) {
                $classes .= $su->classes_ids . ', ';
            }
            $list_classes = rtrim($classes, ', ');
        } else {
            $list_classes = 'false';
        }

        $this->_data['subjects_0_value'] = 'all';
        $this->_data['subjects0_classes_ids'] = $list_classes;

        foreach ($subjects as $key => $value) {
            $this->_data['subjects'][$key]['id'] = $value->id;
            $this->_data['subjects'][$key]['name'] = $value->name;
            $this->_data['subjects'][$key]['classes_ids'] = $value->classes_ids;
        }
    }

    public function sortable() {
        $type = $this->input->post('type');
        $teacher_id = $this->input->post('teacher_id');

        $dat = '';
        switch ($type) {
            case 'teacher':
                if ($this->input->post('teacher_id') == 'all') {

                    $Subjects = $this->subjects_model->get_subjects('*');
                    $all = true;
                } else {
                    $Subjects = $this->subjects_model->get_teacher_assigned_subjects($teacher_id);
                    $all=false;
                }

                foreach ($Subjects as $key => $val) {
                    $dat['subjects_list'][$key]['name'] = $val->name;
                    $dat['subjects_list'][$key]['id'] = $val->id;
                    $dat['subjects_list'][$key]['logo_pic'] = $val->logo_pic;

                    //$subjectYears = $this->subjects_model->get_subject_years($val->id);
                    $subjectYears = $this->subjects_model->get_teacher_years_subjects($teacher_id,$val->id, $all);
        
                    foreach ($subjectYears as $k => $subjectYear) {
                        $dat['subjects_list'][$key]['subject_years'][$k]['year'] = $subjectYear->year;
                        $dat['subjects_list'][$key]['subject_years'][$k]['id'] = $subjectYear->subject_id;
                        
                        $classes = $this->subjects_model->get_teacher_classes_years_subjects($teacher_id,$subjectYear->subject_id, $subjectYear->year, $all);
        
                        foreach ($classes as $cl_key => $class) {
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['id'] = $class->id;
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['subject_id'] = $class->subject_id;
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['subject_year'] = $class->year;
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['group_name'] = $class->group_name;
                            
                            $studentsInClass = $this->user_model->get_students_in_class($class->class_id);
                            
                            foreach ($studentsInClass as $st_key => $st_val) {
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['ids'] = $st_val->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['subject_ids'] = $val->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['year_id'] = $subjectYear->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['class_id'] = $class->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['first_name'] = $st_val->first_name;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['last_name'] = $st_val->last_name;    
                            }
                        }
                    }
                }

                if (!empty($Subjects[0])) {
                    $classes = '';
                    foreach ($Subjects as $su) {
                        $classes .= $su->id . ', ';
                    }
                    $list_classes = rtrim($classes, ', ');
                } else {
                    $list_classes = 'false';
                }

                $dat['subjects'] = '';
                if (!empty($Subjects)) {
                    $dat['subjects'] .= ' <option value="all" subject_ids="' . $list_classes . '" >All</option>';
                    foreach ($Subjects as $sub) {
                        $dat['subjects'] .= ' <option value="' . $sub->id . '" subject_ids="' . $sub->id . '">' . $sub->name . '</option>';
                    }
                }

                $dat['years'] = '';
                $dat['class'] = '';

                break;
            case 'subject':
                $Subjects = $this->subjects_model->get_teacher_filtered_subjects_by_subj($this->input->post('teacher_id'), $this->input->post('subject_ids'));
                foreach ($Subjects as $key => $val) {
                    $dat['subjects_list'][$key]['name'] = $val->name;
                    $dat['subjects_list'][$key]['id'] = $val->id;
                    $dat['subjects_list'][$key]['logo_pic'] = $val->logo_pic;

                    $subjectYears = $this->subjects_model->get_subject_years($val->id);
                    foreach ($subjectYears as $k => $subjectYear) {
                        $dat['subjects_list'][$key]['subject_years'][$k]['year'] = $subjectYear->year;
                        $dat['subjects_list'][$key]['subject_years'][$k]['id'] = $subjectYear->id;

                        $classes = $this->classes_model->get_classes_for_subject_year($subjectYear->subject_id, $subjectYear->year);
                        foreach ($classes as $cl_key => $class) {
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['id'] = $class['id'];
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['subject_id'] = $class['subject_id'];
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['subject_year'] = $class['year'];
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['group_name'] = $class['group_name'];

                            $studentsInClass = $this->user_model->get_students_in_class($class['id']);
                            foreach ($studentsInClass as $st_key => $st_val) {
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['ids'] = $st_val->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['subject_ids'] = $val->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['year_id'] = $subjectYear->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['class_id'] = $class['id'];
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['first_name'] = $st_val->first_name;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['last_name'] = $st_val->last_name;
                            }
                        }
                    }
                }

                $subjectYears = $this->subjects_model->get_distinct_subject_years($this->input->post('subject_ids'));
                if (!empty($subjectYears)) {
                    if (!empty($subjectYears[0])) {
                        $classes = '';
                        foreach ($subjectYears as $su) {
                            $classes .= $su->id . ', ';
                        }
                        $list_classes = rtrim($classes, ', ');
                    } else {
                        $list_classes = 'false';
                    }
                    $dat['years'] .= ' <option classes_id="' . $list_classes . '" subject_id="' . $this->input->post('subject_ids') . '" value="all">All</option>';
                    foreach ($subjectYears as $cl) {
                        $dat['years'] .= ' <option classes_id="' . $cl->id . '" subject_id="' . $this->input->post('subject_ids') . '" value="' . $cl->year . '">' . $cl->year . '</option>';
                    }
                }

                $dat['class'] = '';
                $dat['class'] .= ' <option class_id="all" value="all">All</option>';

                break;
            case 'year':
                $Subjects = $this->subjects_model->get_teacher_filtered_subjects_by_subj_and_year($this->input->post('teacher_id'), $this->input->post('subject_id'), $this->input->post('classes_id'));
                foreach ($Subjects as $key => $val) {
                    $dat['subjects_list'][$key]['name'] = $val->name;
                    $dat['subjects_list'][$key]['id'] = $val->id;
                    $dat['subjects_list'][$key]['logo_pic'] = $val->logo_pic;

                    $subjectYears = $this->subjects_model->get_subject_filtered_years($this->input->post('subject_id'), $this->input->post('classes_id'));
                    foreach ($subjectYears as $k => $subjectYear) {
                        $dat['subjects_list'][$key]['subject_years'][$k]['year'] = $subjectYear->year;
                        $dat['subjects_list'][$key]['subject_years'][$k]['id'] = $subjectYear->id;

                        $classes = $this->classes_model->get_classes_for_subject_year($subjectYear->subject_id, $this->input->post('find'));
                        foreach ($classes as $cl_key => $class) {
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['id'] = $class['id'];
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['subject_id'] = $class['subject_id'];
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['subject_year'] = $class['year'];
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['group_name'] = $class['group_name'];

                            $studentsInClass = $this->user_model->get_students_in_class($class['id']);
                            foreach ($studentsInClass as $st_key => $st_val) {
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['ids'] = $st_val->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['subject_ids'] = $val->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['year_id'] = $subjectYear->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['class_id'] = $class['id'];
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['first_name'] = $st_val->first_name;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['last_name'] = $st_val->last_name;
                            }
                        }
                    }
                }
                $classes = $this->classes_model->get_years_filter($this->input->post('teacher_id'), $this->input->post('subject_id'), $this->input->post('find'));

                $dat['class'] = '';

                if (!empty($classes)) {
                    $classes_ls = '';
                    foreach ($classes as $su) {
                        $classes_ls .= $su->id . ', ';
                    }
                    $list_classes = rtrim($classes_ls, ', ');
                } else {
                    $list_classes = 'false';
                }

                $disabled = $this->input->post('find') == "all" ? 'disabled="disabled"' : '';
                $dat['class'] .= ' <option classes_id="' . $list_classes . '" year="all" value="all" ' . $disabled . '>All</option>';

                foreach ($classes as $cl) {
                    $dat['class'] .= ' <option classes_id="' . $cl->id . '" year="' . $cl->year . '">' . $cl->group_name . '</option>';
                }

                break;
            case 'class':
                $Subjects = $this->subjects_model->get_teacher_filtered_subjects_by_subj_and_year_and_class($this->input->post('teacher_id'), $this->input->post('subject_id'), $this->input->post('classes_id'));
                foreach ($Subjects as $key => $val) {
                    $dat['subjects_list'][$key]['name'] = $val->name;
                    $dat['subjects_list'][$key]['id'] = $val->id;
                    $dat['subjects_list'][$key]['logo_pic'] = $val->logo_pic;

                    $subjectYears = $this->subjects_model->get_subject_filtered_years($this->input->post('subject_id'), $this->input->post('classes_id'));

                    if ($this->input->post('year') == 'all') {
                        $subjectYears = array($subjectYears[0]);
                    }

                    foreach ($subjectYears as $k => $subjectYear) {
                        $dat['subjects_list'][$key]['subject_years'][$k]['year'] = $subjectYear->year;
                        $dat['subjects_list'][$key]['subject_years'][$k]['id'] = $subjectYear->id;

                        $classes = $this->classes_model->get_classes_for_subject_year_class($subjectYear->subject_id, $this->input->post('classes_id'), $this->input->post('year'));
                        foreach ($classes as $cl_key => $class) {
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['id'] = $class['id'];
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['subject_id'] = $class['subject_id'];
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['subject_year'] = $class['year'];
                            $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['group_name'] = $class['group_name'];

                            $studentsInClass = $this->user_model->get_students_in_class($class['id']);
                            foreach ($studentsInClass as $st_key => $st_val) {
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['ids'] = $st_val->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['subject_ids'] = $val->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['year_id'] = $subjectYear->id;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['class_id'] = $class['id'];
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['first_name'] = $st_val->first_name;
                                $dat['subjects_list'][$key]['subject_years'][$k]['classes'][$cl_key]['students'][$st_key]['last_name'] = $st_val->last_name;
                            }
                        }
                    }
                }

                break;
        }

        echo json_encode($dat);
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
                'group_name' => str_replace($class['year'], '', $class['group_name'])
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
        $this->_data['class_name'] = $studentClass['year'] . str_replace($year_id, '', $studentClass['group_name']);
        $this->_data['class_grade'] = $this->_ordinal($year) . ' Grade';
        $this->_data['class_subject'] = $subject->name;
        $this->_data['students'] = $studentsInClass;

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Students', '/g1_teacher');
        $this->breadcrumbs->push('Subjects', '/g1_teacher/subjects');
        $this->breadcrumbs->push($subject->name, '/g1_teacher/subjects/' . $subject->id);
        $this->breadcrumbs->push($this->_ordinal($year) . ' grade', '/g1_teacher/years/' . $subject_id . '/' . $year_id);
        $this->breadcrumbs->push('Class ' . $studentClass['year'] . str_replace($studentClass['year'], '', $studentClass['group_name']), '/g1_teacher/studentclass/' . $subject_id . '/' . $year_id . '/' . $class_id);

        $this->_data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->_paste_public('g1_teacher_studentclass');
    }


    public function student($student_id = '', $work_id = '', $work_item_id = '') {
        $res = $this->user_model->get_student_classes_profile($student_id);
        $subject_id = $res->subj_id;
        $year_id=$res->years_ids;
        $class_id = $res->cls_id;

        $this->load->model('classes_model');
        $studentClass = $this->classes_model->get_single_class_by_subject_and_year($subject_id, $res->year, $class_id);

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

        $this->_data['g1_t_s_subject_id'] = $subject_id;
        $this->_data['g1_t_s_year_id'] = $year_id;
        $this->_data['g1_t_s_class_id'] = $class_id;
        $this->_data['g1_t_s_student_id'] = $student_id;
        $this->_data['g1_t_work_id'] = intval($work_id);
        $this->_data['g1_t_work_item_id'] = intval($work_item_id);
        
        $studentClasses = $this->user_model->get_student_classes($student_id);
        $this->load->model('assignment_model');
        $this->load->model('work_model');
        $this->_data['classes'] = array();
        $cnt = 0;
        foreach ($studentClasses as $std) {
            $cnt++;
            $extraCSSClass = '';
            if ($cnt == 1) {
                $extraCSSClass = 'in';
            }

            $teachers = array();
            $classTeachers = $this->classes_model->get_class_teachers($std->id);
            foreach ($classTeachers as $teacher) {
                $teachers[] = strtoupper(substr($teacher->first_name, 0, 1)) . '. ' . $teacher->last_name;
            }

            $this->_data['classes'][] = array(
                'offset' => $cnt,
                'class_name' => $std->subject_name,
                'subject_id' => $std->subject_id,
                'group_name' => $std->group_name,
                'logo_pic'=> is_file('uploads/subject_icons/'.$std->logo_pic)?' <img src="'.base_url().'uploads/subject_icons/'.$std->logo_pic.'"  style="position: absolute;left: 15px; width: 40px;height: 40px;top:12px;"/> ':'',
                'teachers' => implode(', ', $teachers),
                'class_id' => $std->id,
                'css_class' => $extraCSSClass,
                'assignments' => $this->assignment_model->get_assignments_student($student_id, array(
                    'A.active >= 0',
//                    'A.publish = 0',
                    'A.class_id = ' . $std->id
                )),
                'count_assignments' => count($this->assignment_model->get_assignments_student($student_id, array(
                            'A.active >= 0',
//                            'A.publish = 0',
                            'A.class_id = ' . $std->id
                ))),
                'total_work_count' => count($this->assignment_model->get_assignments_student($student_id, array(
                            'A.active >= 0',
//                            'A.publish = 0',
                            'A.class_id = ' . $std->id
                ))) + count($this->getWorksWithItems($student_id, $this->classes_model->get_subject_id($std->id))),
                'works' => $this->getWorksWithItems($student_id, $this->classes_model->get_subject_id($std->id))
            );
        }
        
        $this->_data['first_name'] = $student->first_name;
        $this->_data['last_name'] = $student->last_name;

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Students', '/g1_teacher');
        $this->breadcrumbs->push($student->first_name . ' ' . $student->last_name,'gdfg');

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

    private function getWorksWithItems($student_id, $class_id) {
        $works = array_filter($this->work_model->get_non_assignment_student_works_by_subject($student_id, $class_id), function($v) {
            return intval($v->assignment_id) === 0;
        });

        foreach ($works as $work) {
            $workItems = $this->work_model->get_work_items_by_work_id($work->id);
            $work->items = $workItems;
        }

        return $works;
    }

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
