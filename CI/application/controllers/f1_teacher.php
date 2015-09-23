<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class F1_teacher extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('assignment_model');
        $this->load->model('user_model');
        $this->load->model('subjects_model');
        $this->load->model('classes_model');
        $this->load->library('breadcrumbs');
    }

    private function process_assignments($name, $data) {
        $this->_data[$name] = array();
        $this->_data[$name . '_hidden'] = count($data) == 0 ? 'hidden' : '';
        foreach ($data as $key => $value) {
//echo $name; var_dump( $value );
            $this->_data[$name][$key]['id'] = $value->id;
            $this->_data[$name][$key]['name'] = $value->title;
            $this->_data[$name][$key]['subject_name'] = $value->subject_name;
            $this->_data[$name][$key]['classes'] = $this->classes_model->get_groupname_list( $value->class_id );
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
        $subjects = $this->subjects_model->get_teacher_subjects($this->session->userdata('id'));
        $classes = '';
        if (!empty($subjects[0])) {
            $classes = '';
            foreach ($subjects as $su) {
                $classes .= $su->classes_ids . ', ';
//                $groups[$su->classes_ids] = $su->group_name;
//echo '<pre>'; var_dump( $su );die;
            }
            $list_classes = rtrim($classes, ', ');
        } else {
            $list_classes = 'false';
        }
//echo '<pre>'; var_dump( $groups );die;

        $assigned = $this->assignment_model->get_assignments(array(
            'teacher_id = ' . $this->user_id,
            'base_assignment_id = 0',
//            'class_id IN (' . $list_classes . ')',
            'publish = 1',
            'publish_marks = 0',
            '(marked < total OR total = 0)',
            'deadline_date > NOW()'
            )
        );
        $this->process_assignments('assigned', $assigned);
        $this->_data['count_assigned'] = count($assigned);
//echo '<pre>'; var_dump( $assigned );die;

        $drafted = $this->assignment_model->get_assignments(array(
            'teacher_id = ' . $this->user_id,
            'base_assignment_id = 0',
            'publish = 0'
            )
        );
        $this->process_assignments('drafted', $drafted);
        $this->_data['count_drafted'] = count($drafted);

        $past = $this->assignment_model->get_assignments(array(
            'teacher_id = ' . $this->user_id,
            'base_assignment_id = 0',
//            'class_id IN (' . $list_classes . ')',
            'grade_type <> "offline"',
            'publish = 1',
            'publish_marks = 0',
            '(marked < total OR total = 0)',
            'deadline_date < NOW()'
            )
        );
        $this->process_assignments('past', $past);
        $this->_data['count_past'] = count($past);

        $closed = $this->assignment_model->get_assignments(array(
            'teacher_id = ' . $this->user_id,
            'base_assignment_id = 0',
//            'class_id IN (' . $list_classes . ')',
            'publish = 1',
            'publish_marks = 1'
//            '(marked = total)'
            ), array(
            'teacher_id = ' . $this->user_id,
            'base_assignment_id = 0',
            'publish = 1',
//            'class_id IN (' . $list_classes . ')',
            'grade_type = "offline"',
            'deadline_date < NOW()'
            )
        );
        $this->process_assignments('closed', $closed);
        $this->_data['count_closed'] = count($closed);

        if( !empty($assigned) || !empty($drafted) || !empty($past) || !empty($closed) ) {
            $this->_data['status_select_all'] = ' <option value="all" selected="selected">All</option>';
        }
        if( !empty($assigned) ) {
            $this->_data['status_assigned'] = '<option value="assigned" >Assigned</option>';
        }
        if( !empty($drafted) ) {
            $this->_data['status_drafted'] = ' <option value="draft" >Drafted</option>';
        }
        if( !empty($past) ) {
            $this->_data['status_past'] = '  <option value="past" >Past Due Date</option>';
        }
        if( !empty($closed) ) {
            $this->_data['status_closed'] = '<option value="closed" >Closed</option>';
        }
//filters

        $subjects = $this->subjects_model->get_teacher_subjects($this->session->userdata('id'));
        $this->_data['subjects_0_value'] = 'all';
        $this->_data['subjects0_classes_ids'] = $list_classes;
        foreach( $subjects as $key => $value ) {
            $this->_data['subjects'][$key]['id'] = $value->id;
            $this->_data['subjects'][$key]['name'] = $value->name;
            $this->_data['subjects'][$key]['classes_ids'] = $value->classes_ids;
        }
//echo '<pre>'; var_dump( $subjects );die;

        $teachers = $this->get_teachers();
//        $this->get_subjects($this->session->userdata('id'));
        $this->get_default_years();
        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Homework', '/f1_teacher');
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        $this->_paste_public();
    }

    public function get_teachers() {
        $user_id = $this->session->userdata('id');
        $teachers = $this->user_model->get_teachers($user_id);
        foreach( $teachers as $key => $value ) {
            $this->_data['teachers'][$key]['id'] = $value->id;
            $this->_data['teachers'][$key]['first_name'] = $value->first_name;
            $this->_data['teachers'][$key]['last_name'] = $value->last_name;
        }
    }

    public function get_subjects($id) {
        $subjects = $this->subjects_model->get_teacher_subjects($id);
        if( !empty($subjects[0]) ) {
            $classes = '';
            foreach( $subjects as $su ) {
                $classes .= $su->classes_ids . ', ';
            }
            $list_classes = rtrim($classes, ', ');
        } else {
            $list_classes = 'false';
        }
        $this->_data['subjects_0_value'] = 'all';
        $this->_data['subjects0_classes_ids'] = $list_classes;
        foreach( $subjects as $key => $value ) {
            $this->_data['subjects'][$key]['id'] = $value->id;
            $this->_data['subjects'][$key]['name'] = $value->name;
            $this->_data['subjects'][$key]['classes_ids'] = $value->classes_ids;
        }
    }

    public function get_default_years() {
        $subjects = $this->subjects_model->get_teacher_subjects($this->session->userdata('id'));

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
        $classes_years = $this->assignment_model->get_teacher_years_assigment($this->session->userdata('id'), $list_classes);

        $all_classes_ids = $this->subjects_model->get_all_classes_ids_query($this->session->userdata('id'));
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
        $all_classes_ids = $this->subjects_model->get_all_classes_ids_query($this->session->userdata('id'));

        $this->_data['classes_all'] = $all_classes_ids->cls_id;

        if ($all_classes_ids->cls_id) {

            $res = $this->db->query("SELECT  * FROM classes where id IN($all_classes_ids->cls_id) ");

            $r_list = $res->result();
            if (!empty($r_list)) {
                $find = 'all';

                $result = $this->subjects_model->get_classes_lists($find, $subject_id, $all_classes_ids->cls_id, $year, $this->session->userdata('id'));
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

    private function get_assignments($name, $data) {
        foreach ($data as $key => $value) {
//echo '<pre>';var_dump( $value ); die;
            $this->_data[$name][$key]['id'] = $value->id;
            $this->_data[$name][$key]['name'] = $value->title;
            $this->_data[$name][$key]['subject_name'] = $value->subject_name.' - '.$this->classes_model->get_groupname_list( $value->class_id );;
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
        return $this->_data[$name];
    }

    public function sortable() {
        $type = $this->input->post('type');
        $dat = '';
        switch ($type) {
            case 'teacher':
                $teacher_id = $this->input->post('teacher_id');
                $subjects = $this->subjects_model->get_teacher_subjects($teacher_id);
                if( !empty($subjects[0]) ) {
                    $classes = array();
                    foreach ($subjects as $su) {
$tmp_classes = explode( ',', $su->classes_ids );
foreach( $tmp_classes as $tmp_class )
//echo '<pre>';var_dump( $tmp_class );//die;
                        if( !in_array( $tmp = trim($tmp_class), $classes ) ) {
                            $classes[] = $tmp;
                        }
                    }
                    $list_classes = implode( ',', $classes );
                } else {
                    $list_classes = 'false';
                }

                $result = $this->get_t_assignments($teacher_id, $list_classes);
                $dat['counters']['count_drafted'] = count($result['drafted']);
                $dat['counters']['count_assigned'] = count($result['assigned']);
                $dat['counters']['count_past'] = count($result['past']);
                $dat['counters']['count_closed'] = count($result['closed']);
                $dat['assignments'] = $this->list_assignments($result);
                $dat['status_select'] = $this->status_select($dat['assignments']);
                $dat['subjects'] = '';
                if (!empty($subjects)) {
                    $dat['subjects'] .= ' <option value="all" classes_ids="' . $list_classes . '" >All</option>';
                    foreach ($subjects as $sub) {
                        $dat['subjects'] .= ' <option value="' . $sub->id . '" classes_ids="' . $sub->classes_ids . '">' . $sub->name . '</option>';
                    }
                } else {
                    $dat['subjects'] .= ' <option value="all" >All</option>';
                }

                $classes_years = $this->assignment_model->get_teacher_years_assigment($teacher_id, $list_classes);
                $all_classes_ids = $this->subjects_model->get_all_classes_ids_query($teacher_id);
                if( !empty($classes_years) ) {
                    $dat['years'] .= ' <option class_id="' . $all_classes_ids->cls_id . '" value="all">All</option>';
                    foreach ($classes_years as $cl) {
                        $dat['years'] .= ' <option class_id="' . $cl->cls_ids . '" subject_id="' . $cl->subjects_ids . '" value="' . $cl->year . '">' . $cl->year . '</option>';
                    }
                } else {
                    $dat['years'] .= ' <option  value="all">All</option>';
                }

                $classes_ids = $list_classes;
                $res = $this->subjects_model->get_classes_list($classes_ids, $teacher_id);
                $dat['class'] = '';
                if( !empty($res) ) {
                    $dat['class'] .= ' <option class_id="' . $classes_ids . '" value="all">All</option>';
                    foreach( $res as $cl ) {
                        $dat['class'] .= ' <option class_id="' . $cl->class_id . '" subject_id="' . $cl->subject_id . '">' . str_replace($cl->year, '', $cl->group_name) . '</option>';
                    }
                } else {
                    $dat['class'] .= ' <option  value="all">All</option>';
                }

                if( $dat['assignments'] != '' ) {
                    $dat['status_select'] = $this->status_select($dat['assignments']);
                } else {
                    $dat['status_select'] .= '';
                }
                break;
            case 'subject':
                $teacher_id = $this->input->post('teacher_id');
                $result = $this->get_t_assignments($teacher_id, $this->input->post('classes_ids'));
                $dat['counters']['count_drafted'] = count($result['drafted']);
                $dat['counters']['count_assigned'] = count($result['assigned']);
                $dat['counters']['count_past'] = count($result['past']);
                $dat['counters']['count_closed'] = count($result['closed']);
                $dat['assignments'] = $this->list_assignments($result);
                $classes_years = $this->assignment_model->get_teacher_years_assigment($teacher_id, $this->input->post('classes_ids'));
                $dat['years'] = '';
                $all_classes_ids = $this->subjects_model->get_all_classes_ids_query($teacher_id);
                if (!empty($classes_years)) {
                    $dat['years'] .= ' <option class_id="' . $all_classes_ids->cls_id . '" value="all">All</option>';
                    foreach ($classes_years as $cl) {
                        $dat['years'] .= ' <option class_id="' . $cl->cls_ids . '" subject_id="' . $cl->subjects_ids . '" value="' . $cl->year . '">' . $cl->year . '</option>';
                    }
                }
                $classes_ids = $this->input->post('classes_ids');
                $res = $this->subjects_model->get_classes_list($classes_ids, $teacher_id);
                $dat['class'] = '';
                if (!empty($res)) {
                    if ($this->input->post('find') == 'all') {
                        $dat['class'] .= ' <option class_id="' . $classes_ids . '" value="all">All</option>';
                        foreach ($res as $cl) {
                            $dat['class'] .= ' <option class_id="' . $cl->class_id . '" subject_id="' . $cl->subject_id . '">' . $cl->group_name . '</option>';
                        }
                    } else {
                        $dat['class'] .= ' <option class_id="' . $classes_ids . '" value="all">All</option>';
                        foreach ($res as $cl) {
                            $dat['class'] .= ' <option class_id="' . $cl->class_id . '" subject_id="' . $cl->subject_id . '">' . $cl->group_name . '</option>';
                        }
                    }
                }

                if ($dat['assignments'] != '') {
                    $dat['status_select'] = $this->status_select($dat['assignments']);
                } else {
                    $dat['status_select'] .= '';
                }

                break;
            case 'year' :
                $teacher_id = $this->input->post('teacher_id');
                $cls_id = rtrim($this->input->post('class_id'), ',');
                $result = $this->get_t_assignments($teacher_id, $cls_id);
                $dat['counters']['count_drafted'] = count($result['drafted']);
                $dat['counters']['count_assigned'] = count($result['assigned']);
                $dat['counters']['count_past'] = count($result['past']);
                $dat['counters']['count_closed'] = count($result['closed']);
                $dat['assignments'] = $this->list_assignments($result);

                $id = $this->input->post('class_id');
                $year = $this->input->post('find');
                $subject_id = $this->input->post('subject_id');
                $class_id = rtrim($this->input->post('class_id'), ',');
                $res = $this->db->query("SELECT  * FROM classes where id IN($id) ");
                $r_list = $res->result();
                if (!empty($r_list)) {
                    $find = $this->input->post('find');
                    $result = $this->subjects_model->get_classes_lists($find, $subject_id, $class_id, $year, $teacher_id);
                    $dat['class'] .= ' <option class_id="' . $classes_ids . '" value="all">All</option>';
                    foreach ($result as $cl) {
                        $dat['class'] .= ' <option class_id="' . $cl->class_id . '" >' . $cl->group_name . '</option>';
                    }
                }

                if ($dat['assignments'] != '') {
                    $dat['status_select'] = $this->status_select($dat['assignments']);
                } else {
                    $dat['status_select'] .= '';
                }
                break;
            case 'class':
                $teacher_id = $this->input->post('teacher_id');
                $list_classes = $this->input->post('class_id');
                $result = $this->get_t_assignments($teacher_id, $list_classes);
                $dat['counters']['count_drafted'] = count($result['drafted']);
                $dat['counters']['count_assigned'] = count($result['assigned']);
                $dat['counters']['count_past'] = count($result['past']);
                $dat['counters']['count_closed'] = count($result['closed']);
                $dat['assignments'] = $this->list_assignments($result);

                if ($dat['assignments'] != '') {
                    $dat['status_select'] = $this->status_select($dat['assignments']);
                } else {
                    $dat['status_select'] .= '';
                }
                break;
            case 'status':
                $teacher_id = $this->input->post('teacher_id');
                $list_classes = $this->input->post('class_id');
                $result = $this->get_t_assignments($teacher_id, $list_classes);
                $dat['counters']['count_drafted'] = count($result['drafted']);
                $dat['counters']['count_assigned'] = count($result['assigned']);
                $dat['counters']['count_past'] = count($result['past']);
                $dat['counters']['count_closed'] = count($result['closed']);
                $dat['assignments'] = $this->list_assignments($result);
                break;
        }
        echo json_encode($dat);
    }

    public function status_select($assignments) {
        $options = '';
        if (!empty($assignments['assigned']) || !empty($assignments['drafted']) || !empty($assignments['past']) || !empty($assignments['closed'])) {
            $options.=' <option value="all" selected="selected">All</option>';
        }
        if (!empty($assignments['assigned'])) {
            $options.='<option value="assigned" >Assigned</option>';
        }
        if (!empty($assignments['drafted'])) {
            $options.=' <option value="draft" >Drafted</option>';
        }
        if (!empty($assignments['past'])) {
            $options.='  <option value="past" >Past Due Date</option>';
        }
        if (!empty($assignments['closed'])) {
            $options.='<option value="closed" >Closed</option>';
        }
        return $options;
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
                            <td><span class="icon calendar grey"></span><span>' . $res[$i]['date'] . '</span></td>
                            <td>' . $subm . '</td>
                            <td>' . $mark . '</td>
                            <td style="position: relative;" class="assignm_' . $res[$i]["id"] . '"><a style="width:50px;float: left;margin-left: -36px;top:17px;position: absolute;outline: none;" class="remove" href="javascript: delRequest(' . $res[$i]["id"] . ',' . "' $name '" . ','. "'count_$k'". ');">
							<span class="glyphicon glyphicon-remove"></span>
                            </a></td> </tr>';
                }
            } else {
                $dat[$k] = '';
            }
        }
        return $dat;
    }

    public function get_t_assignments($teacher_id, $list_classes) {
        $result['assigned'] = NULL;
        $result['drafted'] = NULL;
        $result['past'] = NULL;
        $result['closed'] = NULL;
        if( $teacher_id == 'all' ) {
            switch( $this->input->post('status') ) {
                case 'assigned':
                    $assigned = $this->assignment_model->get_assignments(
                        array(
                            'base_assignment_id = 0',
//                            'class_id IN(' . $list_classes . ')',
//                            'grade_type <> "offline"',
                            'publish = 1',
                            'publish_marks = 0',
//                            '(marked < total OR total = 0)',
                            'deadline_date > NOW()'
                        )
                    );
                    $result['assigned'] = $this->get_assignments('assigned', $assigned);
                    break;
                case 'draft':
                    if ($this->input->post('type') == 'subject' && $this->input->post('find') == 'all') {
                        $drafted = $this->assignment_model->get_assignments(
                            array(
                                'base_assignment_id = 0',
                                'publish = 0'
                            )
                        );
                    } else if ($this->input->post('type') == 'teacher') {
                        $drafted = $this->assignment_model->get_assignments(
                            array(
                                'base_assignment_id = 0',
                                'publish = 0'
                            )
                        );
                    } else {
                        $drafted = $this->assignment_model->get_assignments(
                            array(
                                'base_assignment_id = 0',
                                'publish = 0',
//                                'class_id IN(' . $list_classes . ')'
                            )
                        );
                    }
                    $result['drafted'] = $this->get_assignments('drafted', $drafted);
                    break;
                case 'past':
                    $past = $this->assignment_model->get_assignments(
                        array(
                            'base_assignment_id = 0',
//                            'class_id IN(' . $list_classes . ')',
                            'grade_type <> "offline"',
                            'publish = 1',
                            'publish_marks = 0',
//                            '(marked<total OR total=0)',
                            'deadline_date < NOW()'
                        )
                    );
                    $result['past'] = $result['past'] = $this->get_assignments('past', $past);
                    break;
                case 'closed':
                    $closed = $this->assignment_model->get_assignments(
                        array(
                            'base_assignment_id = 0',
//                            'class_id IN(' . $list_classes . ')',
                            'grade_type <> "offline"',
                            'publish = 1',
                            'publish_marks = 1',
//                            '(marked=total)'
                        ), array(
                            'base_assignment_id = 0',
//                            'class_id IN (' . $list_classes . ')',
                            'grade_type = "offline"',
                            'deadline_date < NOW()'
                        )
                    );
                    $result['closed'] = $this->get_assignments('closed', $closed);
                    break;
                default:
                    $assigned = $this->assignment_model->get_assignments(
                        array(
                            'base_assignment_id = 0',
//                            'class_id IN(' . $list_classes . ')',
                            'publish = 1',
                            'publish_marks = 0',
//                            '(marked<total OR total=0)',
                            'deadline_date > NOW()'
                        )
                    );
                    $result['assigned'] = $this->get_assignments('assigned', $assigned);
                    if ($this->input->post('type') == 'subject' && $this->input->post('find') == 'all') {
                        $drafted = $this->assignment_model->get_assignments(
                            array(
                                'base_assignment_id = 0', 'publish = 0'
                            )
                        );
                    } else if ($this->input->post('type') == 'teacher') {
                        $drafted = $this->assignment_model->get_assignments(
                            array(
                                'base_assignment_id = 0',
                                'publish = 0'
                            )
                        );
                    } else {
                        $drafted = $this->assignment_model->get_assignments(
                            array(
                                'base_assignment_id = 0',
                                'publish = 0',
//                                'class_id IN(' . $list_classes . ')'
                            )
                        );
                        $drafted = $this->assignment_model->get_assignments(array('base_assignment_id=0', 'publish=0'));
                    }
                    $result['drafted'] = $this->get_assignments('drafted', $drafted);
                    $past = $this->assignment_model->get_assignments(
                        array(
                            'base_assignment_id = 0',
                            'grade_type <> "offline"',
//                            'class_id IN(' . $list_classes . ')',
                            'publish = 1',
                            'publish_marks = 0',
//                            '(marked<total OR total=0)',
                            'deadline_date < NOW()'
                        )
                    );
                    $result['past'] = $this->get_assignments('past', $past);
                    $closed = $this->assignment_model->get_assignments(
                        array(
                            'base_assignment_id = 0',
                            'grade_type <> "offline"',
//                            'class_id IN(' . $list_classes . ')',
                            'publish = 1',
                            'publish_marks = 1',
//                            '(marked=total)'
                        ), array(
                            'base_assignment_id = 0',
                            'publish = 1',
                //            'class_id IN (' . $list_classes . ')',
                            'grade_type = "offline"',
                            'deadline_date < NOW()'
                        )
                    );
                    $result['closed'] = $this->get_assignments('closed', $closed);
                    break;
            }
        } else {
            switch ($this->input->post('status')) {
                case 'assigned':
                    $assigned = $this->assignment_model->get_assignments(
                        array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
//                            'class_id IN(' . $list_classes . ')',
                            'publish = 1',
                            'publish_marks = 0',
//                            '(marked<total OR total=0)',
                            'deadline_date > NOW()'
                        )
                    );
                    $result['assigned'] = $this->get_assignments('assigned', $assigned);
                    break;
                case 'draft':
                    $drafted = $this->assignment_model->get_assignments(
                        array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
                            'publish = 0'
                        )
                    );
                    $result['drafted'] = $this->get_assignments('drafted', $drafted);
                    break;
                case 'past':
                    $past = $this->assignment_model->get_assignments(
                        array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
//                            'class_id IN(' . $list_classes . ')',
                            'grade_type <> "offline"',
                            'publish = 1',
                            'publish_marks = 0',
//                            '(marked<total OR total=0)',
                            'deadline_date < NOW()'
                        )
                    );
                    $result['past'] = $result['past'] = $this->get_assignments('past', $past);
                    break;
                case 'closed':
                    $closed = $this->assignment_model->get_assignments(
                        array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
//                            'class_id IN(' . $list_classes . ')',
                            'publish = 1',
                            'publish_marks = 1',
//                            '(marked = total)'
                        ), array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
                            'publish = 1',
                //            'class_id IN (' . $list_classes . ')',
                            'grade_type = "offline"',
                            'deadline_date < NOW()'
                        )
                    );
                    $result['closed'] = $this->get_assignments('closed', $closed);
                    break;
                default:
                    $assigned = $this->assignment_model->get_assignments(
                        array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
//                            'class_id IN(' . $list_classes . ')',
                            'publish = 1',
                            'publish_marks = 0',
//                            '(marked<total OR total=0)',
                            'deadline_date > NOW()'
                        )
                    );
                    $result['assigned'] = $this->get_assignments('assigned', $assigned);
                    if ($this->input->post('type') == 'subject' && $this->input->post('find') == 'all') {
                        $drafted = $this->assignment_model->get_assignments(array('teacher_id = ' . $teacher_id, 'base_assignment_id = 0', 'publish = 0'));
                    } else if ($this->input->post('type') == 'teacher') {
                        $drafted = $this->assignment_model->get_assignments(array('teacher_id = ' . $teacher_id, 'base_assignment_id = 0', 'publish = 0'));
                    } else {
                        $drafted = $this->assignment_model->get_assignments(
                            array(
                                'teacher_id = ' . $teacher_id,
                                'base_assignment_id = 0',
                                'publish = 0',
//                                'class_id IN(' . $list_classes . ')'
                            )
                        );
                    }
                    $result['drafted'] = $this->get_assignments('drafted', $drafted);
                    $past = $this->assignment_model->get_assignments(
                        array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
//                            'class_id IN(' . $list_classes . ')',
                            'publish = 1',
                            'publish_marks = 0',
//                            '(marked<total OR total=0)',
                            'deadline_date < NOW()'
                        )
                    );
                    $result['past'] = $this->get_assignments('past', $past);
                    $closed = $this->assignment_model->get_assignments(
                        array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
//                            'class_id IN(' . $list_classes . ')',
                            'publish = 1',
                            'publish_marks = 1',
//                            '(marked=total)'
                        ), array(
                            'teacher_id = ' . $teacher_id,
                            'base_assignment_id = 0',
                            'publish = 1',
                //            'class_id IN (' . $list_classes . ')',
                            'grade_type = "offline"',
                            'deadline_date < NOW()'
                        )
                    );
                    $result['closed'] = $this->get_assignments('closed', $closed);
                    break;
            }
        }
        return $result;
    }

    public function deleteAssignment() {
        $id = $this->input->post('id');
        if ($this->session->userdata('user_type') == 'teacher' && $id != '') {
            if ($this->assignment_model->delete_assignment($id)) {
                $json['status'] = 'true';
            } else {
                $json['status'] = 'false';
            }
        }
        $json['id'] = $id;
        echo json_encode($json);
    }

}
