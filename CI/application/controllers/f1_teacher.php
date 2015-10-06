<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class F1_teacher extends MY_Controller {
    var $f1_teacher_id;
    var $f1_subject_id;
    var $f1_year;
    var $f1_class_id;
    var $f1_status;
    var $f1_css_assigned;
    var $f1_css_draft;
    var $f1_css_past;
    var $f1_css_closed;

    function __construct() {
        parent::__construct();
        $this->load->model('assignment_model');
        $this->load->model('filter_assignment_model');
        $this->load->model('user_model');
        $this->load->model('subjects_model');
        $this->load->model('classes_model');
        $this->load->library('breadcrumbs');

        if( $this->session->userdata('f1_teacher_id') ) {
            $this->f1_teacher_id = $this->session->userdata('f1_teacher_id');
        } else {
            $this->f1_teacher_id = $this->session->userdata('id');
            $this->session->set_userdata('f1_teacher_id', $this->session->userdata('id'));
        }
        if( $this->session->userdata('f1_subject_id') ) {
            $this->f1_subject_id = $this->session->userdata('f1_subject_id');
        } else {
            $this->f1_subject_id = 'all';
            $this->session->set_userdata('f1_subject_id', 'all' );
        }
        if( $this->session->userdata('f1_year') ) {
            $this->f1_year = $this->session->userdata('f1_year');
        } else {
            $this->f1_year = 'all';
            $this->session->set_userdata('f1_year', 'all' );
        }
        if( $this->session->userdata('f1_class_id') ) {
            $this->f1_class_id = $this->session->userdata('f1_class_id');
        } else {
            $this->f1_class_id = 'all';
            $this->session->set_userdata('f1_class_id', 'all' );
        }
        if( $this->session->userdata('f1_status') ) {
            $this->f1_status = $this->session->userdata('f1_status');
        } else {
            $this->f1_status = 'all';
            $this->session->set_userdata('f1_status', 'all' );
        }
    }

    private function process_assignments($name, $data) {
        $this->_data[$name] = array();
        $this->_data[$name . '_hidden'] = count($data) == 0 ? 'hidden' : '';
        foreach ($data as $key => $value) {
            $this->_data[$name][$key]['id'] = $value->id;
            $this->_data[$name][$key]['name'] = $value->title;
            $this->_data[$name][$key]['subject_name'] = $value->subject_name;
            $this->_data[$name][$key]['set_by'] = $this->user_model->getUserName( $value->teacher_id );
            $this->_data[$name][$key]['classes'] = $value->class_id ? $this->classes_model->get_groupname_list( $value->class_id ) : '';
            $this->_data[$name][$key]['date'] = ($value->deadline_date != '0000-00-00 00:00:00') ? date('D jS M Y', strtotime($value->deadline_date)) : '';
            $this->_data[$name][$key]['total'] = $value->total;
            $this->_data[$name][$key]['submitted'] = $value->submitted;
            $this->_data[$name][$key]['marked'] = $value->marked;
            $this->_data[$name][$key]['published'] = $value->publish;
            $this->_data[$name][$key]['grade_type'] = $value->grade_type;
            if ($value->publish > 0) {
                $label = 'Published';
                $editor = 'b';
            } else {
                $editor = 'c';
                $label = 'Unpublished';
            }
            $this->_data[$name][$key]['editor'] = $editor;
            $this->_data[$name][$key]['label'] = $label;
        }
    }

    function index() {
//echo '<pre>'; var_dump( $this->session->userdata );die;
//        $class_id = $this->input->post('f1_class_id');
        $type = $this->input->post('f1_type');


        $drafted = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'draft' );
        $assigned = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'assigned' );
        $past = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'past' );
        $closed = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'closed' );

