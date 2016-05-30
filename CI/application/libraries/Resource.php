<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resource {

    private $_res_id;
    private $_res = null;
    private $_head = array();
    private $_content = null;
    private $_intro;
    private $_question;
    private $_answers = array();
    private $_info = array();

    private $_type;
    private $_html;
    private $_body;
    public $_xml;
    public $_resource_types = array();
    public $resource = null;

    public function __construct() {
//require_once('resources.xml');
        $this->_xml = simplexml_load_file( APPPATH."libraries/resources.xml" ) or die("Error: Cannot create object");
        $this->getTypes();
        
    }

    public function getTypes() {
        foreach( $this->_xml->children() as $type ) {
            $key = $type[0]->attributes()['value'];
            $val = $type[0]->attributes()['name'];
            $this->_resource_types[$key->__toString()] = $val->__toString();
        }
    }

    public function renderTypes($type='') {
        $show_types = '';
        foreach( $this->_resource_types as $key => $val ) {
            if( $type == $key ) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $show_types .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
        }
        return $show_types;
    }

    public function renderBody($action = 'create', $type = 'local_file', $resource = null ) {
        if( $resource ) {
            $this->resource = $resource;
            $this->_res_id = $resource->id;
            $this->_type = $type;
//            $this->_type = $resource->type;
            $this->_res = json_decode( $resource->content, true );;
            $this->_content = $this->_res['content'];
            $this->_answers = $this->_res['content']['answer'];
        } else {
            $this->_res_id = '';
            $this->_type = $type;
        }

        $filename = $action.'body_'.$type.'.php';
        $file = APPPATH."libraries/Resource/$filename";
        switch( $action ) {
            case 'create' : $myvar = $this->_create($file);
                break;
            case 'edit' : $myvar = $this->_edit($file, $resource);
                break;
            case 'update' : $myvar = $this->_update($file, $resource);
//echo '<pre>';var_dump( $resource );die;
                break;
            case 'show' : $myvar = $this->_show($file);
                break;
        }
        return $myvar;
    }

    public function renderShowTeacherForm( $resource, $user_id ) {
        $content = $this->renderBody( 'show', $resource->type, $resource );
        $table = '';
        $html_form = '<div id="' . $resource->id  . '" class="quiz-container">
    <form class="form-horizontal form_' . $resource->id  . '" id="form_' . $resource->id  . '" name="form_' . $resource->id  . '" rel="'.$resource->type.'" method="post" action="">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'.$content.'</div>
        </div>
        <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; padding-top:20px; padding-bottom: 30px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div style="text-align: center;"><a href="javascript:;" onclick="refreshTableAnswer($(\'.tbl_'.$resource->id.'\'), $(\'.form_'.$resource->id.'\'))" class="green_btn refreshTableAnswer" style="display: none;">UPDATE RESULTS</a></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; ">
                    <div id="chart_'.$resource->id.'" rel='.$resource->id.' style="margin: 0 auto 20px; width: 90%;" cellpadding="10"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; ">
                    <table class="tbl_'.$resource->id.' tbl_results" rel='.$resource->id.' style="margin: 0 auto 20px; width: auto;" cellpadding="10">'.$table.'</table>
                </div>
            </div>
        </div>
    </form>
</div>';
        return $html_form;
    }

    public function renderEditTeacherForm( $resource, $user_id ) {
        $content = $this->renderBody( 'edit', $resource->type, $resource );
        $table = '';
        $html_form = '<div id="' . $resource->id  . '" class="quiz-container">
    <form class="form-horizontal form_' . $resource->id  . '" id="form_' . $resource->id  . '" name="form_' . $resource->id  . '" method="post" action="">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'.$content.'</div>
        </div>
<!--        <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; padding-top:20px; padding-bottom: 30px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div style="text-align: center;"><a href="javascript:;" onclick="refreshTableAnswer($(\'.tbl_'.$resource->id.'\'), $(\'.form_'.$resource->id.'\'))" class="green_btn">Refresh Results</a></div>
            </div>
        </div>-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; ">
                    <table class="tbl_'.$resource->id.' tbl_results" rel='.$resource->id.' style="margin: 0 auto 20px; width: auto;" cellpadding="10">'.$table.'</table>
                </div>
            </div>
        </div>
    </form>
</div>';
        return $html_form;
    }

    public function renderShowStudentForm( $resource, $user_id ) {
        $content = $this->renderBody( 'show', $resource->type, $resource );
        $table = '';
        $html_form = '<div id="' . $resource->id  . '" class="quiz-container">
    <form class="form-horizontal " id="form_' . $resource->id  . '" name="form_' . $resource->id  . '" method="post" action="">
        <input type="hidden" name="student_id" value="'.$user_id.'" />
        <input type="hidden" name="lesson_id" value="" />
        <input type="hidden" name="slide_id" value="" />
        <input type="hidden" name="type" value="'.$resource->type.'" />
        <input type="hidden" name="resource_id" value="'.$resource->id.'" />
        <input type="hidden" name="behavior" value="" />
        <input type="hidden" name="identity" value="" />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'.$content.'
                <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; padding-top:20px; padding-bottom: 30px;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div style="text-align: center;"><a href="javascript:;" onclick="submitAnswer($(\'.tbl_'.$resource->id.'\'), $(\'#form_'.$resource->id.'\'), this)" class="green_btn submit-answer">Submit</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="tbl_'.$resource->id.' tbl_results" onclick="return false;" rel='.$resource->id.' style="margin: 0 0 20px;" cellpadding="10">'.$table.'</div>
                    </div>

                    <!--<table class="tbl_'.$resource->id.' tbl_results" onclick="return false;" rel='.$resource->id.' style="margin: 0 auto 20px; width: auto;" cellpadding="10">'.$table.'</table>-->
                </div>
            </div>
        </div>
    </form>
    <div class="clear"></div>
</div>';
        return $html_form;        
    }

    public function renderEditStudentForm( $resource, $user_id, $tbl = '' ) {
        $content = $this->renderBody( 'edit', $resource->type, $resource );
        $table = $tbl;
        $html_form = '<div id="' . $resource->id  . '" class="quiz-container">
    <form class="form-horizontal " id="form_' . $resource->id  . '" name="form_' . $resource->id  . '" method="post" action="">
        <input type="hidden" name="student_id" value="'.$user_id.'" />
        <input type="hidden" name="lesson_id" value="" />
        <input type="hidden" name="slide_id" value="" />
        <input type="hidden" name="type" value="'.$resource->type.'" />
        <input type="hidden" name="resource_id" value="'.$resource->id.'" />
        <input type="hidden" name="behavior" value="" />
        <input type="hidden" name="identity" value="" />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'.$content.'</div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="tbl_'.$resource->id.' tbl_results" onclick="showResult('.$resource->id.')" rel='.$resource->id.' style="margin: 0 0 20px; " cellpadding="10">'.$table.'</div>
                    </div>

                    <!--<table class="tbl_'.$resource->id.' tbl_results" onclick="showResult('.$resource->id.')" rel='.$resource->id.' style="margin: 0 auto 20px; width: auto;" cellpadding="10">'.$table.'</table>-->
                </div>
            </div>
        </div>
    </form>
    <div class="clear"></div>
</div>';
        return $html_form;        
    }

    public function save() {
        
    }

    public function saveAnswer( $post_data ) {
        require_once APPPATH."models/student_answers_model.php";
        $ans = new Student_answers_model();
        $post_data['answer'] = $this->_parseAnswer($post_data);

        $save_data = array(
            'student_id' => $post_data['student_id'],
            'student_name' => $post_data['student_name'],
            'teacher_id' => $post_data['teacher_id'],
            'teacher_name' => $post_data['teacher_name'],
            'subject_id' => $post_data['subject_id'],
            'subject_name' => $post_data['subject_name'],
            'year_id' => $post_data['year_id'],
            'year' => $post_data['year'],
            'class_id' => $post_data['class_id'],
            'class_name' => $post_data['class_name'],
            'lesson_id' => $post_data['lesson_id'],
            'lesson_title' => $post_data['lesson_title'],
            'slide_id' => $post_data['slide_id'],
            'type' => $post_data['type'],
            'resource_id' => $post_data['resource_id'],
            'marks_available' => $post_data['marks_available'],
            'attained' => $post_data['attained'],
            'answers' => $post_data['answer'],
            'behavior' => $post_data['behavior'],
            'identity' => $post_data['identity']
        );

        $ans_id = $ans->save($save_data);
        return $ans_id;
    }

    private function _create($file) {
        if( file_exists( $file ) ) {
            ob_start();
            include $file;
            $myvar = ob_get_contents();
            ob_end_clean();
        } else {
            $myvar = '';
        }
        return $myvar;
    }

    private function _edit($file, $resource) {
        if( file_exists( $file ) ) {
            ob_start();
            include $file;
            $this->_html = ob_get_contents();
            ob_end_clean();
            $this->_setFormName();
            $this->_renderIntroImg();
            $this->_setIntroTxt();
            $this->_setQuestion();
            $this->_renderAnswer();
            $this->_setBehavior();
        } else {
            $this->_html = '';
        }
        return $this->_html;
    }

    private function _update($file, $resource) {
        if( file_exists( $file ) ) {
            ob_start();
            include $file;
            $this->_html = ob_get_contents();
            ob_end_clean();
            $this->_setFormName();
            $this->_setIntroImg();
            $this->_setIntroTxt();
            $this->_setQuestion();
            $this->_setAnswer();
            $this->_setBehavior();
//echo '<pre>';var_dump( $resource );die;
        } else {
            $this->_html = '';
        }
        return $this->_html;
    }

    private function _show($file) {
        if( file_exists( $file ) ) {
            ob_start();
            include $file;
            $this->_html = ob_get_contents();
            ob_end_clean();
            $this->_setFormName();
            $this->_renderIntroImg();
            $this->_setIntroTxt();
            $this->_setQuestion();
            $this->_renderAnswer();
            $this->_setBehavior();
        } else {
            $this->_html = '';
        }
        return $this->_html;
    }

    private function _setHtml() {
        
    }

    private function _setFormName() {
        
    }

    private function _setIntroImg() {
        if( !$img = $this->_content['intro']['file'] ) {
            $img = $this->resource->resource_name;
        }
//echo '<pre>';var_dump( $img );die;

        if( $img != '' ) {
            $ext = end(explode('.', $img));
            if( $ext == 'pdf' ) {
                $view = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="/ViewerJS/index.html#/uploads/resources/temp/'.$img.'" style="color: #fff;">view</a>';
            } elseif( in_array( $ext, array('png','jpg','jpeg','gif') ) ) {
                $view = '<a onClick="$(this).colorbox();" href="/uploads/resources/temp/'.$img.'" style="color: #fff;">view</a>';
            } else {
                $view = '<a onClick="$(this).colorbox({iframe:true, innerWidth:\'80%\', innerHeight:\'80%\'});" href="/c2n/resource/'.$this->resource->id.'" style="color: #fff;">view</a>';
            }

            $html_img = '<div class="c2_radios upload_box" style="float: left;margin: 10px;">
                    <input type="hidden" name="content[intro][file]" id="file_uploaded" value ="'.$img.'" />
                    <input type="checkbox" id="file_uploaded_f"  value="'.$img.'" disabled="disabled" checked="checked">
                    <label for="file_uploaded_f" id="file_uploaded_label" >'.$view.'</label>
                </div>';
        } else {
            $html_img = '<div class="c2_radios upload_box" style="float: left;margin: 10px;display: none;">
                    <input type="hidden" name="content[intro][file]" id="file_uploaded" value ="" />
                    <input type="checkbox" id="file_uploaded_f" value="" disabled="disabled" checked="checked">
                    <label for="file_uploaded_f" id="file_uploaded_label" ></label>
                </div>';
        }
        $this->_html = str_replace( '[QFILE]', $html_img, $this->_html );
    }

    private function _renderIntroImg() {
        $img = $this->_content['intro']['file'];
        if( $img != '' ) {
            $this->_html = str_replace( '[IMG]', '<img src="/uploads/resources/temp/'.$img.'" style="width: inherit; height: inherit; border: none;" />', $this->_html );
        } else {
            $img = $this->_content;
//echo '<pre>';var_dump( $img );
            $this->_html = str_replace( '[IMG]', '', $this->_html );
        }
    }

    private function _setIntroTxt() {
        $txt = $this->_content['intro']['text'];
        if( $txt != '' ) {
            $txt = nl2br( $txt );
            $this->_html = str_replace( '[TEXT]', $txt, $this->_html );
            $this->_html = str_replace( '[ISTEXT]', '', $this->_html );
        } else {
            $this->_html = str_replace( '[TEXT]', '', $this->_html );
            $this->_html = str_replace( '[ISTEXT]', 'display:none;', $this->_html );
        }
    }

    private function _setQuestion() {
        $q = $this->_content['question'];
        if( $q != '' ) {
            $this->_html = str_replace( '[QUESTION]', $q, $this->_html );
        }
    }

    private function _setBehavior() {
        $q = isset( $this->_content['behavior'] ) ? $this->_content['behavior']: '';
        if( $q != '' ) {
            $this->_html = str_replace( '[BEHAVIOR]', $q, $this->_html );
        }
    }

    private function _setAnswer() {
        $type = $this->_type;
        $html_answer = '';
        $i = 0;
        switch( $type ) {
            case 'single_choice' :
                foreach( $this->_answers as $answer ) {
                    if( isset( $answer['true'] ) && $answer['true'] == 1 ) {
                        $sel = ' checked="checked"';
                    } else {
                        $sel = '';
                    }
                    $html_answer .= '<div class="option row" style="margin-left: 0; margin-right: 0; margin-bottom:10px;">
                        <input onclick="setCheck(this)" class="col-lg-1 col-md-1 col-sm-1 col-xs-12 set-answer-true" type="checkbox" name="content[answer]['.$i.'][true]" id="answer_true_'.$i.'" value="1" '.$sel.' >
                        <label class="col-lg-1 col-md-1 col-sm-1 col-xs-12 set-answer-true-label" for="answer_true_'.$i.'" >true</label>
                        <input class="col-lg-3 col-md-3 col-sm-3 col-xs-12 set-answer-label" type="text" name="content[answer]['.$i.'][label]" id="answer_label_'.$i.'" data-validation-required-message="Please fill Label" placeholder="Option" value="'.$answer['label'].'" />
                        <input class="col-lg-2 col-md-2 col-sm-2 col-xs-12 set-answer-value" type="text" name="content[answer]['.$i.'][value]" id="answer_value_'.$i.'" data-validation-required-message="Please fill Evaluation" placeholder="Score" value="'.$answer['value'].'" />
                        <input class="col-lg-5 col-md-5 col-sm-5 col-xs-12 fb set-answer-feedback" type="text" name="content[answer]['.$i.'][feedback]" id="answer_feedback_'.$i.'" data-validation-required-message="Please fill Evaluation" placeholder="Automated Feedback" value="'.$answer['feedback'].'" />
                        <span class="set-answer-delete-span" id="answer_delete_'.$i.'" ><a class="delete2 set-answer-delete" href="javascript:removeOption('.$i.')"></a></span>
                    </div>';
                    $i++;
                }
                $this->_html = str_replace( '[ANSWERS]', $html_answer, $this->_html );
                break;
            case 'multiple_choice' :
                foreach( $this->_answers as $answer ) {
                    if( isset( $answer['true'] ) && $answer['true'] == 1 ) {
                        $sel = ' checked="checked"';
                    } else {
                        $sel = '';
                    }
                    $html_answer .= '<div class="option row" style="margin-left: 0; margin-right: 0; margin-bottom:10px;">
                        <input onclick="setCheck(this)" class="col-lg-1 col-md-1 col-sm-1 col-xs-12 set-answer-true" type="checkbox" name="content[answer]['.$i.'][true]" id="answer_true_'.$i.'" value="1" '.$sel.' >
                        <label class="col-lg-1 col-md-1 col-sm-1 col-xs-12 set-answer-true-label" style="margin: 0px 10px 0px 0px !important" for="answer_true_'.$i.'" >true</label>
                        <input class="col-lg-3 col-md-3 col-sm-3 col-xs-12 set-answer-label" type="text" name="content[answer]['.$i.'][label]" id="answer_label_'.$i.'" data-validation-required-message="Please fill Label" placeholder="Option" value="'.$answer['label'].'" />
                        <input class="col-lg-2 col-md-2 col-sm-2 col-xs-12 set-answer-value" type="text" name="content[answer]['.$i.'][value]" id="answer_value_'.$i.'" data-validation-required-message="Please fill Evaluation" placeholder="Score" value="'.$answer['value'].'" />
                        <input class="col-lg-5 col-md-5 col-sm-5 col-xs-12 fb set-answer-feedback" type="text" name="content[answer]['.$i.'][feedback]" id="answer_feedback_'.$i.'" data-validation-required-message="Please fill Evaluation" placeholder="Automated Feedback" value="'.$answer['feedback'].'" />
                        <span class="set-answer-delete-span" id="answer_delete_'.$i.'" ><a class="delete2 set-answer-delete" href="javascript:removeOption('.$i.')"></a></span>
                    </div>';
                    $i++;
                }
                $this->_html = str_replace( '[ANSWERS]', $html_answer, $this->_html );
                break;
            case 'fill_in_the_blank' :
                $ca = count($this->_answers);
                if( $ca > 0 ) {
                    $a = 0;
                    $id = $this->_res_id;
                    $html_ans = '';
                    $txt = $this->_content['target'];
                    foreach( $this->_answers as $answer ) {
                        $a++;
                        $txt1 = str_replace( '['.$answer['label'].']', '<input type="text" name="answer[q'.$id.'_blank'.($a+1).']" id="q'.$id.'_blank'.($a+1).'" value="" style="width:100px;display: inline-block;padding: 10px 90px;border-radius: 5px;background-color: #f5f5f5;"/>', $txt );
                        $txt = $txt1;
                    }
                    $html_preview = $txt;
                    $this->_html = str_replace( '[PREVIEW]', trim( $html_preview ), $this->_html );
                    $this->_html = str_replace( '[ANSWERS]', trim( $html_answer ), $this->_html );
                    $this->_html = str_replace( '[JSON_ANSWERS]', json_encode( $this->_answers ), $this->_html );
                    $this->_html = str_replace( '[COUNT_ANSWERS]', $a, $this->_html );
                } else {
                    $this->_html = str_replace( '[ANSWERS]', '', $this->_html );
                    $this->_html = str_replace( '[PREVIEW]', trim( $this->_content['target'] ), $this->_html );
                }
                $this->_html = str_replace( '[TARGET]', trim( $this->_content['target'] ), $this->_html );
                break;
            case 'mark_the_words' :
                $ca = count($this->_answers);
                if( $ca > 0 ) {
                    $a = 0;
                    $id = $this->_res_id;
                    $html_ans = '';
                    $txt = $this->_content['target'];
                    foreach( $this->_answers as $answer ) {
                    }
                    $html_preview = $txt;
                    $this->_html = str_replace( '[PREVIEW]', trim( $html_preview ), $this->_html );
                    $this->_html = str_replace( '[ANSWERS]', trim( $html_answer ), $this->_html );
                    $this->_html = str_replace( '[JSON_ANSWERS]', json_encode( $this->_answers ), $this->_html );
                    $this->_html = str_replace( '[COUNT_ANSWERS]', $a, $this->_html );
                } else {
                    $this->_html = str_replace( '[ANSWERS]', '', $this->_html );
                    $this->_html = str_replace( '[PREVIEW]', trim( $this->_content['target'] ), $this->_html );
                }
                $this->_html = str_replace( '[TARGET]', trim( $this->_content['target'] ), $this->_html );
                break;
        }
    }

    private function _renderAnswer() {
        $answers = $this->_content['answer'];
        switch( $this->_type ) {
            case 'single_choice' : 
                if( count($answers) > 0 ) {
                    $id = $this->_res_id;
                    $html_ans = '';
                    $i = 0;
                    foreach( $answers as $ans ) {
                        $html_ans .= '<input type="radio" name="answer[q'.$id.']" id="i_q'.$id.'_a'.$i.'" value="q'.$id.'_a'.$i.'">';
                        $html_ans .= '<label id="q'.$id.'_a'.$i.'"  for="i_q'.$id.'_a'.$i.'">'.$ans['label'].'</label>';
                        $i++;
                    }

                    $this->_html = str_replace( '[ANSWERS]', $html_ans, $this->_html );
                }
                break;
            case 'multiple_choice' : 
                if( count($answers) > 0 ) {
                    $id = $this->_res_id;
                    $html_ans = '';
                    $i = 0;
                    foreach( $answers as $ans ) {
                        $html_ans .= '<input type="checkbox" name="answer[q'.$id.'_a'.$i.']" id="i_q'.$id.'_a'.$i.'" value="q'.$id.'_a'.$i.'">';
                        $html_ans .= '<label id="q'.$id.'_a'.$i.'" for="i_q'.$id.'_a'.$i.'" class="multiplechoicelabel">'.$ans['label'].'</label>';
                        $i++;
                    }

                    $this->_html = str_replace( '[ANSWERS]', $html_ans, $this->_html );
                }
                break;
            case 'fill_in_the_blank' :
                $ca = count($answers);
                if( $ca > 0 ) {
                    $id = $this->_res_id;
                    $html_ans = '';
                    $txt = $this->_content['target'];
                    for( $i = 0; $i < $ca; $i++ ) {
                        $txt1 = str_replace( '['.$answers[$i+1]['label'].']', '<input type="text" name="answer[q'.$id.'_blank'.($i+1).']" id="q'.$id.'_blank'.($i+1).'" value="" style="width:180px;display: inline-block;padding: 10px;border-radius: 5px;background-color: #f5f5f5;"/>', $txt );
                        $txt = $txt1;
                    }
                    $txt = nl2br( $txt );
                    $html_ans = $txt;
                    $this->_html = str_replace( '[ANSWERS]', $html_ans, $this->_html );
                }
                break;
            case 'mark_the_words' :
                $ca = count($answers);
                $arr_txt = explode(' ', $this->_content['target']);
                $i = 0;
                foreach( $arr_txt as $txt ) {
                    $rtxt = str_replace( array('[',']'), array('',''), $txt );
                    $_id = 'q'.$this->_res_id.'_w'.$i;
                    $_txt[$i] = '<span id="q'.$this->_res_id.'w'.($i).'" class="ans" onclick="setAnswer($(this), \''.$_id.'\', '.$this->_res_id.' );" style="cursor: pointer;" rel="0">';
                    $_txt[$i] .= $rtxt.'<input type="hidden" name="answer['.$_id.']" id="'.$_id.'" rel="w'.$i.'" value=""/></span>';
                    $i++;
                }
                $str_txt = implode(' ', $_txt );
                $str_txt .= '<span id="'.'q'.$this->_res_id.'_c'.'" rel="'.$ca.'" num="0"></span>';
                $str_txt = nl2br( $str_txt );
                $this->_html = str_replace( '[ANSWERS]', $str_txt, $this->_html );

                break;
        }
    }

    private function _parseAnswer($data) {
        $ans = '';
        $answers = $data['answer'];
        switch( $data['type'] ) {
            case 'single_choice' : 
            case 'multiple_choice' : 
                if(count($answers)) {
                    $ans = implode( ',', $answers );
                }
                break;
            case 'mark_the_words' :
                $i = 0;
                foreach($answers as $an ) {
                    if(empty($an)) {
                        unset($answers[$i]);
                    }
                    $i++;
                }
                $ans = implode( ',', $answers );
                break;
            case 'fill_in_the_blank' :
                foreach($answers as $k => $v ) {
                    $ans .= $k.'=:'.$v.',';
                }
                if( $ans != '' ) {
                    $ans = substr( $ans, 0, -1 );
                }
                break;
        }
        return $ans;
    }

    public function getAvailableMarks( $content ) {
        $type = $content['header']['type'];
        $answers_true = $content['content']['answer'];
        $available_marks = 0;
        $max_value = 0;
        switch( $type ) {
            case 'single_choice' :
                foreach( $answers_true as $ans ) {
                    if( $ans['value'] > $max_value ) {
                        $max_value = $ans['value'];
                    }
                }
                break;
            case 'multiple_choice' :
                foreach( $answers_true as $ans ) {
                    if( $ans['value'] > 0 ) {
                        $max_value = $max_value + $ans['value'];
                    }
                }
                break;
            case 'fill_in_the_blank' :
                foreach( $answers_true as $ans ) {
                    if( $ans['value'] > 0 ) {
                        $max_value = $max_value + $ans['value'];
                    }
                }
                break;
            case 'mark_the_words' :
                foreach( $answers_true as $ans ) {
                    if( $ans['value'] > 0 ) {
                        $max_value = $max_value + $ans['value'];
                    }
                }
                break;
        }
        $available_marks = $max_value;
        return $available_marks;        
    }

    public function setAttained( $res_id, $content, $answers_results ) {
//echo '<pre>';var_dump( $answers_results );die;

        $tbl = '';
        $type = $content['header']['type'];
        $answers_true = $content['content']['answer'];

        $attained = 0;
        switch( $type ) {
            case 'single_choice' :
                $i = 0;
                foreach( $answers_true as $ans ) {
                    foreach( $answers_results as $result ) {
                        $answers = explode( ',', $result );
                        foreach($answers as $answ ) {
                            $q = 'q'.$res_id.'_a';
                            $k = substr($answ, strlen($q));
                            if( $i == $k ) {
                                 $attained = $attained + $ans['value'];
                            }
                        }
                    }
                    $i++;
                }
                break;
            case 'multiple_choice' :
                $i = 0;
                foreach( $answers_true as $ans ) {
                    foreach( $answers_results as $result ) {
                        $answers = explode( ',', $result );
                        foreach($answers as $answ ) {
                            $q = 'q'.$res_id.'_a';
                            $k = substr($answ, strlen($q));
                            if( $i == $k ) {
                                $attained = $attained + $ans['value'];
                            }
                        }
                    }
                    $i++;
                }
                break;
            case 'fill_in_the_blank' :
                $i = 1;
                foreach( $answers_true as $key => $ans ) {
                    $true = '';
                    foreach( $answers_results as $akey => $result ) {
                        $answers = explode( ',', $result );
                        $tmp_answ = explode('=:', $akey); 
                        $q = 'q'.$res_id.'_blank';
                        $k = substr($tmp_answ[0], strlen($q));

                        if( $key == $k ) {
                            if( trim($result) == '' ) {
                            } elseif( strtolower(trim($ans['label'])) == strtolower(trim($result)) ) {
                                $attained = $attained + $ans['value'];
                            } else {
                            }
                        }
                    }
                    $i++;
                }
                break;
            case 'mark_the_words' :
                $pos = array();
                $i = 0;
                foreach( $answers_true as $key => $ans ) {
                    $arr[$i] = 0;
                    if( in_array( 'w'.$ans['position'], $answers_results ) ) {
                        $attained = $attained + $ans['value'];
                    } else {
                        
                    }
                    $pos[] = 'w'.$ans['position'];
                }
                foreach( $answers_results as $result ) {
                    $wrong = 0;
                    if( !empty($result) && !in_array( $result, $pos ) ) {
                    }
                }
                break;
        }

        return $attained;
    }

    public function renderResultToJson($res_id, $content, $answers_results, $studentcount = 0) {
        $tbl = '';
        $type = $content['header']['type'];
        $answers_true = $content['content']['answer'];

        switch( $type ) {
            case 'single_choice' :
                $arr_ans = array();
                $arr_ans['cols'][0]['type'] = 'string';
                $arr_ans['cols'][0]['value'] = 'Option';
                $arr_ans['cols'][1]['type'] = 'number';
                $arr_ans['cols'][1]['value'] = 'Answers';
                //$arr_ans['cols'][2]['type'] = 'string';
                //$arr_ans['cols'][2]['value'] = '{ role: "annotation" }';
                
                //set text label in first column of results and initialise count at zero
                $i = 0;
                foreach( $answers_true as $ans ) {
                    $arr_ans['rows'][$i][0] = $ans['label'];
                    $arr_ans['rows'][$i][1] = 0;
                    //$arr_ans['rows'][$i][2] = 0;
                    $i++;
                }
                
                //count responses in second column of results
                foreach( $answers_results as $result ) {
                    $answers = explode( ',', $result->answers );
                    $r = 0;
                    foreach($answers as $answ ) {
                        $q = 'q'.$res_id.'_a';
                        $k = substr($answ, strlen($q));
                        $b = $k+1;
                        $arr_ans['rows'][$k][1] += 1;
                        //$arr_ans['rows'][$k][2] += 1;
                        $r++;
                    }
                }
                break;    
            case 'multiple_choice' :
                $arr_ans = array();
                $arr_ans['cols'][0]['type'] = 'string';
                $arr_ans['cols'][0]['value'] = 'Option';
                $arr_ans['cols'][1]['type'] = 'number';
                $arr_ans['cols'][1]['value'] = 'Answers';
                //$arr_ans['cols'][2]['type'] = 'string';
                //$arr_ans['cols'][2]['value'] = '{ role: "annotation" }';
                
                //set text label in first column of results and initialise count at zero
                $i = 0;
                foreach( $answers_true as $ans ) {
                    $arr_ans['rows'][$i][0] = $ans['label'];
                    $arr_ans['rows'][$i][1] = 0;
                    //$arr_ans['rows'][$i][2] = 0;
                    $i++;
                }
                
                //count responses in second column of results
                foreach( $answers_results as $result ) {
                    $answers = explode( ',', $result->answers );
                    $r = 0;
                    foreach($answers as $answ ) {
                        $q = 'q'.$res_id.'_a';
                        $k = substr($answ, strlen($q));
                        $b = $k+1;
                        $arr_ans['rows'][$k][1] += 1;
                        //$arr_ans['rows'][$k][2] += 1;
                        $r++;
                    }
                }
                break;
            case 'fill_in_the_blank' :
                $arr_ans = array();
                $arr_ans['cols'][0]['type'] = 'string';
                $arr_ans['cols'][0]['value'] = 'Option';
                $arr_ans['cols'][1]['type'] = 'number';
                $arr_ans['cols'][1]['value'] = 'Answers';
                
                
                //set answer count
                $arr_ans['rows'][0][0] = "Answered";
                $arr_ans['rows'][0][1] = 0;
                $arr_ans['rows'][1][0] = "Unanswered";
                $arr_ans['rows'][1][1] = $studentcount;
                
                //count responses in second column of results
                foreach( $answers_results as $result ) {
                    $arr_ans['rows'][0][1] += 1;
                    $arr_ans['rows'][1][1] -= 1;
                }
                break;
            case 'mark_the_words' :
                $arr_ans = array();
                $arr_ans['cols'][0]['type'] = 'string';
                $arr_ans['cols'][0]['value'] = 'Option';
                $arr_ans['cols'][1]['type'] = 'number';
                $arr_ans['cols'][1]['value'] = 'Answers';
                
                
                //set answer count
                $arr_ans['rows'][0][0] = "Answered";
                $arr_ans['rows'][0][1] = 0;
                $arr_ans['rows'][1][0] = "Unanswered";
                $arr_ans['rows'][1][1] = $studentcount;
                
                //count responses in second column of results
                foreach( $answers_results as $result ) {
                    $arr_ans['rows'][0][1] += 1;
                    $arr_ans['rows'][1][1] -= 1;
                }
                break;
        }

        return $arr_ans;
    }

    public function renderResultTable($res_id, $content, $answers_results) {
        $tbl = '';
        $type = $content['header']['type'];
        $answers_true = $content['content']['answer'];

        switch( $type ) {
            case 'single_choice' :
            case 'multiple_choice' :
                $tr_h = '<tr><th>Answers - '.count($answers_results).'</th><th>Results</th></tr>';
                $tr_d = '';
                $i = 0;
                foreach( $answers_true as $ans ) {
                    $tr_d .= '<tr><td>'.$ans['label'].'</td>';
                    $arr[$i] = 0;
                    foreach( $answers_results as $result ) {
                        $answers = explode( ',', $result->answers );
                        foreach($answers as $answ ) {
                            $q = 'q'.$res_id.'_a';
                            $k = substr($answ, strlen($q));
                            $arr[$k] += 1;
                        }
                    }
                    $tr_d .= '<td class="ans_res">'.$arr[$i].'</td></tr>';
                    $i++;
                }
                break;
            case 'fill_in_the_blank' :
                $tr_h = '<tr><th>Answers - '.count($answers_results).'</th><th colspan="3">Results</th></tr>';
                $tr_h .= '<tr><td></td><td>true</td><td>false</td><td>empty</td></tr>';
                $tr_d = '';
                $i = 1;
                foreach( $answers_true as $key => $ans ) {
                    $tr_d .= '<tr><td>'.$ans['label'].'</td>';
                    $arr[$i]['true'] = 0;
                    $arr[$i]['false'] = 0;
                    $arr[$i]['empty'] = 0;
                    foreach( $answers_results as $result ) {
                        $answers = explode( ',', $result->answers );
                        foreach($answers as $answ ) {
                            $tmp_answ = explode('=:', $answ); 
                            $q = 'q'.$res_id.'_blank';
                            $k = substr($tmp_answ[0], strlen($q));
                            if( $key == $k ) {
                                if( trim($tmp_answ[1]) == '' ) {
                                    $arr[$k]['empty'] += 1;
                                } elseif( strtolower(trim($ans['label'])) == strtolower(trim($tmp_answ[1])) ) {
                                    $arr[$k]['true'] += 1;
                                } else {
                                    $arr[$k]['false'] += 1;
                                }
                            }
                        }
                    }
                    $tr_d .= '<td class="ans_res">'.$arr[$i]['true'].'</td><td style="border-right: none; text-align: center;">'.$arr[$i]['false'].'</td><td style="text-align: center;">'.$arr[$i]['empty'].'</td></tr>';
                    $i++;
                }
                break;
            case 'mark_the_words' :
                $tr_h = '<tr><th>Answers - '.count($answers_results).'</th><th>Results</th></tr>';
                $tr_d = '';
                $pos = array();
                $i = 0;
                foreach( $answers_true as $key => $ans ) {
                    $tr_d .= '<tr><td>'.$ans['label'].'</td>';
                    $arr[$i] = 0;
                    foreach( $answers_results as $result ) {
                        $answers = explode( ',', $result->answers );
                        if( in_array( 'w'.$ans['position'], $answers ) ) {
                            $arr[$i] += 1;
                        }
                    }
                    $tr_d .= '<td class="ans_res">'.$arr[$i].'</td></tr>';
                    $i++;
                    $pos[] = 'w'.$ans['position'];
                }
                foreach( $answers_results as $result ) {
                    $tmp_answers = explode( ',', $result->answers );
                    $wrong = 0;
                    $tr_d .= '<tr><td style="font-weight: bold;">wrong</td>';
                    foreach( $tmp_answers as $r_ans ) {
                        if( !in_array( $r_ans, $pos ) ) {
                            $wrong += 1;
                        }
                    }
                    $tr_d .= '<td class="ans_res">'.$wrong.'</td></tr>';
                }
                break;
        }
        $tbl = $tr_h . $tr_d;

        return $tbl;
    }

    public function renderCheckAnswer( $res_id, $content, $answers_results ) {
        $tbl = '';
        $type = $content['header']['type'];
        $answers_true = $content['content']['answer'];
        switch( $type ) {
            case 'single_choice' :
            case 'multiple_choice' :
                $tr_h = '';
                $tr_d = '';
                $i = 0;
                $answers = array();
                foreach( $answers_true as $ans ) {
                    foreach( $answers_results as $result ) {
                        $t_answers = explode( ',', $result );
                        foreach($t_answers as $answ ) {
                            $q = 'q'.$res_id.'_a';
                            $k = substr($answ, strlen($q));
                            if( $i == $k ) {
                                $correct = "answer-incorrect";
                                $class = 'glyphicon glyphicon-remove-sign';
                                $clr = '#f00;';
                                $answers[$answ]['class'] = 'choice-wrong-radio';
                                $answers[$answ]['value'] = $ans['value'];
                                if( isset( $ans['true'] ) ) {
                                    $correct = "answer-correct";
                                    $class = 'glyphicon glyphicon-ok-sign';
                                    $clr = '#0f0;';
                                    $answers[$answ]['class'] = 'choice-correct-radio';
                                    $answers[$answ]['value'] = $ans['value'];
                                } elseif( $ans['value'] > 0 ) {
                                    $correct = "answer-correct";
                                    $class = 'glyphicon glyphicon-ok-sign';
                                    $clr = '#0f0;';
                                    $answers[$answ]['class'] = 'choice-correct-radio';
                                    $answers[$answ]['value'] = $ans['value'];
                                }
                                $tr_d .= '<div class="'.$correct.'"><span class="'.$class.'" style="color: '.$clr.'; font-size: 40px; font-family: Glyphicons Halflings;"></span><span style="position: relative;top: -10px;margin: 10px;">'.$ans['label'].': '.$ans['feedback'].'</span></div>';
//                                $tr_d .= '<tr><td><span class="'.$class.'" style="color: '.$clr.'; font-size: 40px;"></span></td><td>'.$ans['label'].'</td><td> : '.$ans['feedback'].'</td></tr>';
                            }
                        }
                    }
                    $i++;
                }
                break;
            case 'fill_in_the_blank' :
                $tr_d = '';
                $i = 1;
                $answers = array();
                foreach( $answers_true as $key => $ans ) {
                    $true = '';
                    foreach( $answers_results as $akey => $result ) {
//                        $answers = explode( ',', $result );
                        $tmp_answ = explode('=:', $akey); 
                        $q = 'q'.$res_id.'_blank';
                        $k = substr($tmp_answ[0], strlen($q));

                        if( $key == $k ) {
                            if( trim($result) == '' ) {
                                $correct = "answer-incorrect";
                                $class = 'glyphicon glyphicon-remove-sign';
                                $clr = '#f00;';
                                $answers[$tmp_answ[0]]['class'] = 'choice-true';
                                $answers[$tmp_answ[0]]['value'] = '';
                            } elseif( strtolower(trim($ans['label'])) == strtolower(trim($result)) ) {
                                $correct = "answer-correct";
                                $class = 'glyphicon glyphicon-ok-sign';
                                $clr = '#0f0;';
                                $answers[$tmp_answ[0]]['class'] = 'choice-correct';
                                $answers[$tmp_answ[0]]['value'] = $ans['value'];
                            } else {
                                $correct = "answer-incorrect";
                                $class = 'glyphicon glyphicon-remove-sign';
                                $clr = '#f00;';
                                $answers[$tmp_answ[0]]['class'] = 'choice-wrong';
                                $answers[$tmp_answ[0]]['value'] = '';
                            }
                            $tr_d .= '<div class="'.$correct.'"><span class="'.$class.'" style="color: '.$clr.'; font-size: 40px; font-family: Glyphicons Halflings;"></span><span style="position: relative;top: -10px;margin: 10px;">'.$ans['label'].': '.$ans['feedback'].'</span></div>';
                        }
                    }
                    $i++;
                }
                break;
            case 'mark_the_words' :
                $tr_d = '';
                $pos = array();
                $i = 0;
                $answers = array();

                foreach( $answers_true as $key => $ans ) {
                    $true = '';
                    $arr[$i] = 0;
                    if( in_array( 'w'.$ans['position'], $answers_results ) ) {
                        $correct = "answer-correct";
                        $class = 'glyphicon glyphicon-ok-sign';
                        $clr = '#0f0;';
                        $answers['q'.$res_id.'w'.$ans['position']]['class'] = 'choice-correct';
                        $answers['q'.$res_id.'w'.$ans['position']]['value'] = $ans['value'];
                        $tr_d .= '<div class="'.$correct.'"><span class="'.$class.'" style="color: '.$clr.'; font-size: 40px; font-family: Glyphicons Halflings;"></span><span style="position: relative;top: -10px;margin: 10px;">'.$ans['label'].': '.$ans['feedback'].'</span></div>';
                    } else {
                        $correct = "answer-true";
                        $class = 'glyphicon glyphicon-remove-sign';
                        $clr = '#f00;';
                        $answers['q'.$res_id.'w'.$ans['position']]['class'] = 'choice-true';
                        $answers['q'.$res_id.'w'.$ans['position']]['value'] = '';
                    }
//                    $tr_d .= '<tr><td><span style="color: '.$clr.'">'.$true.'</span></td><td>'.$ans['label'].'</td><td> : '.$ans['feedback'].'</td></tr>';
                    $pos[] = 'w'.$ans['position'];
                }
                foreach( $answers_results as $result ) {
                    $wrong = 0;
                    if( !empty($result) && !in_array( $result, $pos ) ) {
                        $position = intval( substr( $result, 1));
                        $correct = "answer-incorrect";
                        $class = 'glyphicon glyphicon-remove-sign';
                        $clr = '#f00;';
                        $answers['q'.$res_id.'w'.$position]['class'] = 'choice-wrong';
                        $answers['q'.$res_id.'w'.$position]['value'] = '';
                        $tr_d .= '<div class="'.$correct.'"><span class="'.$class.'" style="color: '.$clr.'; font-size: 40px; font-family: Glyphicons Halflings;"></span><span style="position: relative;top: -10px;margin: 10px;">'.$ans['label'].': '.$ans['feedback'].'</span></div>';
                    }
                }

                break;
        }
        $tbl = $tr_h . $tr_d;
        $output['html'] = $tbl;
        $output['answers'] = $answers;
//echo '<pre>';var_dump( $output );die;
        return $output;
//        return $tbl;
    }

    public function reportCheckAnswer( $res_id, $content, $answers_results ) {
        $tbl = '';
        $type = $content['header']['type'];
        $answers_true = $content['content']['answer'];
        switch( $type ) {
            case 'single_choice' :
            case 'multiple_choice' :
                $tr_h = '';
                $tr_d = '';
                $i = 0;
                $answers = array();
                foreach( $answers_true as $ans ) {
                    foreach( $answers_results as $result ) {
                        $t_answers = explode( ',', $result );
                        foreach($t_answers as $answ ) {
                            $q = 'q'.$res_id.'_a';
                            $k = substr($answ, strlen($q));
                            if( $i == $k ) {
                                $class = 'glyphicon glyphicon-remove-sign';
                                $clr = '#f00;';
                                if( isset( $ans['true'] ) ) {
                                    $class = 'glyphicon glyphicon-ok-sign';
                                    $clr = '#0f0;';
                                } elseif( $ans['value'] > 0 ) {
                                    $class = 'glyphicon glyphicon-ok-sign';
                                    $clr = '#0f0;';
                                }
                                $tr_d .= "<p style='margin-bottom: 0;'><span class='".$class."' style='color: ".$clr." !important;'></span><span style='margin: 10px;'>".$ans['label']."</span></p>";
                            }
                        }
                    }
                    $i++;
                }
                break;
            case 'fill_in_the_blank' :
                $tr_d = '';
                $i = 1;
                $answers = array();
//echo '<pre>';var_dump( $answers_true );//die;
//echo '<pre>';var_dump( $answers_results );die;
                foreach( $answers_true as $key => $ans ) {
                    $true = '';
                    foreach( $answers_results as $akey => $result ) {
//                        $answers = explode( ',', $result );
//                        $tmp_answ = explode('=:', $akey); 
                        $tmp_answ = explode('=:', $result); 
                        $q = 'q'.$res_id.'_blank';
                        $k = substr($tmp_answ[0], strlen($q));

//echo '<pre>';var_dump( $tmp_answ );//die;
//echo '<pre>';var_dump( $k );//die;
                        if( $key == $k ) {
                            if( trim($result) == '' ) {
                                $class = 'glyphicon glyphicon-remove-sign';
                                $clr = '#f00;';
                            } elseif( strtolower(trim($ans['label'])) == strtolower(trim($result)) ) {
                                $class = 'glyphicon glyphicon-ok-sign';
                                $clr = '#0f0;';
                            } else {
                                $class = 'glyphicon glyphicon-remove-sign';
                                $clr = '#f00;';
                            }
                            $tr_d .= "<p style='margin-bottom: 0;'><span class='".$class."' style='color: ".$clr." !important;'></span><span style='margin: 10px;'>".$tmp_answ[1]."</span></p>";
                        }
                    }
                    $i++;
                }
//echo '<pre>';var_dump( $answers_true );//die;
//echo '<pre>';var_dump( $answers_results );die;

                break;
            case 'mark_the_words' :
                $tr_d = '';
                $pos = array();
                $labels = array();
                $i = 0;
                $answers = array();

                $arr_txt = str_replace( array( "\n" ), ' ', $content['content']['target']);
                $arr_txt = explode(' ', $arr_txt);
                $i = 0;
                foreach( $arr_txt as $txt ) {
                    $rtxt = str_replace( array('[',']',',','.',':','?','!'), '', $txt );
                    $labels['w'.$i] = $rtxt;
                    $i++;
                }
                foreach( $answers_true as $key => $ans ) {
                    $pos[] = 'w'.$ans['position'];
                }
                foreach( $answers_results as $result ) {
                    if( !empty($result) ) {
                        if( !in_array( $result, $pos ) ) {
                            $class = 'glyphicon glyphicon-remove-sign';
                            $clr = '#f00;';
                        } else {
                            $class = 'glyphicon glyphicon-ok-sign';
                            $clr = '#0f0;';
                        }
                        $tr_d .= "<p style='margin-bottom: 0;'><span class='".$class."' style='color: ".$clr." !important;'></span><span style='margin: 10px;'>".$labels[$result]."</span></p>";
                    }
                }
                break;
        }
        $tbl = $tr_h . $tr_d;
        $output['html'] = $tbl;
        $output['answers'] = $answers;
//echo '<pre>';var_dump( $output );die;
        return $output;
//        return $tbl;
    }


}
