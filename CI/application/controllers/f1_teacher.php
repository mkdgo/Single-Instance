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
            if( $this->classes_model->teacher_has_classes( $this->session->userdata('id') ) ) {
                $this->f1_teacher_id = $this->session->userdata('id');
            } else {
                $this->f1_teacher_id = 'all';
            }
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
        if( $data )
        foreach ($data as $key => $value) {
            $subject_classes = str_replace(',',', ', $value->class_name);
            $this->_data[$name][$key]['id'] = $value->id;
            $this->_data[$name][$key]['name'] = $value->title;
            $this->_data[$name][$key]['subject_name'] = $value->subject_name;
            $this->_data[$name][$key]['set_by'] = $value->teacher_name;
            $this->_data[$name][$key]['classes'] = $value->class_id ? $subject_classes : '';
            $_date = '';
            if( $value->deadline_date != '0000-00-00 00:00:00' ) { $_date = date('D jS M Y', strtotime($value->deadline_date)); }
            $this->_data[$name][$key]['date'] = $_date;
//            $this->_data[$name][$key]['date'] = ($value->deadline_date != '0000-00-00 00:00:00') ? date('D jS M Y', strtotime($value->deadline_date)) : '';
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
        $f1_type = $this->input->post('f1_type');
        $this->_data['pending'] = 0;
        $this->_data['assigned'] = 0;
        $this->_data['drafted'] = 0;
        $this->_data['past'] = 0;
        $this->_data['closed'] = 0;
//*
        $pending = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'pending' );
        $drafted = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'draft' );
        $assigned = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'assigned' );
        $past = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'past' );
        $closed = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'closed' );
//*/
/*
        $pending = 0;
        $drafted = 0;
        $assigned = 0;
        $past = 0;
        $closed = 0;
//*/
        $this->process_assignments('pending', $pending);
        $this->process_assignments('assigned', $assigned);
        $this->process_assignments('drafted', $drafted);
        $this->process_assignments('past', $past);
        $this->process_assignments('closed', $closed);
        $this->_data['count_pending'] = 0;
        $this->_data['count_assigned'] = 0;
        $this->_data['count_drafted'] = 0;
        $this->_data['count_past'] = 0;
        $this->_data['count_closed'] = 0;

        $selected_pending = '';
        $selected_assigned = '';
        $selected_draft = '';
        $selected_past = '';
        $selected_closed = '';
        $selected_all = '';
        if( $this->f1_status == 'pending' ) {
            $selected_pending = ' selected="selected"';
            $this->_data['count_pending'] = count($pending);
        } elseif( $this->f1_status == 'assigned' ) {
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
            $this->_data['count_pending'] = count($pending);
            $this->_data['count_assigned'] = count($assigned);
            $this->_data['count_drafted'] = count($drafted);
            $this->_data['count_past'] = count($past);
            $this->_data['count_closed'] = count($closed);
        }
        
        $this->_data['status_select_all'] = '<option value="all" '.$selected_all.'>All</option>';
        $this->_data['status_pending'] = '<option value="pending" '.$selected_pending.'>Pending</option>';
        $this->_data['status_assigned'] = '<option value="assigned" '.$selected_assigned.'>Assigned</option>';
        $this->_data['status_drafted'] = '<option value="draft" '.$selected_draft.'>Drafted</option>';
        $this->_data['status_past'] = '<option value="past" '.$selected_past.'>Past Due Date</option>';
        $this->_data['status_closed'] = '<option value="closed" '.$selected_closed.'>Closed</option>';