/*
        $classes = '';
        if( !empty( $subjects[0]) ) {
            $classes = '';
            foreach ($subjects as $su) {
                $classes .= $su->classes_ids . ', ';
            }
            $list_classes = rtrim($classes, ', ');
        } else {
            $list_classes = 'false';
        }
        $list_classes = rtrim($list_classes, ', ');
//*/
        $this->process_assignments('assigned', $assigned);
        $this->process_assignments('drafted', $drafted);
        $this->process_assignments('past', $past);
        $this->process_assignments('closed', $closed);
        $this->_data['count_assigned'] = 0;
        $this->_data['count_drafted'] = 0;
        $this->_data['count_past'] = 0;
        $this->_data['count_closed'] = 0;

        $selected_assigned = '';
        $selected_draft = '';
        $selected_past = '';
        $selected_closed = '';
        $selected_all = '';
        if( $this->f1_status == 'assigned' ) {
            $selected_assigned = ' selected="selected"';
            $this->_data['count_assigned'] = count($assigned);
        } elseif( $this->f1_status == 'draft' ) {
            $selected_draft = ' selected="selected"';
            $this->_data['count_drafted'] = count($drafted);
        } elseif( $this->f1_status == 'past' ) {
            $selected_past = ' selected="selected"';
            $this->_data['count_past'] = count($past);
        } elseif( $this->f1_status == 'closed' ) {
            $selected_closed = ' selected="selected"';
            $this->_data['count_closed'] = count($closed);
        } else {
            $selected_all = ' selected="selected"';
            $this->_data['count_assigned'] = count($assigned);
            $this->_data['count_drafted'] = count($drafted);
            $this->_data['count_past'] = count($past);
            $this->_data['count_closed'] = count($closed);
        }
        
        $this->_data['status_select_all'] = '<option value="all" '.$selected_all.'>All</option>';
        $this->_data['status_assigned'] = '<option value="assigned" '.$selected_assigned.'>Assigned</option>';
        $this->_data['status_drafted'] = '<option value="draft" '.$selected_draft.'>Drafted</option>';
        $this->_data['status_past'] = '<option value="past" '.$selected_past.'>Past Due Date</option>';
        $this->_data['status_closed'] = '<option value="closed" '.$selected_closed.'>Closed</option>';
/*
        if( !empty($assigned) || !empty($drafted) || !empty($past) || !empty($closed) ) {
            $this->_data['status_select_all'] = ' <option value="all" selected="selected">All</option>';
        }
        if( !empty($assigned) ) {
            $this->_data['status_assigned'] = '<option value="assigned" >Assigned</option>';
        }
        if( !empty($drafted) ) {
            $this->_data['status_drafted'] = '<option value="draft" >Drafted</option>';
        }
        if( !empty($past) ) {
            $this->_data['status_past'] = '<option value="past" >Past Due Date</option>';
        }
        if( !empty($closed) ) {
            $this->_data['status_closed'] = '<option value="closed" >Closed</option>';
        }
//*/
//filters
        $teachers = $this->get_default_teachers();
        $subjects = $this->get_default_subjects();
        $years = $this->get_default_years();
        $classes = $this->get_default_classes();
