<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class F2c_teacher extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('assignment_model');
        $this->load->model('filter_assignment_model');
        $this->load->model('classes_model');
        $this->load->model('subjects_model');
        $this->load->model('resources_model');
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->load->library('breadcrumbs');

//        array_push( $this->_data['_css'], '/js/slider/style.css');
//        array_push( $this->_data['_css'], '/css/f2c_teacher.css');

    }

    private function arrayUnique($array, $preserveKeys = false)  
    {  
        // Unique Array for return  
        $arrayRewrite = array();  
        // Array with the md5 hashes  
        $arrayHashes = array();  
        foreach($array as $key => $item) {  
            // Serialize the current element and create a md5 hash  
            $hash = md5(serialize($item));  
            // If the md5 didn't come up yet, add the element to  
            // to arrayRewrite, otherwise drop it  
            if (!isset($arrayHashes[$hash])) {  
                // Save the current element hash  
                $arrayHashes[$hash] = $hash;  
                // Add element to the unique Array  
                if ($preserveKeys) {  
                    $arrayRewrite[$key] = $item;  
                } else {  
                    $arrayRewrite[] = $item;  
                }  
            }  
        }  
        return $arrayRewrite;  
    }  

    function index($id = '-1') {
        if( !is_numeric( $id ) ) {
            $id = '-1';
        }
        $this->_data['assignment_id'] = $id;
        $assignment = $this->assignment_model->get_assignment($id);
        $mode = $this->assignment_model->checkRedirect( $assignment, 'draft' );

        $this->_data['mode'] = $mode;
        $this->_data['resources'] = $this->resources_model->get_assignment_resources($id);
        $this->_data['set_by'] = $this->user_model->getUserName( $assignment->teacher_id );

        $tmp_classes = explode( ',', $assignment->class_id );
        $tmp_classes_text = '';
        foreach( $tmp_classes as $tmp ) {
            $cl_name = $this->classes_model->get_class_name($tmp);
            $tmp_classes_text .= $cl_name->group_name . ', ';
        }
        $tmp_classes_text = substr( $tmp_classes_text, 0, -2 );

        $this->_data['assignment_title'] = isset($assignment->title) ? $assignment->title : '';
        $this->_data['assignment_intro'] = isset($assignment->intro) ? $assignment->intro : '';
        $this->_data['assignment_title'] = stripslashes( $this->_data['assignment_title'] );
        $this->_data['assignment_intro'] = stripslashes( $this->_data['assignment_intro'] );
        if (isset($assignment->deadline_date) && $assignment->deadline_date != '0000-00-00 00:00:00') {
            $date_time = strtotime($assignment->deadline_date);
            $date = date('Y-m-d', $date_time);
            $time = date('H:i', $date_time);
            if($date_time <= time())$datepast=1;else $datepast=0;
        } else {
            $datetom = date("Y-m-d");// current date
            $date_time = strtotime(date("Y-m-d", strtotime($datetom)) . " +1 day");
            $date = date('Y-m-d', $date_time);
            $time = '';
            $datepast = '';
        }

        if( isset($assignment->publish_date) && $assignment->publish_date != '0000-00-00 00:00:00' && $assignment->publish_date != '1970-01-01') {
            $pdate_time = strtotime($assignment->publish_date);
            if( $pdate_time < time() ) {
                $pdatetom = date("Y-m-d");// current date
                $pdate_time = strtotime(date("Y-m-d", strtotime($pdatetom)));
                $pdate = date('Y-m-d', $pdate_time);
                $ptime = '';
            } else {
                $pdate = date('Y-m-d', $pdate_time);
                $ptime = date('H:i', $pdate_time);
            }
        } else {
            $pdatetom = date("Y-m-d");// current date
            $pdate_time = strtotime(date("Y-m-d", strtotime($pdatetom)));
            $pdate = date('Y-m-d', $pdate_time);
            $ptime = '';
        }
        $assignment_publish_date_active = '';
        $assignment_publish_date_disabled = 0;
        if( ( time() - strtotime($pdate) ) < 1 ) {
//echo '<pre>';var_dump( time() - strtotime($pdate) );die();
            $assignment_publish_date_active = 'active';
        } else {
            $assignment_publish_date_disabled = 1;
        }
        $this->_data['datepast'] = $datepast;
        $this->_data['assignment_publish_date'] = $pdate;
        $this->_data['assignment_date_preview'] = date('d/m/Y',strtotime($pdate));
        $this->_data['assignment_publish_time'] = $ptime;
        $this->_data['assignment_publish_date_active'] = $assignment_publish_date_active;
        $this->_data['assignment_publish_date_disabled'] = $assignment_publish_date_disabled;

        $this->_data['assignment_date'] = $date;
        $this->_data['assignment_date_preview'] = date('d/m/Y',strtotime($date));
        $this->_data['assignment_time'] = $time;

        $this->_data['selected_grade_type_test'] = '';
        $this->_data['selected_grade_type_offline'] = '';
        $this->_data['selected_grade_type_pers'] = '';
        $this->_data['selected_grade_type_mark_out_of_10'] = '';
        $this->_data['selected_grade_type_grade'] = '';
        $this->_data['selected_grade_type_free_text'] = '';
        if( isset($assignment->grade_type) ) {
            switch ($assignment->grade_type) {
                case 'test':
                    $this->_data['selected_grade_type_test'] = 'selected';
                    break;
                case 'offline':
                    $this->_data['selected_grade_type_offline'] = 'selected';
                    break;
                case 'percentage':
                    $this->_data['selected_grade_type_pers'] = 'selected';
                    break;
                case 'mark_out_of_10':
                    $this->_data['selected_grade_type_mark_out_of_10'] = 'selected';
                    break;
                case 'grade':
                    $this->_data['selected_grade_type_grade'] = 'selected';
                    break;
                case 'free_text':
                    $this->_data['selected_grade_type_free_text'] = 'selected';
                    break;
            }
        }
        $this->_data['grade_type'] = $assignment->grade_type;

        $this->_data['label_grade_type_test'] = $this->assignment_model->labelsAssigmnetType('test');
        $this->_data['label_grade_type_offline'] = $this->assignment_model->labelsAssigmnetType('offline');
        $this->_data['label_grade_type_grade'] = $this->assignment_model->labelsAssigmnetType('grade');
        $this->_data['label_grade_type_percentage'] = $this->assignment_model->labelsAssigmnetType('percentage');
        $this->_data['label_grade_type_mark_out_of_10'] = $this->assignment_model->labelsAssigmnetType('mark_out_of_10');
        $this->_data['label_grade_type_free_text'] = $this->assignment_model->labelsAssigmnetType('free_text');

        $this->_data['publish'] = $assignment->publish ? $assignment->publish : 0;
        $this->_data['publishmarks'] = $assignment->publish_marks ? 1 : 0;

        $this->_data['class_id'] = isset($assignment->class_id) ? $assignment->class_id : '';

        $subjects = $this->subjects_model->get_subjects();

        foreach ($subjects as $key => $subject) {
            if (isset($assignment->assigned_to)) {
                if (($key + 1) == $assignment->assigned_to) {
                    $this->_data['subjects'][$key]['sel_selected_subjects'] = set_select('subjects', isset($assignment->assigned_to) ? $assignment->assigned_to : '', TRUE);
                } else {
                    $this->_data['subjects'][$key]['sel_selected_subjects'] = set_select('subjects', isset($assignment->assigned_to) ? $assignment->assigned_to : '');
                }
            } else {
                $this->_data['subjects'][$key]['sel_selected_subjects'] = '';
            }
            $this->_data['subjects'][$key]['subject_id'] = $subject->id;
            $this->_data['subjects'][$key]['subject_name'] = $subject->name;
        }

        $this->_data['resources'] = array();
        $resources = $this->resources_model->get_assignment_resources($id);
        if (!empty($resources)) {
            $this->_data['resource_hidden'] = '';
            foreach ($resources as $k => $v) {
                $this->_data['resources'][$k]['id'] = $v->res_id;
                $this->_data['resources'][$k]['resource_name'] = ( strlen( $v->name ) > 50 ) ? substr( $v->name,0,50 ).'...' : $v->name;
                $this->_data['resources'][$k]['resource_id'] = $v->res_id;
                $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/f2c_teacher/resource/');
                $this->_data['resources'][$k]['type'] = $v->type;
                if( in_array( $v->type, $this->_quiz_resources ) ) {
                    $this->_data['resources'][$k]['icon_type'] = '<span class="glyphicon glyphicon-question-sign" style="font-size: 15px; color: #db4646;"></span>';
                } else {
                    $this->_data['resources'][$k]['icon_type'] = '<span class="icon '.$v->type.'" style="color: #c8c8c8"></span>';
                }
                $this->_data['resources'][$k]['content'] = $v->content;
                $this->_data['resources'][$k]['behavior'] = $v->behavior;
            }
        } else {
            $this->_data['resource_hidden'] = 'hidden';
        }

        $classes_years__ = $this->assignment_model->getYearsAssigment();
        $classes_years = $this->assignment_model->get_teacher_years_assigment($this->user_id);

//        foreach($classes_years as $k=>$CY) {
        foreach( $classes_years__ as $k => $CY ) {
            $classes_year_subjects = $this->assignment_model->getSubjectsAssigment( $CY->year );
            $classes_year_subjects__ = $this->arrayUnique(array_merge( $this->assignment_model->get_teacher_subjects_assigment($this->user_id, $CY->year),$this->assignment_model->getSubjectsAssigment( $CY->year )));

//            foreach($classes_year_subjects as $ck=>$CS) {
            foreach( $classes_year_subjects__ as $ck => $CS ) {
                $classes_year_subject_classes__ = $this->assignment_model->getClassesAssigment( $CS->subject_id, $CY->year );
                $classes_year_subjects__[$ck]->classes = $classes_year_subject_classes__;

//                $classes_year_subject_classes = $this->assignment_model->get_teacher_classes_assigment( $this->user_id, $CS->subject_id, $CY->year );
//                $classes_year_subjects[$ck]->classes = $classes_year_subject_classes;
            }

            $classes_years__[$k]->subjects = $classes_year_subjects__;
//            $classes_years[$k]->subjects = $classes_year_subjects;
        }
        $this->_data['classes_years'] = $classes_years__;
        $this->_data['classes_years_json'] = json_encode($classes_years__);

        $assigned_to_year = $this->assignment_model->get_assigned_year($id);

        $this->_data['assigned_to_year'] = $assigned_to_year['year'];
        $this->_data['assigned_to_subject'] = $assigned_to_year['name'];

        $assignment_categories = $this->assignment_model->get_assignment_categories($id);
        $this->_data['assignment_categories'] = $assignment_categories;
        $this->_data['assignment_categories_json'] = json_encode($assignment_categories);

        $assignment_attributes = $this->assignment_model->get_assignment_attributes($id);
        $this->_data['assignment_attributes'] = $assignment_attributes;
        $this->_data['assignment_attributes_json'] = json_encode($assignment_attributes);
/*
        $student_assignments = $this->assignment_model->get_student_assignments($id);

        $this->_data['student_assignments'] = array();
        $this->_data['has_marks'] = 0;

        foreach ($student_assignments as $key => $value) {            
            $this->_data['student_assignments'][$key]['id'] = $value->id;
            $this->_data['student_assignments'][$key]['submitted'] = $value->submitted;
            $this->_data['student_assignments'][$key]['submitted_on_time'] = $value->submitted_on_time;                        

            //SA
            $assignmet_mark = $this->assignment_model->get_mark_submission($value->id);
            $submission_mark = $assignmet_mark[0]->total_evaluation;

            $marks_avail = 0;
            foreach( $assignment_categories as $ask => $asv ) {
                $marks_avail += (int) $asv->category_marks;
            }

            $student_resources = $this->resources_model->get_assignment_resources($value->id);
            foreach ($student_resources as $k => $v) {
                $mark_data = $this->assignment_model->get_resource_mark($v->res_id);
                if( $mark_data[0] ) {
                    $marks_total = $mark_data[0]->total_evaluation;
                } else {
                    $marks_total = 0;
                }
                $submission_mark += $marks_total;
            }

            if($value->grade=="1")$this->_data['has_marks']="1";

            $this->_data['student_assignments'][$key]['attainment'] = $this->assignment_model->calculateAttainment($submission_mark, $marks_avail, $assignment);

            $this->_data['student_assignments'][$key]['grade'] = $value->grade;
            $this->_data['student_assignments'][$key]['first_name'] = $value->first_name;
            $this->_data['student_assignments'][$key]['last_name'] = $value->last_name;

            $this->_data['student_assignments'][$key]['data_icon'] = $value->submitted_on_time ? 'check' : 'delete';

            $this->_data['student_assignments'][$key]['data_icon_hidden'] = $value->submitted ? '' : 'hidden';
            $this->_data['student_assignments'][$key]['submission_status'] = $value->publish ? '<i class="icon ok f4t">' : '';
        }
//*/
//        $this->_data['student_subbmission_hidden'] = count($student_assignments) > 0 ? '' : 'hidden';
        $assigned_students = $this->assignment_model->get_assigned_students( $list = explode( ',', $assignment->student_id ) );
//echo '<pre>';var_dump( $assigned_students );die;
        $this->_data['keystudents_list'] = '';
        foreach( $assigned_students as $assigned_student ) {
            $this->_data['keystudents_list'] = '<div class="keystudent"><span>'.$assigned_student->first_name.' '.$assigned_student->last_name.'</span><a rel="'.$assigned_student->id.'" class="remove"></a></div>';
        }
        $this->_data['keystudents'] = $assignment->student_id;
        $this->_data['keystudents_a'] = json_encode(explode(', ', ''));

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Homework', '/f1_teacher');
        $this->breadcrumbs->push(isset($assignment->title) ? $this->_data['assignment_title'] : 'New Homework Assignment', '/');

        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        $this->_paste_public();
//$this->output->enable_profiler(TRUE);
    }

    public function save() {
//echo '<pre>';var_dump( $this->input->post() );die;
        $message = Array();
        if($this->input->post('assignment_id') != -1 && $this->input->post('has_marks') == 1 && $this->input->post('server_require_agree') == "0" ) {
            $changed_cat = Array();
            $new_cats = false;
            $del_cats = false;

            $old_categories_data = Array();
            $old_categories_data_ = $this->assignment_model->get_assignment_categories($this->input->post('assignment_id'));
            foreach( $old_categories_data_ as $ok => $ov ) $old_categories_data[$ov->id] = $ov->category_marks;

            $new_categories_data = Array();
            $new_categories_data_ = json_decode($this->input->post('categories'));

            foreach( $new_categories_data_ as $nk => $nv ) {
                if( $nv->id ) {
                    if( $nv->category_marks != $old_categories_data[$nv->id] ) $changed_cat[] = $nv->id;
                    $new_categories_data[] = $nv->id;
                } else {
                    $new_cats = true;
                }
            }

            foreach($old_categories_data as $ok=>$ov)if(!in_array($ok, $new_categories_data))$del_cats = true;

            if($new_cats || $del_cats || count($changed_cat)!=0) {
                $m[]='confirm:cats';
//                $message[]='confirm:cats';
            }
        }

        if( $this->input->post('publish') == 1 ) {
            $message_ = '';
            $m = Array();
            $a = Array();

            if( $this->input->post('class_id')=='' && $this->input->post('student_id')=='' ) { $m[]='<p>You must choose at least one class or one student!</p>'; }
            if( $this->input->post('assignment_title')=='' ) { $m[]='<p>You must fill the title of the assignment!</p>'; }
//            if( $this->input->post('deadline_date') == '' || $this->input->post('deadline_time') == '' ) { $m[]='<p>You must specify the deadlines!</p>';  }
            if( !empty($m) ) { $message_ = 'Some information is missing. Please complete all fields before Publishing'; }
            $date_marker = date('Y-m-d') . ' 7:00';
            if( $this->input->post('publish_date') == '' ) {
                $pdate_time = $date_marker;
            } else {
                $pdate_time = $this->input->post('publish_date'). ' ' . $this->input->post('publish_time');
            }

            $pdate_time_t = strtotime($pdate_time);
            $date_time = $this->input->post('deadline_date'). ' ' . $this->input->post('deadline_time');
            $date_time_t = strtotime($date_time);
            if( $pdate_time_t < strtotime($date_marker) ) { $m[] = '<span>Invalid publish date! You can\'t set publish date less than today!</span>'; }
//            if( $date_time_t <= $pdate_time_t ) { $m[] = '<span>Please select a date for the submission deadline that is later than Publish date!</span>'; }

            if( $date_time_t < $pdate_time_t ) {
                $a[] = "This homework has been saved successfully - please note that the deadline date you have set is in the past!";
            } elseif( $date_time_t < time() ) {
                $a[] = "This homework has been saved successfully - please note that the deadline date you have set is in the past!";
            }

            if( $message_ != '' ) { $message[] = $message_; }
        }
        if( empty($m) ) {
            $id = $this->doSave();

            $result = 1;
            if( $this->input->post('server_require_agree') == "1" ) { $result = 2; }

            if( !count( $a ) ) { $a = null; }
            header('Content-Type: application/json');
            echo json_encode(Array( 'ok' => $result, 'id' => $id, 'warn' => $a ));
            exit();
        } else {
            header('Content-Type: application/json');
            echo json_encode(Array('ok'=>0, 'mess'=>$m));
            exit();
        }
    }

    private function doSave() {
//echo '<pre>';var_dump( $this->user_full_name );die;
        $id = $this->input->post('assignment_id');
        if( $id == -1 ) { $id=''; }
        if( $this->input->post('class_id') == '' )  { $class_id = 0; } else { $class_id = $this->input->post('class_id'); }
        $publish_date = strtotime($this->input->post('publish_date') . ' ' . $this->input->post('publish_time'));
        $deadline_date = strtotime($this->input->post('deadline_date') . ' ' . $this->input->post('deadline_time'));

        $db_data = array(
            'base_assignment_id' => 0,
            'teacher_id' => $this->user_id,
            'student_id' => ltrim( $this->input->post('student_id'), ',' ),
            'class_id' => $class_id,
            'title' => html_entity_decode($this->input->post('assignment_title')),
            'intro' => html_entity_decode($this->input->post('assignment_intro')),
            'grade_type' => $this->input->post('grade_type'),
//            'grade' => $this->input->post('grade_type'),
            'deadline_date' => date('Y-m-d H:i:s', $deadline_date),
            'active' => '1',
            'publish' => $this->input->post('publish'),
            'publish_marks' => $this->input->post('publishmarks'),
            'publish_date' =>  date('Y-m-d H:i:s', $publish_date),
        );

        if( trim( $this->input->post('publish_date') ) != '' ) {
            $db_data['publish_date'] = date('Y-m-d H:i:s', $publish_date);
        }
        if( trim( $this->input->post('deadline_date') ) != '' ) {
            $db_data['deadline_date'] = date('Y-m-d H:i:s', $deadline_date);
        }
        $new_id = $this->assignment_model->save( $db_data, $id );
//echo '<pre>';var_dump( $new_id );
        // updating assignments_filter row
        $assignment_prop = $this->assignment_model->get_assigned_year( $new_id );
        $class_names = $this->classes_model->get_groupname_list( $class_id );
        $row_status = 'draft';
        if( $db_data['publish'] == 0 ) {
            $row_status = 'draft';
            $row_order_weight = 4;
        } elseif( $db_data['publish'] == 1 && $db_data['publish_marks'] == 0 && strtotime( $db_data['publish_date'] ) > time() && strtotime( $db_data['deadline_date'] ) > time() ) {
            $row_status = 'pending';
            $row_order_weight = 2;
        } elseif( $db_data['publish'] == 1 && $db_data['publish_marks'] == 0 && strtotime( $db_data['deadline_date'] ) > time() ) {
            $row_status = 'assigned';
            $row_order_weight = 1;
        } elseif( $db_data['grade_type'] <> 'offline' && $db_data['publish'] == 1 && $db_data['publish_marks'] == 0 && strtotime( $db_data['deadline_date'] ) < time() ) {
            $row_status = 'past';
            $row_order_weight = 3;
        } elseif( ( $db_data['grade_type'] <> 'offline' && $db_data['publish'] == 1 && $db_data['publish_marks'] == 1 ) OR ( $db_data['grade_type'] == 'offline' && $db_data['publish'] == 1 && strtotime( $db_data['deadline_date'] ) < time() ) ) {
            $row_status = 'closed';
            $row_order_weight = 5;
        }
        $row_filter = array(
            'id' => $new_id,
            'base_assignment_id' => $db_data['base_assignment_id'],
            'teacher_id' => $db_data['teacher_id'],
            'publish_date' => $db_data['publish_date'],
            'subject_id' => $assignment_prop['subject_id'],
            'subject_name' => $assignment_prop['name'],
            'year' => $assignment_prop['year'],
            'class_id' => $db_data['class_id'],
            'title' => mysql_real_escape_string( $db_data['title'] ),
            'intro' => mysql_real_escape_string( $db_data['intro'] ),
            'grade_type' => $db_data['grade_type'],
            'grade' => $db_data['grade'],
            'deadline_date' => $db_data['deadline_date'],
            'submitted_date' => $db_data['submitted_date'],
            'feedback' => '',//$row['feedback'],
            'active' => $db_data['active'],
            'publish' => $db_data['publish'],
            'publish_marks' => $db_data['publish_marks'],
            'total' => 0,
            'submitted' => 0,
            'marked' => 0,
            'status' => $row_status,
            'order_weight' => $row_order_weight,
            'teacher_name' => $this->user_full_name,
            'class_name' => $class_names,
        );
        $update_filter_tbl = $this->filter_assignment_model->updateRecord( $row_filter, $new_id );

        if($this->input->post('server_require_agree')=="1") {
            $debug = $this->assignment_model->remove_all_marks( $new_id );
        }

        $categories_post_data = json_decode($this->input->post('categories'));

        if( !empty($categories_post_data) ) {
            $this->assignment_model->update_assignment_categories($new_id, $categories_post_data, $this->input->post('grade_type'));
            $this->assignment_model->update_assignment_attributes($new_id, json_decode($this->input->post('attributes')), $this->input->post('grade_type'));
        }
        return $new_id;
    }

    public function copyAssignment() {
        $old_id = $this->input->post('assignment_id');
        if( $old_id > 0 ) {
            $assignment = $this->assignment_model->get_assignment($old_id);
            $db_data = array(
                'base_assignment_id' => 0,
                'teacher_id' => $this->user_id,
                'student_id' => 0,
                'title' => $assignment->title,
                'intro' => $assignment->intro,
                'grade_type' => $assignment->grade_type,
                'class_id' => $assignment->class_id,
//                'deadline_date' => date('Y-m-d H:i:s', strtotime($assignment->deadline_date)),
                'active' => '1',
                'publish' => 0,
                'publish_marks' => 0
            );
            $new_id = $this->assignment_model->save( $db_data );

            // set categories
            $assignment_categories = $this->assignment_model->get_assignment_categories($old_id);
            if( !empty($assignment_categories) ) {
                foreach( $assignment_categories as $k => $c ) {
                    $cat_data = array(
                        'category_marks'=> $c->category_marks,
                        'category_name'=> $c->category_name,
                        'assignment_id' => $new_id
                    );
                    $this->db->insert( 'assignments_grade_categories', $cat_data );
                }
            }

            // set attrbutes
            $assignment_attributes = $this->assignment_model->get_assignment_attributes($old_id);
            if( !empty( $assignment_attributes ) ) {
                foreach( $assignment_attributes as $k => $a ) {
                    $attr_data = array(
                        'attribute_marks' => $a->attribute_marks,
                        'attribute_name' => $a->attribute_name,
                        'assignment_id' => $new_id
                    );
                    $this->db->insert( 'assignments_grade_attributes', $attr_data );
                }
            }

            // link resources
            $resources = $this->resources_model->get_assignment_resources($old_id);
            if( !empty($resources) ) {
                foreach ($resources as $k => $v) {
                    $this->assignment_model->insert_assignment_resource($v->res_id, $new_id);
                }
            }

            // updating assignments_filter row
            $assignment_prop = $this->assignment_model->get_assigned_year( $old_id );
            $row_filter = array(
                'id' => $new_id,
                'base_assignment_id' => 0,
                'teacher_id' => $this->user_id,
                'student_id' => 0,
                'subject_id' => $assignment_prop['subject_id'],
                'subject_name' => $assignment_prop['name'],
                'year' => $assignment_prop['year'],
                'class_id' => $assignment->class_id,
                'title' => $assignment->title,
                'intro' => $assignment->intro,
                'grade_type' => $assignment->grade_type,
                'grade' => $assignment->grade,
                'deadline_date' => $assignment->deadline_date,
//                'submitted_date' => $assignment->submitted_date,
                'feedback' => '',
                'active' => $assignment->active,
                'publish' => 0,
                'publish_marks' => 0,
                'total' => 0,
                'submitted' => 0,
                'marked' => 0,
                'status' => 'draft',
            );
            $update_filter_tbl = $this->filter_assignment_model->updateRecord( $row_filter, $new_id );

            if( $new_id ) {
                header('Content-Type: application/json');
                echo json_encode( array( 'status' => true, 'assignment_id' => $new_id) );
                exit();
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode( array('status'=>false) );
            exit();
        }
    }

    public function getClasses($subject_id, $year) {
        $teacher_classes = $this->assignment_model->get_teacher_classes_assigment($this->user_id, $subject_id, $year);
        header('Content-Type: application/json');
        echo json_encode($teacher_classes);
        exit();
    }

    public function removeResource() {
        $ass_id = $this->input->post('assignment_id');
        $res_id = $this->input->post('resource_id');
        if( $ass_id && $res_id ) {
            $result = $this->resources_model->remove_resource( 'assignment', $ass_id, $res_id  );
            if( $result ) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
        exit();
    }

    public function removeAssignment() {
        $ass_id = $this->input->post('assignment_id');
        
        if( $ass_id ) {
            $result = $this->assignment_model->exempt_student_assignment( $ass_id  );
            if( $result ) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
        exit();
    }

    public function addAssignment() {
        $ass_id = $this->input->post('assignment_id');
        
        if( $ass_id ) {
            $result = $this->assignment_model->add_student_assignment( $ass_id  );
            $assignment = $this->assignment_model->get_assignment( $ass_id );
            $submission_status = $assignment->publish ? "<i class='icon ok f4t'>" : '';
            if( $result ) {
                echo json_encode(array('res' => 1, 'submission_status' => $submission_status));
            } else {
                echo json_encode(array('res' => 0));
            }
        } else {
            echo json_encode(array('res' => 0));
        }
        exit();
    }

    public function suggestKeystudents() {
        $kwq = $this->input->get('q');
        $kwd = Array();

        if (strlen($kwq) > 1) {
            $where_like = "( first_name LIKE '%".$kwq."%' OR last_name LIKE '%".$kwq."%' OR CONCAT(first_name,' ',last_name) LIKE '%".$kwq."%' ) AND user_type = 'student'";
            $kws = $this->user_model->get_users_custom_search($where_like);
            foreach ($kws as $kk => $vv) {
                $kwd[$vv->id] = $vv->first_name.' '.$vv->last_name;
            }
        }

        echo json_encode($kwd);
        die();
    }

    function saveorder() {
        $order_data = json_decode($this->input->post('data'));
        $assignment_id = $this->input->post('assignment_id');
        foreach( $order_data as $k => $res ) {
            $tmp = explode( '_', $res );
            $this->db->update('assignments_resources', array('sorted' => $k+1), array('resource_id' => $tmp[1], 'assignment_id' => $assignment_id));
        }
    }

}
