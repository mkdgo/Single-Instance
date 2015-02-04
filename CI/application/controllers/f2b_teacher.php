<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class F2b_teacher extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('assignment_model');
        $this->load->model('subjects_model');
        $this->load->model('resources_model');
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->load->library('breadcrumbs');
    }

    function index($id = '-1') {


        $this->_data['assignment_id'] = $id;

        if( strpos(current_url(), 'f2c') )$mode=1;else $mode=2;
        $this->_data['mode'] = $mode;


        $this->_data['resources'] = $this->resources_model->get_assignment_resources($id);
        
//        print_r($this->resources_model->get_assignment_resources($id));
//        die();
        $assignment = $this->assignment_model->get_assignment($id);            

        $this->_data['assignment_title'] = isset($assignment->title) ? $assignment->title : '';
        $this->_data['assignment_intro'] = isset($assignment->intro) ? $assignment->intro : '';
        if (isset($assignment->deadline_date) && $assignment->deadline_date != '0000-00-00 00:00:00') {
            $date_time = strtotime($assignment->deadline_date);
            $date = date('Y-m-d', $date_time);
            $time = date('H:i', $date_time);

            if($date_time <= time())$datepast=1;else $datepast=0;

        } else {
            $date = '';
            $time = '';
            $datepast = '';
        }

        $this->_data['datepast'] = $datepast;
        $this->_data['assignment_date'] = $date;
        $this->_data['assignment_time'] = $time;

        $this->_data['selected_grade_type_pers'] = '';
        $this->_data['selected_grade_type_mark_out'] = '';
        $this->_data['selected_grade_type_grade'] = '';
        $this->_data['selected_grade_type_free_text'] = '';
        if (isset($assignment->grade_type)) {
            switch ($assignment->grade_type) {
                case 'percentage':
                    $this->_data['selected_grade_type_pers'] = 'selected';
                    break;
                case 'mark_out_of_10':
                    $this->_data['selected_grade_type_mark_out'] = 'selected';
                    break;
                case 'grade':
                    $this->_data['selected_grade_type_grade'] = 'selected';
                    break;
                case 'free_text':
                    $this->_data['selected_grade_type_free_text'] = 'selected';
                    break;
            }
        }

        $this->_data['label_grade_type_grade'] = $this->assignment_model->labelsAssigmnetType('grade');
        $this->_data['label_grade_type_percentage'] = $this->assignment_model->labelsAssigmnetType('percentage');
        $this->_data['label_grade_type_free_text'] = $this->assignment_model->labelsAssigmnetType('free_text');


        $this->_data['publish'] = $assignment->publish;
        $this->_data['publishmarks'] = $assignment->publish_marks;


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
                $this->_data['resources'][$k]['resource_name'] = $v->name;
                $this->_data['resources'][$k]['resource_id'] = $v->res_id;
                $this->_data['resources'][$k]['preview'] = $this->resoucePreview($v, '/f2b_teacher/');
            }
        } else {
            $this->_data['resource_hidden'] = 'hidden';
        }

        $classes_years = $this->assignment_model->get_teacher_years_assigment($this->user_id);
        foreach($classes_years as $k=>$CY)
        {
            $classes_year_subjects = $this->assignment_model->get_teacher_subjects_assigment($this->user_id, $CY->year);

            foreach($classes_year_subjects as $ck=>$CS)
            {
                $classes_year_subject_slasses =  $this->assignment_model->get_teacher_classes_assigment($this->user_id, $CS->subject_id, $CY->year);
                $classes_year_subjects[$ck]->classes = $classes_year_subject_slasses;
            }

            $classes_years[$k]->subjects = $classes_year_subjects;
        }

        $this->_data['classes_years']=$classes_years;
        $this->_data['classes_years_json']=json_encode($classes_years);

        $assignment_categories = $this->assignment_model->get_assignment_categories($id);
        $this->_data['assignment_categories'] = $assignment_categories;
        $this->_data['assignment_categories_json'] = json_encode($assignment_categories);

        $assignment_attributes = $this->assignment_model->get_assignment_attributes($id);
        $this->_data['assignment_attributes'] = $assignment_attributes;
        $this->_data['assignment_attributes_json'] = json_encode($assignment_attributes);



        $student_assignments = $this->assignment_model->get_student_assignments($id);
        $this->_data['student_assignments'] = array();
        $this->_data['has_marks']=0;
        foreach ($student_assignments as $key => $value) {            
            $this->_data['student_assignments'][$key]['id'] = $value->id;
            $this->_data['student_assignments'][$key]['submitted'] = $value->submitted;
            $this->_data['student_assignments'][$key]['submitted_on_time'] = $value->submitted_on_time;                        


            //SA

            $marks_avail = 0;

            foreach($assignment_categories as $ask=>$asv)
            {
                $marks_avail += (int) $asv->category_marks;
            }

            $submission_mark = 0;
            $student_resources = $this->resources_model->get_assignment_resources($value->id);
            foreach ($student_resources as $k => $v)
            {
                $mark_data = $this->assignment_model->get_resource_mark($v->res_id);
                if($mark_data[0])
                {
                    $marks_total=$mark_data[0]->total_evaluation;
                }else
                {
                    $marks_total=0;
                }

                $submission_mark += $marks_total;
            }

            if($value->grade=="1")$this->_data['has_marks']="1";

            $this->_data['student_assignments'][$key]['attainment'] = $this->assignment_model->calculateAttainment($submission_mark, $marks_avail*count($student_resources), $assignment);

            $this->_data['student_assignments'][$key]['grade'] = $value->grade;
            $this->_data['student_assignments'][$key]['first_name'] = $value->first_name;
            $this->_data['student_assignments'][$key]['last_name'] = $value->last_name;

            $this->_data['student_assignments'][$key]['data_icon'] = $value->submitted_on_time ? 'check' : 'delete';

            $this->_data['student_assignments'][$key]['data_icon_hidden'] = $value->submitted ? '' : 'hidden';
            $this->_data['student_assignments'][$key]['submission_status'] = $value->publish ? '<i class="icon ok f4t">' : '';
        }
        $this->_data['student_subbmission_hidden'] = count($student_assignments) > 0 ? '' : 'hidden';

        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Homework', '/f1_teacher');
        $this->breadcrumbs->push($this->_data['assignment_title'], '/');

        $this->_data['breadcrumb'] = $this->breadcrumbs->show();

        $this->_paste_public();

    }

    public function save()
    {
        $message = Array();

        if($this->input->post('assignment_id')!=-1 && $this->input->post('has_marks')==1 && $this->input->post('server_require_agree')=="0")
        {
            $changed_cat = Array();
            $new_cats = false;
            $del_cats = false;

            $old_categories_data = Array();
            $old_categories_data_ = $this->assignment_model->get_assignment_categories($this->input->post('assignment_id'));
            foreach($old_categories_data_ as $ok=>$ov)$old_categories_data[$ov->id]=$ov->category_marks;

            $new_categories_data = Array();
            $new_categories_data_ = json_decode($this->input->post('categories'));

            foreach($new_categories_data_ as $nk=>$nv)
            {
                if($nv->id)
                {
                    if($nv->category_marks != $old_categories_data[$nv->id])$changed_cat[]=$nv->id;
                    $new_categories_data[] = $nv->id;

                }else
                {
                    $new_cats = true;
                }
            }

            foreach($old_categories_data as $ok=>$ov)if(!in_array($ok, $new_categories_data))$del_cats = true;

                if($new_cats || $del_cats || count($changed_cat)!=0)
            {
                $message[]='confirm:cats';
            }
        }


        if($this->input->post('publish')==1)
        {
            $message_ = '';
            $m = Array();
            if($this->input->post('class_id')=='')$m[]='You must choose at least one class !';
            if($this->input->post('assignment_title')=='')$m[]='You must fill the title of the assignment !';
            if($this->input->post('assignment_intro')=='')$m[]='You must add the summary information for the assignment !';
            if($this->input->post('deadline_date')=='' || $this->input->post('deadline_time')=='')$m[]='You must specify the deadlines!'; 
            if(!empty($m))$message_ = 'Some information is missing. Please complete all fields before Publishing';

            $date_time = $this->input->post('deadline_date'). ' ' . $this->input->post('deadline_time');
            $date_time_t = strtotime($date_time);
            if($date_time_t <= time())$message_='Invalid deadlines!';


            if($message_!='')$message[] = $message_;
        }

        if(empty($message))
        {
            $id = $this->doSave();

            $result = 1;
            if($this->input->post('server_require_agree')=="1")$result=2;

            header('Content-Type: application/json');
            echo json_encode(Array('ok'=>$result, 'id'=>$id));
            exit();
        }
        else
        {
            header('Content-Type: application/json');
            echo json_encode(Array('ok'=>0, 'mess'=>$message));
            exit();
        }

    }

    public function savemarks()
    {

        if($this->input->post('publish')==1)
        {
            if($this->input->post('class_id')=='')$message[]='You must choose at least one class !';
            if($this->input->post('assignment_title')=='')$message[]='You must fill the title of the assignment !';
            if($this->input->post('assignment_intro')=='')$message[]='You must add the summary information for the assignment !';
            if($this->input->post('deadline_date')=='' || $this->input->post('deadline_time')=='')$message[]='You must specify the deadlines!'; 
        }


        if(empty($message))
        {


            $id = $this->doSave();


            header('Content-Type: application/json');
            echo json_encode(Array('ok'=>1, 'id'=>$id ));
            exit();
        }
        else
        {
            header('Content-Type: application/json');
            echo json_encode(Array('ok'=>0, 'mess'=>$message));
            exit();
        }

    }

    /*
    public function saveaddresource($publish)
    {
    if($publish==1)$this->savepublish();else $this->save(); 
    }

    public function savepublish()
    {


    }
    */

    private function doSave()
    { 
        $id = $this->input->post('assignment_id');
        if($id==-1)$id='';

        if($this->input->post('class_id')=='')$class_id=0;else $class_id=$this->input->post('class_id');
        $deadline_date = strtotime($this->input->post('deadline_date') . ' ' . $this->input->post('deadline_time'));
        $db_data = array(
        'base_assignment_id' => 0,
        'teacher_id' => $this->user_id,
        'student_id' => 0,
        'class_id' => $class_id,
        'title' => $this->input->post('assignment_title'),
        'intro' => $this->input->post('assignment_intro'),
        'grade_type' => $this->input->post('grade_type'),
        'deadline_date' => date('Y-m-d H:i:s', $deadline_date),
        'active' => '1',
        'publish' => $this->input->post('publish'),
        'publish_marks' => $this->input->post('publishmarks')
        );

        $new_id = $this->assignment_model->save($db_data, $id);

        if($this->input->post('server_require_agree')=="1")
        {
            $debug = $this->assignment_model->remove_all_marks($new_id);
        }

        $categories_post_data = json_decode($this->input->post('categories'));

        if(empty($categories_post_data))$categories_post_data=array( (object) array('category_marks'=>0, 'category_name'=>'Default'));

        $this->assignment_model->update_assignment_categories($new_id, $categories_post_data, $this->input->post('grade_type'));
        $this->assignment_model->update_assignment_attributes($new_id, json_decode($this->input->post('attributes')), $this->input->post('grade_type'));

        return $new_id;
    }

    public function getClasses($subject_id, $year)
    {
        $teacher_classes = $this->assignment_model->get_teacher_classes_assigment($this->user_id, $subject_id, $year);
        header('Content-Type: application/json');
        echo json_encode($teacher_classes);
        exit();
    }


    /* P2
    public function copy($id = '') {
    if ($id != '') {
    $assignment = $this->assignment_model->get_single_assignment($id);

    $data = array(
    'title' => $assignment->title,
    'intro' => $assignment->intro,
    'grade_type' => '',
    'deadline_date' => '',
    'assigned_to' => $assignment->assigned_to,
    'depending_classes' => '',
    'active' => '0',
    );
    $this->assignment_model->save($data);
    $last_inserted_id = $this->db->insert_id();
    $resources = $this->resources_model->get_assignment_resources($assignment->id);
    foreach ($resources as $resource) {
    $this->resources_model->add_resource('assignment', $last_inserted_id, $resource->resource_id);
    }
    }
    redirect('/f2b_teacher/index/' . $last_inserted_id . '/copy');
    }*/

}