//echo '<pre>'; var_dump( $classes );die;
//$subjects = $this->subjects_model->get_teacher_subjects( $this->f1_teacher_id );

        $this->_data['f1_teacher_id'] = $this->f1_teacher_id;
        $this->_data['f1_subject_id'] = $this->f1_subject_id;
        $this->_data['f1_year'] = $this->f1_year;
        $this->_data['f1_class_id'] = $this->f1_class_id;
        $this->_data['f1_status'] = $this->f1_status;
        $this->_data['f1_type'] = $f1_type;

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Homework', '/f1_teacher');
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        $this->_paste_public();
//$this->output->enable_profiler(TRUE);
    }

    public function get_default_teachers() {
        $user_id = $this->session->userdata('id');
        $teachers = $this->filter_assignment_model->filterTeachers( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, $this->f1_status );
        foreach( $teachers as $key => $value ) {
            if( $value['teacher_id'] != $this->session->userdata('id') ) {
                $this->_data['teachers'][$key]['id'] = $value['teacher_id'];
                $this->_data['teachers'][$key]['teacher_name'] = $value['teacher_name'];
            }
        }
    }

    public function get_teachers() {
        $filterTeachers = $this->filter_assignment_model->filterTeachers( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, $this->f1_status );
        if( count($filterTeachers) > 0 ) {
            $teacher_selected = ( $this->session->userdata('id') == $this->f1_teacher_id ) ? 'selected="selected"' : '';
            $teacher_options = ' <option value="'.$this->session->userdata('id').'" '.$selected.' >Me ('.$this->session->userdata('first_name').' '.$this->session->userdata('last_name').')</option>';
            $all_selected = ( $this->f1_teacher_id == 'all' ) ? 'selected="selected"' : '';
            $teacher_options .= ' <option value="all" '.$all_selected.' >All</option>';
            foreach( $filterTeachers as $ft ) {
                if( $ft['teacher_id'] != $this->session->userdata('id') ) {
                    $t_selected = ( $ft['teacher_id'] == $this->f1_teacher_id ) ? 'selected="selected"' : '';
                    $teacher_options .= ' <option value="' . $ft['teacher_id'] . '" '.$t_selected.' >' . $ft['teacher_name'] . '</option>';
                }
            }
        } else {
            $teacher_options = ' <option value="all" selected="selected" >All</option>';
        }
        return $teacher_options;
    }

    public function get_default_subjects() {
        $subjects = $this->filter_assignment_model->filterSubjects( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, $this->f1_status );
        foreach( $subjects as $key => $value ) {
            if( $value['subject_id'] == 0 ) { $value['subject_name'] = "no subject"; }
            $this->_data['subjects'][$key]['id'] = $value['subject_id'];
            $this->_data['subjects'][$key]['name'] = $value['subject_name'];
        }
    }

    public function get_subjects() {
        $filterSubjects = $this->filter_assignment_model->filterSubjects( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, $this->f1_status );
        if( count($filterSubjects) > 0 ) {
            $all_selected = ( $this->f1_subject_id == 'all' ) ? 'selected="selected"' : '';
            $subject_options = '<option value="all" '.$all_selected.' >All</option>';
            foreach( $filterSubjects as $fs ) {
                if( $fs['subject_id'] == 0 ) { $s_name = "no subject"; } else { $s_name = $fs['subject_name']; }
                $s_selected = ( $fs['subject_id'] == $this->f1_subject_id ) ? 'selected="selected"' : '';
                $subject_options .= ' <option value="' . $fs['subject_id'] . '" '.$s_selected.' >' . $s_name . '</option>';
            }
        } else {
            $subject_options = '<option value="all" selected="selected" >All</option>';
        }
        return $subject_options;
    }

    public function get_default_years() {
        $years = $this->filter_assignment_model->filterYears( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, $this->f1_status );
        foreach( $years as $key => $value ) {
            $this->_data['subjects_years'][$key]['id'] = $value['year'];
            $this->_data['subjects_years'][$key]['year'] = $value['year'] ? $value['year'] : 'no year';
        }
//echo '<pre>'; var_dump( $this->_data['subjects_years'] );die;
    }

    public function get_years() {
        $filterYears = $this->filter_assignment_model->filterYears( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, $this->f1_status );
        if( count($filterYears) > 0 ) {
            $all_selected = ( $this->f1_year == 'all' ) ? 'selected="selected"' : '';
            $year_options = ' <option value="all" '.$all_selected.' >All</option>';
            foreach( $filterYears as $fy ) {
                $y_selected = ( $fy['year'] == $this->f1_year ) ? 'selected="selected"' : '';
                $y_name = $fy['year'] ? $fy['year'] : 'no year';
                $year_options .= ' <option value="' . $fy['year'] . '" '.$y_selected.' >' . $y_name . '</option>';
            }
        } else {
            $year_options = ' <option value="all" selected="selected" >All</option>';
        }
        return $year_options;
    }

    public function get_default_classes() {
        $classes = $this->filter_assignment_model->filterClasses( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, $this->f1_status );
        foreach( $classes as $key => $value ) {
            $this->_data['classes'][$key]['id'] = $value['class_id'];
            $this->_data['classes'][$key]['text'] = $value['class_id'] ? $value['group_name'] : 'no classes';
        }
    }

    public function get_classes() {
        $filterClasses = $this->filter_assignment_model->filterClasses( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, $this->f1_status );
        if( count($filterClasses) > 0  ) {
            $all_selected = ( $this->f1_class_id == 'all' ) ? 'selected="selected"' : '';
            $class_options = '<option value="all" '.$all_selected.'>All</option>';
            foreach( $filterClasses as $fc ) {
                if( $fc['class_id'] == '' ) { $fc['group_name'] = "no class"; }
                $c_selected = ( $fc['class_id'] == $this->f1_class_id ) ? 'selected="selected"' : '';
                $class_options .= ' <option value="' . $fc['class_id'] . '" '.$c_selected.'>'.$fc['group_name'].'</option>';
            }
        } else {
            $class_options = ' <option value="all" selected="selected">All</option>';
        }
        return $class_options;
    }

    public function status_select($assignments) {
        $options = '';
        $options.='<option value="all" selected="selected">All</option>';
        $options.='<option value="assigned" >Assigned</option>';
        $options.='<option value="draft" >Drafted</option>';
        $options.='<option value="past" >Past Due Date</option>';
        $options.='<option value="closed" >Closed</option>';
/*
        if( !empty($assignments['assigned']) || !empty($assignments['drafted']) || !empty($assignments['past']) || !empty($assignments['closed']) ) {
            $options.='<option value="all" selected="selected">All</option>';
        }
        if( !empty($assignments['assigned']) ) {
            $options.='<option value="assigned" >Assigned</option>';
        }
        if( !empty($assignments['drafted']) ) {
            $options.='<option value="draft" >Drafted</option>';
        }
        if( !empty($assignments['past']) ) {
            $options.='<option value="past" >Past Due Date</option>';
        }
        if( !empty($assignments['closed']) ) {
            $options.='<option value="closed" >Closed</option>';
        }
//*/
        return $options;
    }