//filters
        $teachers = $this->get_default_teachers();
        $subjects = $this->get_default_subjects();
        $years = $this->get_default_years();
        $classes = $this->get_default_classes();

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
if( $_SERVER['HTTP_HOST'] == 'ediface.dev' ) {
//if( $_SERVER['REMOTE_ADDR'] == '78.40.141.164' || $_SERVER['REMOTE_ADDR'] == '95.87.197.231' || $_SERVER['REMOTE_ADDR'] == '95.158.129.162' ) {
//    $this->output->enable_profiler(TRUE);
}
    }

    public function get_default_teachers() {
        $user_id = $this->session->userdata('id');
        $filters = array(
            'teacher_id' => $this->f1_teacher_id,
            'subject_id' => $this->f1_subject_id,
            'year' => $this->f1_year,
            'class_id' => $this->f1_class_id,
            'status' => $this->f1_status
        );
        $teachers = $this->filter_assignment_model->filterTeachers( $filters, 'last_name' );
        foreach( $teachers as $key => $value ) {
            if( $value['teacher_id'] != $this->session->userdata('id') ) {
                $this->_data['teachers'][$key]['id'] = $value['teacher_id'];
                $this->_data['teachers'][$key]['teacher_name'] = $value['teacher_name'];
            }
        }
    }

    public function get_teachers() {
        $filters = array(
            'teacher_id' => $this->f1_teacher_id,
            'subject_id' => $this->f1_subject_id,
            'year' => $this->f1_year,
            'class_id' => $this->f1_class_id,
            'status' => $this->f1_status
        );
        $filterTeachers = $this->filter_assignment_model->filterTeachers( $filters, 'last_name' );
        if( count($filterTeachers) > 0 ) {
            $teacher_selected = ( $this->session->userdata('id') == $this->f1_teacher_id ) ? 'selected="selected"' : '';
            $teacher_options = ' <option value="'.$this->session->userdata('id').'" '.$selected.' >Me ('.$this->session->userdata('last_name').', '.$this->session->userdata('first_name').')</option>';
//            $teacher_options = ' <option value="'.$this->session->userdata('id').'" '.$selected.' >Me ('.$this->session->userdata('first_name').' '.$this->session->userdata('last_name').')</option>';
            $all_selected = ( $this->f1_teacher_id == 'all' ) ? 'selected="selected"' : '';
            $teacher_options .= ' <option value="all" '.$all_selected.' >All</option>';
            foreach( $filterTeachers as $ft ) {
                if( $ft['teacher_id'] != $this->session->userdata('id') ) {
                    $t_selected = ( $ft['teacher_id'] == $this->f1_teacher_id ) ? 'selected="selected"' : '';
                    $teacher_options .= ' <option value="' . $ft['teacher_id'] . '" '.$t_selected.' >' . $ft['teacher_name'] . '</option>';
                }
            }
        } else {
            $teacher_options = ' <option value="all" selected="selected">All</option>';
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
        $arr_classes = array();
        if( count($classes) > 0  ) {
            $all_selected = ( $this->f1_class_id == 'all' ) ? 'selected="selected"' : '';
            $class_options = '<option value="all" '.$all_selected.'>All</option>';
            foreach( $classes as $tfc ) {
                $tmp_class_name = explode(',', $tfc['class_name'] );
                $tmp_class_id = explode(',', $tfc['class_id'] );
                if( count( $tmp_class_name ) ) {
                    for( $i = 0; $i < count($tmp_class_name); $i++ ) {
                        if( !array_key_exists( $tmp_class_name[$i], $arr_classes )) {
                            $arr_classes[$tmp_class_name[$i]] = $tmp_class_id[$i];
                        } else {
                            $arr_classes[$tmp_class_name[$i]] = $arr_classes[$tmp_class_name[$i]].','.$tmp_class_id[$i];
                        }
                    }
                } else {
                    $arr_classes['no classes'] = 0;
                }
            }
            ksort($arr_classes);
            foreach( $arr_classes as $k => $v ) {
                if( $v == 0 ) { $k = "no classes"; }
                $this->_data['classes'][]['id'] = $k;
                $this->_data['classes'][count($this->_data['classes'])-1]['text'] = $k ? $k : 'no classes';
//            $this->_data['classes'][$key]['text'] = $v ? $k : 'no classes';
            }
//echo '<pre>';var_dump( $this->_data['classes'] );die;
        } else {
            $class_options = ' <option value="all" selected="selected">All</option>';
        }

/*
        foreach( $classes as $key => $value ) {
            $this->_data['classes'][$key]['id'] = $value['class_id'];
            $this->_data['classes'][$key]['text'] = $value['class_id'] ? $value['group_name'] : 'no classes';
        }
//*/
    }

    public function get_classes() {
        $filterClasses = $this->filter_assignment_model->filterClasses( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, $this->f1_status );
        $arr_classes = array();
        if( count($filterClasses) > 0  ) {
            $all_selected = ( $this->f1_class_id == 'all' ) ? 'selected="selected"' : '';
            $class_options = '<option value="all" '.$all_selected.'>All</option>';
            foreach( $filterClasses as $tfc ) {
                $tmp_class_name = explode(',', $tfc['class_name'] );
                $tmp_class_id = explode(',', $tfc['class_id'] );
                if( count( $tmp_class_name ) ) {
                    for( $i = 0; $i < count($tmp_class_name); $i++ ) {
                        if( !array_key_exists( $tmp_class_name[$i], $arr_classes )) {
                            $arr_classes[$tmp_class_name[$i]] = $tmp_class_id[$i];
                        } else {
                            $arr_classes[$tmp_class_name[$i]] = $arr_classes[$tmp_class_name[$i]].','.$tmp_class_id[$i];
                        }
                    }
                } else {
                    $arr_classes['no classes'] = 0;
                }
            }
            ksort($arr_classes);
            foreach( $arr_classes as $k => $v ) {
                if( $v == 0 ) { $k = "no classes"; }
                $c_selected = ( $k == $this->f1_class_id ) ? 'selected="selected"' : '';
                $class_options .= ' <option rel="'.$v.'" value="' . $k . '" '.$c_selected.'>'.$k.'</option>';
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
        return $options;
    }

    private function get_assignments($name, $data) {
        $this->_data[$name] = '';
        if( count( $data ) )
        foreach ($data as $key => $value) {
            $class_names = str_replace(',', ', ', $value->class_name);
            $this->_data[$name][$key]['id'] = $value->id;
            $this->_data[$name][$key]['name'] = $value->title;
            $this->_data[$name][$key]['subject_name'] = $value->subject_name.' - '.$class_names;
            $this->_data[$name][$key]['date'] = ($value->deadline_date != '0000-00-00 00:00:00') ? date('D jS M Y', strtotime($value->deadline_date)) : '';
            $this->_data[$name][$key]['set_by'] = $value->teacher_name;
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
        $dat['counters']['count_pending'] = count($result['pending']);
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
                switch( $this->f1_status ) {
                    case 'pending' : $dat['counters']['count_pending'] = count($result['pending']); break;
                    case 'draft' : $dat['counters']['count_drafted'] = count($result['drafted']); break;
                    case 'assigned' : $dat['counters']['count_assigned'] = count($result['assigned']); break;
                    case 'past' : $dat['counters']['count_past'] = count($result['past']); break;
                    case 'closed' : $dat['counters']['count_closed'] = count($result['closed']); break;
                    default : 
                        $dat['counters']['count_pending'] = count($result['pending']); break;
                        $dat['counters']['count_drafted'] = count($result['drafted']); break;
                        $dat['counters']['count_assigned'] = count($result['assigned']); break;
                        $dat['counters']['count_past'] = count($result['past']); break;
                        $dat['counters']['count_closed'] = count($result['closed']); break;
                        break;
                }
                break;
        }

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
            if( $k == 'assigned' ) {
                $mthd = 'edit';
            } elseif( $k == 'past' ) {
                $mthd = 'past';
            } else {
                $mthd = 'index';
            }
            if( isset($result[$k]) && $result[$k] != NULL) {
                for ($i = 0; $i < count($res); $i++) {
                    $dat[$k][$i] = '';
                    $name = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($res[$i]["name"]));
                    if($res[$i]['grade_type'] == 'offline') {$subm = 'N/A'; $mark = 'N/A';} else {$subm = $res[$i]['submitted'] . '/' . $res[$i]['total']; $mark = $res[$i]['marked'] . '/' . $res[$i]['total'];}
                    $dat[$k][$i] .= '<tr><td><a class="info" rel="" onclick="showInfo('. $res[$i]["id"] .')" style="margin-right: 5px; color:#e74c3c; cursor: pointer;" title="Show details" ><i class="fa fa-info-circle"></i></a>
                            <a href="/f2' . $res[$i]["editor"] . '_teacher/'.$mthd.'/' . $res[$i]["id"] . '">' . $res[$i]["name"] . '</a></td>
                            <td>' . $res[$i]["subject_name"] . '</td>
                            <td>'. $res[$i]["set_by"] .'</td>
                            <td><span class="icon calendar grey"></span><span>' . $res[$i]['date'] . '</span></td>
                            <td>' . $subm . '</td>
                            <td>' . $mark . '</td>
                            <td style="text-align: center;" >
                                <a title="Copy Homework for another Class" style="color: #333333;" class="copy" href="javascript: copyAssignment(' . $res[$i]["id"] . ');">
                                    <i style="font-size:24px" class="fa fa-clone"></i>
                                </a>
                            </td>
                            <td style="text-align: center;" class="assignm_' . $res[$i]["id"] . '">
                                <a style="color: #333333;" class="remove_" href="javascript: delRequest(' . $res[$i]["id"] . ',' . "' $name '" . ','. "'count_$k'". ');">
							        <i style="font-size:24px" class="fa fa-trash-o"></i>
                                </a>
                            </td> </tr>';
                }
            } else {
                $dat[$k] = '';
            }
        }
        return $dat;
    }
 
    public function get_t_assignments($f1_status) {
        $result['pending'] = NULL;
        $result['assigned'] = NULL;
        $result['drafted'] = NULL;
        $result['past'] = NULL;
        $result['closed'] = NULL;
        switch( $f1_status ) {
            case 'pending' :
                $pending = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'pending' );
                $result['pending'] = $this->get_assignments('pending', $pending);
                break;
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

            default :
                $pending = $this->filter_assignment_model->get_filtered_assignments( $this->f1_teacher_id, $this->f1_subject_id, $this->f1_year, $this->f1_class_id, 'pending' );
                $result['pending'] = $this->get_assignments('pending', $pending);

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

    public function getDetails() {

        $assignment_id = $this->input->post('assignment_id');
        $assignment = $this->filter_assignment_model->get_assignment($assignment_id);
//echo '<pre>';var_dump( $assignment );die;
        $result = array();
        if( $assignment ) {
            $result['success'] = 1;
            $result['id'] = $assignment[0]['id'];
            $result['assigned_to'] = 'Year '.$assignment[0]['year'].', '.$assignment[0]['subject_name'].' ('.str_replace(',',', ',$assignment[0]['class_name'] ).')';
            $result['title'] = $assignment[0]['title'];
            $result['intro'] = $assignment[0]['intro'];
            $result['grade_type'] = $assignment[0]['grade_type'];
            $result['publish_date'] = date('d/m/Y',strtotime($assignment[0]['publish_date']));
            $result['deadline_date'] = date('D jS M Y', strtotime($assignment[0]['deadline_date']));
//            $result['deadline_date'] = date('d/m/Y H:i',strtotime($assignment[0]['deadline_date']));
            $result['submitted'] = $assignment[0]['submitted'].'/'.$assignment[0]['total'];
            $result['marked'] = $assignment[0]['marked'].'/'.$assignment[0]['total'];
            $result['status'] = $assignment[0]['status'];
            $result['set_by'] = $assignment[0]['teacher_name'];
            $result['resources'] = '';

            $resources = $this->resources_model->get_assignment_resources($assignment[0]['id']);
            if (!empty($resources)) {
//                $this->_data['resource_hidden'] = '';
                foreach ($resources as $k => $v) {
                    $result['resources'] .= '<p style="background: #f5f5ee; padding: 5px; margin-bottom: 5px;">';
                    $result['resources'] .= '<span class="icon '.$v->type.'"></span>';
                    $result['resources'] .= '<span style="margin-left: 10px;">'.$v->name.'</span>';
                    $result['resources'] .= '</p>';
                }
            }
        } else {
            $result['success'] = 0;
        }
/*
array(25) {
    ["id"]=>
    string(3) "455"
    ["base_assignment_id"]=>
    string(1) "0"
    ["teacher_id"]=>
    string(3) "149"
    ["subject_id"]=>
    string(1) "2"
    ["publish_date"]=>
    string(19) "0000-00-00 00:00:00"
    [""]=>
    string(7) "English"
    [""]=>
    string(1) "6"
    ["class_id"]=>
    string(34) "1132,1058,1072,1085,1046,1108,1120"
    [""]=>
    string(17) "Social Leadership"
    [""]=>
    string(1553) "<div><span style="font-family: Calibri, sans-serif; font-size: small;"><span style="font-family: 'Palatino Linotype', serif;">Danny Gill would like Forms in the Middle School and Tutor Groups in the Upper School to look at the issue of <strong>social leadership</strong> (trying to improve society). </span></span></div>
<div> </div>
<div><span style="font-family: Calibri, sans-serif; font-size: small;"><span style="font-family: 'Palatino Linotype', serif;">This was looked at last term when Mr. Toilet (Jack Sim)</span><span style="font-family: 'Palatino Linotype', serif;"> addressed a school assembly, showing how he has tried to improve public health through his own initiatives.</span></span></div>
<div><span style="font-family: Calibri, sans-serif; font-size: small;"><span style="font-family: 'Palatino Linotype', serif;"> </span></span></div>
<div><span style="font-family: Calibri, sans-serif; font-size: small;"><span style="font-family: 'Palatino Linotype', serif;">This can be a collaborative task where you can discuss the ideas with your peers if you so wish, although you must each hand a an individual version to your Formtaker / Tutor on Friday. </span></span></div>
<div> </div>
<div><span style="font-family: Calibri, sans-serif; font-size: small;"><span style="font-family: 'Palatino Linotype', serif;">For boarders, the task will not take the whole session. Part of the session will be a <span id="0.520484599750489" class="highlight">prep</span> briefing - please also bring your reading books.</span></span></div>"
    [""]=>
    string(7) "offline"
    ["grade"]=>
    string(0) ""
    [""]=>
    string(19) "2015-09-11 10:30:00"
    ["submitted_date"]=>
    string(19) "0000-00-00 00:00:00"
    ["feedback"]=>
    string(0) ""
    ["active"]=>
    string(1) "1"
    ["publish"]=>
    string(1) "1"
    ["publish_marks"]=>
    string(1) "0"
    [""]=>
    string(3) "126"
    [""]=>
    string(1) "0"
    [""]=>
    string(1) "0"
    [""]=>
    string(6) "closed"
    ["order_weight"]=>
    string(1) "5"
    [""]=>
    string(10) "Danny Gill"
    [""]=>
    string(31) "6TSa,6TGb,6TR,6TRi,6TSw,6TW,6TG"
  }
//*/
//echo '<pre>';var_dump( $assignment );die;
        echo json_encode($result);
    }

}