/*
    public function get_default_years() {
        $f1_teacher_id = $this->session->userdata('f1_teacher_id') ? $this->session->userdata('f1_teacher_id') == 'all' ? 'all' : $this->session->userdata('f1_teacher_id') : $this->session->userdata('id');
        $subjects = $this->subjects_model->get_teacher_subjects( $f1_teacher_id );
//echo '<pre>'; var_dump( $f1_teacher_id );die;
//        $subjects = $this->subjects_model->get_teacher_subjects( $this->session->userdata('id') );

        if (!empty($subjects[0])) {
            $classes = '';
            foreach ($subjects as $su) {
                $classes .= $su->classes_ids . ', ';
            }
            $list_classes = rtrim($classes, ', ');
        } else {
            $list_classes = 'false';
        }

        $this->_data['subjects_years'] = '';
//        $classes_years = $this->assignment_model->get_teacher_years_assigment( $this->session->userdata('id'), $list_classes);
        $classes_years = $this->assignment_model->get_teacher_years_assigment( $f1_teacher_id, $list_classes);

        $all_classes_ids = $this->subjects_model->get_all_classes_ids_query($f1_teacher_id);
        if (!empty($classes_years)) {
            $this->_data['years_all'] = $all_classes_ids->cls_id;
            foreach ($classes_years as $k => $cl) {
                $this->_data['subjects_years'][$k]['id'] = $cl->cls_ids;
                $this->_data['subjects_years'][$k]['year'] = $cl->year;
                $this->_data['subjects_years'][$k]['value'] = $cl->year;
                $this->_data['subjects_years'][$k]['class_id'] = $cl->cls_ids;
                $this->_data['subjects_years'][$k]['subject_id'] = $cl->subjects_ids;
            }
        }

        $year = 'all';
        $subject_id = 'all';
        $all_classes_ids = rtrim( $this->subjects_model->get_all_classes_ids_query($f1_teacher_id)->cls_id );

        $this->_data['classes_all'] = $all_classes_ids = rtrim( $all_classes_ids, ',' );

        if( $all_classes_ids ) {
//echo '<pre>'; var_dump( $this->_data['classes_all'] );die;

            $res = $this->db->query("SELECT  * FROM classes where id IN($all_classes_ids) ");

            $r_list = $res->result();
            if (!empty($r_list)) {
                $find = 'all';

                $result = $this->subjects_model->get_classes_lists($find, $subject_id, $all_classes_ids, $year, $f1_teacher_id);
                //$result = $this->subjects_model->get_classes_lists($find,$subject_id,$class_id,$year,$teacher_id);
                foreach ($result as $ke => $cls) {
                    //$dat['class'] .= ' <option class_id="' . $cl->class_id . '" >' .$cl->subject_name.' '.$cl->year.str_replace( $cl->year, '', $cl->group_name ).'</option>';
                    $this->_data['classes'][$ke]['id'] = $cls->class_id;
                    $this->_data['classes'][$ke]['text'] = str_replace($cls->year, '', $cls->group_name);
//                    $this->_data['classes'][$ke]['text'] = $cls->year . str_replace($cls->year, '', $cls->group_name);
//                    $this->_data['classes'][$ke]['text'] = $cls->subject_name . ' ' . $cls->year . str_replace($cls->year, '', $cls->group_name);
                }
            }
        } else {
            $this->_data['classes'][0]['id'] = '';
            $this->_data['classes'][0]['text'] = '';
        }
    }

    public function get_teacher_subjects($teacher_id) {
        $subjects = $this->subjects_model->get_teacher_subjects($teacher_id);
        foreach ($subjects as $key => $value) {
            $this->_data['subjects'][$key]['id'] = $value->id;
            $this->_data['subjects'][$key]['name'] = $value->name;
        }
    }
//*/
    private function get_assignments($name, $data) {
        if( count( $data ) )
        foreach ($data as $key => $value) {
//echo '<pre>';var_dump( $value ); die;
            $this->_data[$name][$key]['id'] = $value->id;
            $this->_data[$name][$key]['name'] = $value->title;
            $this->_data[$name][$key]['subject_name'] = $value->subject_name.' - '.$this->classes_model->get_groupname_list( $value->class_id );;
            $this->_data[$name][$key]['date'] = ($value->deadline_date != '0000-00-00 00:00:00') ? date('D jS M Y', strtotime($value->deadline_date)) : '';
            $this->_data[$name][$key]['set_by'] = $this->user_model->getUserName( $value->teacher_id );
            $this->_data[$name][$key]['total'] = $value->total;
            $this->_data[$name][$key]['submitted'] = $value->submitted;
            $this->_data[$name][$key]['marked'] = $value->marked;
            $this->_data[$name][$key]['published'] = $value->publish;
            $this->_data[$name][$key]['grade_type'] = $value->grade_type;
            if ($value->publish > 0) {
                $label = 'Published';
                $editor = 'b';
            } else {
                $editor = 'c';
                $label = 'Unpublished';
            }
            $this->_data[$name][$key]['editor'] = $editor;
            $this->_data[$name][$key]['label'] = $label;
        }
        return $this->_data[$name];
    }

    public function sortable() {
//$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        $type = $this->input->post('f1_type');

        $this->f1_teacher_id = $this->input->post('f1_teacher_id');
        $this->f1_subject_id = $this->input->post('f1_subject_id');
        $this->f1_year = $this->input->post('f1_year');
        $this->f1_class_id = $this->input->post('f1_class_id');
        $this->f1_status = $this->input->post('f1_status');
        $f1_type = $this->input->post('f1_type');
        $dat = array();
        $this->session->set_userdata( "f1_teacher_id", $this->f1_teacher_id );
        $this->session->set_userdata( "f1_subject_id", $this->f1_subject_id );
        $this->session->set_userdata( "f1_year", $this->f1_year );
        $this->session->set_userdata( "f1_class_id", $this->f1_class_id );
        $this->session->set_userdata( "f1_status", $this->f1_status );
        $this->session->set_userdata( "f1_type", $f1_type );

        $result = $this->get_t_assignments($this->f1_status);
        $dat['counters']['count_drafted'] = count($result['drafted']);
        $dat['counters']['count_assigned'] = count($result['assigned']);
        $dat['counters']['count_past'] = count($result['past']);
        $dat['counters']['count_closed'] = count($result['closed']);
        $dat['assignments'] = $this->list_assignments($result);
        switch( $type ) {
            case 'teacher':
                $dat['subjects'] = $this->get_subjects();
                $dat['years'] = $this->get_years();
                $dat['classes'] = $this->get_classes();
                break;
            case 'subject':
                $dat['teachers'] = $this->get_teachers();
                $dat['years'] = $this->get_years();
                $dat['classes'] = $this->get_classes();
                break;
            case 'year' :
                $dat['teachers'] = $this->get_teachers();
                $dat['subjects'] = $this->get_subjects();
                $dat['classes'] = $this->get_classes();
                break;
            case 'class':
                $dat['teachers'] = $this->get_teachers();
                $dat['subjects'] = $this->get_subjects();
                $dat['years'] = $this->get_years();
                break;
            case 'status':
//                $result = $this->get_t_assignments();
//                $dat['counters']['count_drafted'] = 0;
//                $dat['counters']['count_assigned'] = 0;
//                $dat['counters']['count_past'] = 0;
//                $dat['counters']['count_closed'] = 0;
//                $dat['assignments'] = $this->list_assignments($result);
//*
                switch( $this->f1_status ) {
                    case 'draft' : $dat['counters']['count_drafted'] = count($result['drafted']); break;
                    case 'assigned' : $dat['counters']['count_assigned'] = count($result['assigned']); break;
                    case 'past' : $dat['counters']['count_past'] = count($result['past']); break;
                    case 'closed' : $dat['counters']['count_closed'] = count($result['closed']); break;
                    default : 
                        $dat['counters']['count_drafted'] = count($result['drafted']); break;
                        $dat['counters']['count_assigned'] = count($result['assigned']); break;
                        $dat['counters']['count_past'] = count($result['past']); break;
                        $dat['counters']['count_closed'] = count($result['closed']); break;
                        break;
                }

//                $dat['teachers'] = $this->get_teachers();
//                $dat['subjects'] = $this->get_subjects();
//                $dat['years'] = $this->get_years();
//                $dat['classes'] = $this->get_classes();
//*/
                break;
        }
//*
        $dat['status_select'] = $this->status_select($dat['assignments']);
        if( $dat['assignments'] != '' ) {
            $dat['status_select'] = $this->status_select($dat['assignments']);
        } else {
            $dat['status_select'] .= '<option value="all" selected="selected">All</option>';
        }
//*/
//echo '<pre>';var_dump( $dat );die;
        echo json_encode($dat);
    }

    public function list_assignments($result) {
        $dat = '';
        foreach( $result as $k => $res ) {
            if( $k == 'assigned' || $k == 'past' ) {
                $mthd = 'edit';
            } else {
                $mthd = 'index';
            }
            if ($result[$k] != NULL) {
                for ($i = 0; $i < count($res); $i++) {
                    $name = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($res[$i]["name"]));
                    if($res[$i]['grade_type'] == 'offline') {$subm = 'N/A'; $mark = 'N/A';} else {$subm = $res[$i]['submitted'] . '/' . $res[$i]['total']; $mark = $res[$i]['marked'] . '/' . $res[$i]['total'];}
                    $dat[$k][$i] .= '<tr><td><a href="/f2' . $res[$i]["editor"] . '_teacher/'.$mthd.'/' . $res[$i]["id"] . '">' . $res[$i]["name"] . '</a></td>
                            <td>' . $res[$i]["subject_name"] . '</td>
                            <td>'. $res[$i]["set_by"] .'</td>
                            <td><span class="icon calendar grey"></span><span>' . $res[$i]['date'] . '</span></td>
                            <td>' . $subm . '</td>
                            <td>' . $mark . '</td>
                            <td style="" class="assignm_' . $res[$i]["id"] . '"><a style="outline: none;" class="remove" href="javascript: delRequest(' . $res[$i]["id"] . ',' . "' $name '" . ','. "'count_$k'". ');">
							<span class="glyphicon glyphicon-remove"></span>
                            </a></td> </tr>';
                }
            } else {
                $dat[$k] = '';
            }
        }
        return $dat;
    }

    public function get_t_assignments($f1_status) {
        $result['assigned'] = NULL;
        $result['drafted'] = NULL;
        $result['past'] = NULL;
        $result['closed'] = NULL;
        switch( $f1_status ) {
            case 'assigned' :
                $assigned = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'assigned' );
                $result['assigned'] = $this->get_assignments('assigned', $assigned);
                break;
            case 'draft' :
                $drafted = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'draft' );
                $result['drafted'] = $this->get_assignments('drafted', $drafted);
                break;
            case 'past' :
                $past = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'past' );
                $result['past'] = $this->get_assignments('past', $past);
                break;
            case 'closed' :
                $closed = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'closed' );
                $result['closed'] = $this->get_assignments('closed', $closed);
                break;
            default :
                $drafted = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'draft' );
                $result['drafted'] = $this->get_assignments('drafted', $drafted);
                $assigned = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'assigned' );
                $result['assigned'] = $this->get_assignments('assigned', $assigned);
                $past = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'past' );
                $result['past'] = $this->get_assignments('past', $past);
                $closed = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'closed' );
                $result['closed'] = $this->get_assignments('closed', $closed);
                break;
        }

/*
        if( $teacher_id == 'all' ) {
//            switch( $this->input->post('f1_status') ) {
            switch( $this->session->userdata('f1_status') ) {
                case 'assigned':
                    $dt = array(
                        'base_assignment_id = 0',
                        'publish = 1',
                        'publish_marks = 0',
                        'deadline_date > NOW()'
                    );
                    if( $list_classes ) {
                        $dt[] = 'class_id IN(' . $list_classes . ')';
                        $assigned = $this->assignment_model->get_assignments( $dt );
                    } else {
                        $assigned = $this->assignment_model->get_assignments( $dt );
                    }

                    $result['assigned'] = $this->get_assignments('assigned', $assigned);
                    break;
                case 'draft':
                    $dt = array(
                        'base_assignment_id = 0',
                        'publish = 0',
                    );
                    if( $list_classes ) {
                        $dt[] = 'class_id IN(' . $list_classes . ')';
                    }
                
                    if ($this->input->post('type') == 'subject' && $this->input->post('find') == 'all') {
                        $drafted = $this->assignment_model->get_assignments( $dt );
                    } else if ($this->input->post('type') == 'teacher') {
                        $drafted = $this->assignment_model->get_assignments( $dt );
                    } else {
                        $drafted = $this->assignment_model->get_assignments( $dt );
                    }
                    $result['drafted'] = $this->get_assignments('drafted', $drafted);
                    break;
                case 'past':
                    $dt = array(
                        'base_assignment_id = 0',
                        'grade_type <> "offline"',
                        'publish = 1',
                        'publish_marks = 0',
                        'deadline_date < NOW()'
                    );
                    if( $list_classes ) {
                        $dt[] = 'class_id IN(' . $list_classes . ')';
                    }
                
                    $past = $this->assignment_model->get_assignments( $dt );
                    $result['past'] = $result['past'] = $this->get_assignments('past', $past);
                    break;
                case 'closed':
                    $dtc = array( 'status = "assigned"' );
                    $dt1 = array(
                        'base_assignment_id = 0',
                        'grade_type <> "offline"',
                        'publish = 1',
                        'publish_marks = 1',
                    );
                    $dt2 = array(
                        'base_assignment_id = 0',
                        'grade_type = "offline"',
                        'publish = 1',
                        'deadline_date < NOW()'
                    );
                    if( $list_classes ) {
                        $dtc[] = 'class_id IN(' . $list_classes . ')';
                        $dt1[] = 'class_id IN(' . $list_classes . ')';
                        $dt2[] = 'class_id IN(' . $list_classes . ')';
                    }
//                    $closed = $this->assignment_model->get_assignments( $dt1, $dt2 );
                    $closed = $this->assignment_model->get_assignments( $dtc );
                    $result['closed'] = $this->get_assignments('closed', $closed);
                    break;
                default:
                    $dt = array(
                        'base_assignment_id = 0',
                        'publish = 1',
                        'publish_marks = 0',
                        'deadline_date > NOW()'
                    );
                    if( $list_classes ) {
                        $dt[] = 'class_id IN(' . $list_classes . ')';
                    }

                    $assigned = $this->assignment_model->get_assignments( $dt );
//echo '<pre>';var_dump( $assigned );die;
                    $result['assigned'] = $this->get_assignments('assigned', $assigned);
                    // DRAFT
                    $dtd = array(
                        'base_assignment_id = 0',
                        'publish = 0',
                    );
                    if( $list_classes ) {
                        $dtd[] = 'class_id IN(' . $list_classes . ')';
                    }
                    if ($this->input->post('type') == 'subject' && $this->input->post('find') == 'all') {
                        $drafted = $this->assignment_model->get_assignments($dtd);
                    } else if ($this->input->post('type') == 'teacher') {
                        $drafted = $this->assignment_model->get_assignments($dtd);
                    } else {
                        $drafted = $this->assignment_model->get_assignments($dtd);
//                        $drafted = $this->assignment_model->get_assignments(array('base_assignment_id=0', 'publish=0'));
                    }
                    $result['drafted'] = $this->get_assignments('drafted', $drafted);
                    // PAST
                    $dt = array(
                        'base_assignment_id = 0',
                        'grade_type <> "offline"',
                        'publish = 1',
                        'publish_marks = 0',
                        'deadline_date < NOW()'
                    );
                    if( $list_classes ) {
                        $dt[] = 'class_id IN(' . $list_classes . ')';
                    }
                
                    $past = $this->assignment_model->get_assignments( $dt );
                    $result['past'] = $this->get_assignments('past', $past);
                    // CLOSED
                    $dt1 = array(
                        'base_assignment_id = 0',
                        'grade_type <> "offline"',
                        'publish = 1',
                        'publish_marks = 1',
                    );
                    $dt2 = array(
                        'base_assignment_id = 0',
                        'grade_type = "offline"',
                        'publish = 1',
                        'deadline_date < NOW()'
                    );
                    if( $list_classes ) {
                        $dt1[] = 'class_id IN(' . $list_classes . ')';
                        $dt2[] = 'class_id IN(' . $list_classes . ')';
                    }
                    $closed = $this->assignment_model->get_assignments( $dt1, $dt2 );
                    $result['closed'] = $this->get_assignments('closed', $closed);
                    break;
            }
        } else {
//            switch( $this->input->post('status') ) {
            switch( $this->session->userdata('f1_status') ) {
                case 'assigned':
                    $dt = array(
                        'teacher_id = ' . $teacher_id,
                        'base_assignment_id = 0',
                        'publish = 1',
                        'publish_marks = 0',
                        'deadline_date > NOW()'
                    );
                    if( $list_classes != '' ) {
                        $dt[] = 'class_id IN(' . $list_classes . ')';
                    }
                    $assigned = $this->assignment_model->get_assignments( $dt );

                    $result['assigned'] = $this->get_assignments('assigned', $assigned);
                    break;
                case 'draft':
                    $dt = array(
                        'teacher_id = ' . $teacher_id,
                        'base_assignment_id = 0',
                        'publish = 0',
                    );
                    if( $list_classes != '' ) {
                        $dt[] = 'class_id IN("' . $list_classes . '")';
                    }
                    $drafted = $this->assignment_model->get_assignments( $dt );
                    $result['drafted'] = $this->get_assignments('drafted', $drafted);
                    break;
                case 'past':
                    $dt = array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
                            'grade_type <> "offline"',
                            'publish = 1',
                            'publish_marks = 0',
                            'deadline_date < NOW()'
                    );
                    if( $list_classes != '' ) {
                        $dt[] = 'class_id IN(' . $list_classes . ')';
                    }

                    $past = $this->assignment_model->get_assignments( $dt );
                    $result['past'] = $result['past'] = $this->get_assignments('past', $past);
                    break;
                case 'closed':
                    $dt1 = array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
                            'publish = 1',
                            'publish_marks = 1',
                    );
                    $dt2 = array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
                            'publish = 1',
                            'grade_type = "offline"',
                            'deadline_date < NOW()'
                    );
                    if( $list_classes != '' ) {
                        $dt1[] = 'class_id IN(' . $list_classes . ')';
                        $dt2[] = 'class_id IN(' . $list_classes . ')';
                    }
                    $closed = $this->assignment_model->get_assignments( $dt1, $dt2 );
                    $result['closed'] = $this->get_assignments('closed', $closed);
                    break;
                default:
                    // ASSIGNMENT
                    $dt = array(
                        'teacher_id = ' . $teacher_id,
                        'base_assignment_id = 0',
                        'publish = 1',
                        'publish_marks = 0',
                        'deadline_date > NOW()'
                    );
                    if( $list_classes != '' ) {
                        $dt[] = 'class_id IN(' . $list_classes . ')';
                    }
                    $assigned = $this->assignment_model->get_assignments( $dt );
                    $result['assigned'] = $this->get_assignments('assigned', $assigned);
                    // DRAFT
                    $dt = array(
                        'teacher_id = ' . $teacher_id,
                        'base_assignment_id = 0',
                        'publish = 0',
                    );
                    if( $list_classes != '' ) {
                        $dt[] = 'class_id IN("' . $list_classes . '")';
                    }
                    if ($this->input->post('type') == 'subject' && $this->input->post('find') == 'all') {
                        $drafted = $this->assignment_model->get_assignments( $dt );
                    } else if ($this->input->post('type') == 'teacher') {
                        $drafted = $this->assignment_model->get_assignments( $dt );
                    } else {
                        $drafted = $this->assignment_model->get_assignments( $dt );
                    }
                    $result['drafted'] = $this->get_assignments('drafted', $drafted);
                    // PAST 
                    $dt = array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
                            'grade_type <> "offline"',
                            'publish = 1',
                            'publish_marks = 0',
                            'deadline_date < NOW()'
                    );
                    if( $list_classes != '' ) {
                        $dt[] = 'class_id IN(' . $list_classes . ')';
                    }
                    $past = $this->assignment_model->get_assignments( $dt );
                    $result['past'] = $this->get_assignments('past', $past);
                    // CLOSED
                    $dt1 = array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
                            'publish = 1',
                            'publish_marks = 1',
                    );
                    $dt2 = array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
                            'publish = 1',
                            'grade_type = "offline"',
                            'deadline_date < NOW()'
                    );
                    if( $list_classes != '' ) {
                        $dt1[] = 'class_id IN(' . $list_classes . ')';
                        $dt2[] = 'class_id IN(' . $list_classes . ')';
                    }
                    $closed = $this->assignment_model->get_assignments( $dt1, $dt2 );
                    $result['closed'] = $this->get_assignments('closed', $closed);
                    break;
            }
        }
//*/
        return $result;
    }

    public function deleteAssignment() {
        $id = $this->input->post('id');
        if( $this->session->userdata('user_type') == 'teacher' && $id != '' ) {
            if( $this->assignment_model->delete_assignment($id) ) {
                $json['status'] = 'true';
            } else {
                $json['status'] = 'false';
            }
        }
        $json['id'] = $id;
        echo json_encode($json);
    }

}
