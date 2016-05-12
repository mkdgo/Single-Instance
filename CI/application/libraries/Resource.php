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

        $filename = $action.'body_'.$this->_type.'.php';
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
                <div style="text-align: center;"><a href="javascript:;" onclick="refreshTableAnswer($(\'.tbl_'.$resource->id.'\'), $(\'.form_'.$resource->id.'\'))" class="green_btn">UPDATE RESULTS</a></div>
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
                    <table class="tbl_'.$resource->id.' tbl_results" onclick="return false;" rel='.$resource->id.' style="margin: 0 auto 20px; width: auto;" cellpadding="10">'.$table.'</table>
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
                    <table class="tbl_'.$resource->id.' tbl_results" onclick="showResult('.$resource->id.')" rel='.$resource->id.' style="margin: 0 auto 20px; width: auto;" cellpadding="10">'.$table.'</table>
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
                    <input type="checkbox" id="file_uploaded_f"  value="'.$img.'" disabled="disabled" checked="checked">
                    <label for="file_uploaded_f" id="file_uploaded_label" style="height: 39px;width:auto!important;float: left" >'.$view.'</label>
                </div>';
        } else {
            $html_img = '<div class="c2_radios upload_box" style="float: left;margin: 10px;display: none;">
                    <input type="checkbox" id="file_uploaded_f"  value="" disabled="disabled" checked="checked">
                    <label for="file_uploaded_f" id="file_uploaded_label" style="height: 39px;width:auto!important;float: left" ></label>
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
            $this->_html = str_replace( '[TEXT]', $txt, $this->_html );
        } else {
            $this->_html = str_replace( '[TEXT]', '', $this->_html );
        }
    }

    private function _setQuestion() {
        $q = $this->_content['question'];
        if( $q != '' ) {
            $this->_html = str_replace( '[QUESTION]', $q, $this->_html );
        }
    }

    private function _setBehavior() {
        $q = $this->_content['behavior'];
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
                    if( $answer['true'] ) {
                        $sel = ' checked="checked"';
                    } else {
                        $sel = '';
                    }
                    $html_answer .= '<div class="option row" style="margin-left: 0; margin-right: 0; margin-bottom:10px;">
                        <input onclick="setCheck(this)" class="col-lg-1 col-md-1 col-sm-1 col-xs-12" type="checkbox" name="content[answer]['.$i.'][true]" id="answer_true_'.$i.'" value="1" '.$sel.' style="width: 9%; float: left;" >
                        <label class="col-lg-1 col-md-1 col-sm-1 col-xs-12" for="answer_true_'.$i.'" style="padding-top: 17px; padding-bottom: 17px; width: 11%; float: left;" > true</label>
                        <input class="col-lg-3 col-md-3 col-sm-3 col-xs-12" type="text" name="content[answer]['.$i.'][label]" id="answer_label_'.$i.'" data-validation-required-message="Please fill Label" placeholder="Option" value="'.$answer['label'].'" style="width: 24%; float: left;" />
                        <input class="col-lg-2 col-md-2 col-sm-2 col-xs-12" type="text" name="content[answer]['.$i.'][value]" id="answer_value_'.$i.'" data-validation-required-message="Please fill Evaluation" placeholder="Score" value="'.$answer['value'].'" style="width: 10%; float: left; margin-top: 0;" />
                        <input class="col-lg-5 col-md-5 col-sm-5 col-xs-12 fb" type="text" name="content[answer]['.$i.'][feedback]" id="answer_feedback_'.$i.'" data-validation-required-message="Please fill Evaluation" placeholder="Automated Feedback" value="'.$answer['feedback'].'" style="width: 50%; float: left; margin-top: 0;" />
                        <span class="" id="answer_delete_'.$i.'" style=" float: right; " ><a class="delete2" href="javascript:removeOption('.$i.')" style="color: #e74c3c;display: inline-block; margin-top: 18px; width: 24px; height: 24px; margin-left: 3px; background: url(/img/Deleteicon_new.png) no-repeat 0 0;"></a></span>
                    </div>';
                    $i++;
                }
                $this->_html = str_replace( '[ANSWERS]', $html_answer, $this->_html );
                break;
            case 'multiple_choice' :
                foreach( $this->_answers as $answer ) {
                    if( $answer['true'] ) {
                        $sel = ' checked="checked"';
                    } else {
                        $sel = '';
                    }
                    $html_answer .= '<div class="option row" style="margin-left: 0; margin-right: 0; margin-bottom:10px;">
                        <input onclick="setCheck(this)" class="col-lg-1 col-md-1 col-sm-1 col-xs-12" type="checkbox" name="content[answer]['.$i.'][true]" id="answer_true_'.$i.'" value="1" '.$sel.' style="width: 9%; float: left;" >
                        <label class="col-lg-1 col-md-1 col-sm-1 col-xs-12" for="answer_true_'.$i.'" style="padding-top: 17px; padding-bottom: 17px; width: 11%; float: left;" > true</label>
                        <input class="col-lg-3 col-md-3 col-sm-3 col-xs-12" type="text" name="content[answer]['.$i.'][label]" id="answer_label_'.$i.'" data-validation-required-message="Please fill Label" placeholder="Option" value="'.$answer['label'].'" style="width: 24%; float: left;" />
                        <input class="col-lg-2 col-md-2 col-sm-2 col-xs-12" type="text" name="content[answer]['.$i.'][value]" id="answer_value_'.$i.'" data-validation-required-message="Please fill Evaluation" placeholder="Score" value="'.$answer['value'].'" style="width: 10%; float: left; margin-top: 0;" />
                        <input class="col-lg-5 col-md-5 col-sm-5 col-xs-12 fb" type="text" name="content[answer]['.$i.'][feedback]" id="answer_feedback_'.$i.'" data-validation-required-message="Please fill Evaluation" placeholder="Automated Feedback" value="'.$answer['feedback'].'" style="width: 50%; float: left; margin-top: 0;" />
                        <span class="" id="answer_delete_'.$i.'" style=" float: right; " ><a class="delete2" href="javascript:removeOption('.$i.')" style="color: #e74c3c;display: inline-block; margin-top: 18px; width: 24px; height: 24px; margin-left: 3px; background: url(/img/Deleteicon_new.png) no-repeat 0 0;"></a></span>
                    </div>';
                    $i++;
                }
                $this->_html = str_replace( '[ANSWERS]', $html_answer, $this->_html );
                break;
            case 'fill_in_the_blank' :
                $ca = count($this->_answers);
/*                $html_answer = '<div>
                    <span style="float: left; margin-right: 10px; width: 8%">&nbsp;</span>
                    <span class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="text-align: center; width: 27%;">Correct Text</span>
                    <span class="col-lg-1 col-md-1 col-sm-1 col-xs-12" style="text-align: center; width: 10%;">Score</span>
                    <span class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: center; width: 48%;">Feedback</span>
                    </div>';*/
                if( $ca > 0 ) {
                    $a = 0;
                    $id = $this->_res_id;
                    $html_ans = '';
                    $txt = $this->_content['target'];
                    foreach( $this->_answers as $answer ) {
/*                        $html_answer .= '<div class="option row" style="margin-left: 0; margin-right: 0; margin-bottom:10px;">
                            <span style="float: left; margin-right: 10px;padding: 16px 0;line-height: 28px; width: 8%">[blank'.($a+1).']</span>
                            <input class="col-lg-4 col-md-4 col-sm-4 col-xs-12" type="text" name="content[answer]['.($a+1).'][label]" id="answer_label_'.($a+1).'" data-validation-required-message="" placeholder="Label" value="'.$answer['label'].'" style="width: 27%; float: left;">
                            <input class="col-lg-1 col-md-1 col-sm-1 col-xs-12" type="text" name="content[answer]['.($a+1).'][value]" id="answer_value_'.($a+1).'" data-validation-required-message="" placeholder="Evaluation" value="'.$answer['value'].'" style="width: 10%; float: left; margin-top: 0;">
                            <input class="col-lg-6 col-md-6 col-sm-6 col-xs-12" type="text" name="content[answer]['.($a+1).'][feedback]" id="answer_feedback_'.($a+1).'" data-validation-required-message="" placeholder="Feedback" value="'.$answer['feedback'].'" style="width: 48%; float: left; margin-top: 0;">
                            <span class="" id="answer_delete_'.($a+1).'" style=" float: right; " ><a class="delete2" href="javascript:removeOption('.($a+1).')" style="color: #e74c3c;display: inline-block; margin-top: 18px; width: 24px; height: 24px; margin-left: 3px; background: url(/img/Deleteicon_new.png) no-repeat 0 0;"></a></span>
                            </div>';*/
                        $a++;
//                    }
//                    $this->_html = str_replace( '[ANSWERS]', trim( $html_answer ), $this->_html );
/*                }
                if( $ca > 0 ) {*/
//                    for( $i = 0; $i < $ca; $i++ ) {
//                        $txt1 = str_replace( '[blank'.($i+1).']', '<input type="text" name="answer[q'.$id.'_blank'.($i+1).']" id="q'.$id.'_blank'.($i+1).'" value="" style="width:100px;display: inline-block;padding:0px;"/>', $txt );
                        $txt1 = str_replace( '['.$answer['label'].']', '<input type="text" name="answer[q'.$id.'_blank'.($a+1).']" id="q'.$id.'_blank'.($a+1).'" value="" style="width:100px;display: inline-block;padding:0px;"/>', $txt );
                        $txt = $txt1;
                    }
                    $html_preview = $txt;
                    $this->_html = str_replace( '[PREVIEW]', trim( $html_preview ), $this->_html );
                    $this->_html = str_replace( '[ANSWERS]', trim( $html_answer ), $this->_html );
//echo '<pre>';var_dump( $this->_answers );die;
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
//echo '<pre>';var_dump( $this->_answers );//die;
//echo '<pre>';var_dump( $this->_body );//die;
//echo '<pre>';var_dump( $this->_html );die;
//echo '<pre>';var_dump( $this->_html );die;
//echo '<pre>';var_dump( $this->_html );die;
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
                        $html_ans .= '<input type="radio" name="answer[q'.$id.']" id="q'.$id.'_a'.$i.'" value="q'.$id.'_a'.$i.'">';
                        $html_ans .= '<label for="q'.$id.'_a'.$i.'" >'.$ans['label'].'</label>';
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
                        $html_ans .= '<input type="checkbox" name="answer[q'.$id.'_a'.$i.']" id="q'.$id.'_a'.$i.'" value="q'.$id.'_a'.$i.'">';
                        $html_ans .= '<label for="q'.$id.'_a'.$i.'" >'.$ans['label'].'</label>';
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
//                        $txt1 = str_replace( '[blank'.($i+1).']', '<input type="text" name="answer[q'.$id.'_blank'.($i+1).']" id="q'.$id.'_blank'.($i+1).'" value="" style="width:100px;display: inline-block;padding:0px;"/>', $txt );
                        $txt1 = str_replace( '['.$answers[$i+1]['label'].']', '<input type="text" name="answer[q'.$id.'_blank'.($i+1).']" id="q'.$id.'_blank'.($i+1).'" value="" style="width:100px;display: inline-block;padding:0px;"/>', $txt );
                        $txt = $txt1;
                    }
                    $html_ans = $txt;
                    $this->_html = str_replace( '[ANSWERS]', $html_ans, $this->_html );
                }
                break;
            case 'mark_the_words' :
                $ca = count($answers);
                $arr_txt = explode(' ', $this->_content['target']);
                $i = 0;
                foreach( $arr_txt as $txt ) {
                    $_id = 'q'.$this->_res_id.'_w'.$i;
                    $_txt[$i] = '<span id="q'.$this->_res_id.'w'.$i.'" class="ans" onclick="setAnswer($(this), \''.$_id.'\', '.$this->_res_id.' );" style="cursor: pointer;" rel="0">'.$txt.'<input type="hidden" name="answer[]" id="'.$_id.'" rel="w'.$i.'" value=""/></span>';
                    $i++;
                }
                $str_txt = implode(' ', $_txt );

                if( $ca > 0 ) {
                    $id = $this->_res_id;
                    $html_ans = '';
                    for( $i = 0; $i < $ca; $i++ ) {
//                        $txt1 = str_replace( '[word'.($i+1).']', $answers[$i+1]['label'], $str_txt );
//                        $str_txt = $txt1;
                        $txt1 = str_replace( '[', '', $str_txt );
                        $str_txt = $txt1;
                        $txt1 = str_replace( ']', '', $str_txt );
                        $str_txt = $txt1;
                    }
                    $str_txt .= '<span id="'.'q'.$this->_res_id.'_c'.'" rel="'.$ca.'" num="0"></span>';
                    $html_ans = $str_txt;
                    $this->_html = str_replace( '[ANSWERS]', $html_ans, $this->_html );
                }
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

    public function renderResultToJson($res_id, $content, $answers_results) {
        $tbl = '';
        $type = $content['header']['type'];
        $answers_true = $content['content']['answer'];

        switch( $type ) {
            /*
            case 'single_choice' :
                $arr_ans = array();
                $arr_ans['cols'][0]['type'] = 'string';
                $arr_ans['cols'][0]['value'] = 'answers';
                $arr_ans['rows'][0][0] = 'answers';
                $i = 1;
                foreach( $answers_true as $ans ) {
                    $arr_ans['cols'][$i]['type'] = 'number';
                    $arr_ans['cols'][$i]['value'] = $ans['label'];
                    $i++;
                }
                if( count($answers_results) > 0 ) {
                    for( $a = 0; $a < count($answers_results); $a++ ) {
                        for( $c = 0; $c < (count( $answers_true )); $c++ ) {
                            $arr_ans['rows'][0][$c+1] = 0;
                        }
                    }
                } else {
                    for( $c = 0; $c < (count( $answers_true )); $c++ ) {
                        $arr_ans['rows'][0][$c+1] = 0;
                    }
                }
                foreach( $answers_results as $result ) {
                    $answers = explode( ',', $result->answers );

                    $r = 0;
                    foreach($answers as $answ ) {
                        $arr_ans['rows'][$r][0] = 'answers';
                        $q = 'q'.$res_id.'_a';
                        $k = substr($answ, strlen($q));
                        $b = $k+1;
                        $arr_ans['rows'][0][$b] += 1;
                        $r++;
                    }
                }
                break;*/
            case 'single_choice' :
                $arr_ans = array();
                $arr_ans['cols'][0]['type'] = 'string';
                $arr_ans['cols'][0]['value'] = 'Option';
                $arr_ans['cols'][1]['type'] = 'number';
                $arr_ans['cols'][1]['value'] = 'Answers';

                //if no one has submitted answers for these options
                if( count($answers_results) > 0 ) {
                    for( $a = 0; $a < count($answers_results); $a++ ) {
                        for( $c = 0; $c < (count( $answers_true )); $c++ ) {
                            $arr_ans['rows'][$c+1][0] = 0;
                            //$arr_ans['rows'][0][$c+1] = $answers_true['label'];
                            //$arr_ans['rows'][0][$answers_true['label']] = 0;
                        }
                    }
                } else {
                    for( $c = 0; $c < (count( $answers_true )); $c++ ) {
                        $arr_ans['rows'][0][$c+1] = 0;
                    }
                }
                /*
                $i = 0;
                foreach( $answers_true as $ans ) {
                    $arr_ans['rows'][$i][0] = $ans['label'];
                    //$arr_ans['rows'][$i][1] = $ans['label'];
                    $i++;
                }
                */
                foreach( $answers_results as $result ) {
                    $answers = explode( ',', $result->answers );
                    $r = 0;
                    foreach($answers as $answ ) {
                        //$arr_ans['rows'][$r][0] = 'answers';
                        $arr_ans['rows'][$r][0] = 'answers';
                        $q = 'q'.$res_id.'_a';
                        $k = substr($answ, strlen($q));
                        $b = $k+1;
                        $arr_ans['rows'][$r][$b] += 1;
                        $r++;
                    }
                }
                break;    
            case 'multiple_choice' :
                $arr_ans = array();
                $arr_ans['cols'][0]['type'] = 'string';
                $arr_ans['cols'][0]['value'] = 'answers';
                $i = 1;
                foreach( $answers_true as $ans ) {
                    $arr_ans['cols'][$i]['type'] = 'number';
                    $arr_ans['cols'][$i]['value'] = $ans['label'];
                    $i++;
                }
                if( count($answers_results) > 0 ) {
                    for( $c = 0; $c < (count( $answers_true )); $c++ ) {
                        for( $a = 0; $a < count($answers_results); $a++ ) {
                            $arr_ans['rows'][$a][0] = ' ';
                            $arr_ans['rows'][$a][$c+1] = 0;
                        }
                    }
                } else {
                    for( $c = 0; $c < (count( $answers_true )); $c++ ) {
                        $arr_ans['rows'][0][0] = ' ';
                        $arr_ans['rows'][0][$c+1] = 0;
                    }
                }
                foreach( $answers_results as $result ) {
                    $answers = explode( ',', $result->answers );
                    $r = 0;
                    foreach($answers as $answ ) {
                        $arr_ans['rows'][$r][0] = ' ';
                        $q = 'q'.$res_id.'_a';
                        $k = substr($answ, strlen($q));
                        $b = $k+1;
                        $arr_ans['rows'][$r][$b] += 1;
                        $r++;
                    }
                }
                break;
            case 'fill_in_the_blank' :
                $arr_ans = array();
                $arr_ans['cols'][0]['type'] = 'string';
                $arr_ans['cols'][0]['value'] = 'answers';
                $i = 1;
                $tmp_k = array();
                foreach( $answers_true as $key => $ans ) {
                    $arr_ans['cols'][$i]['type'] = 'number';
                    $arr_ans['cols'][$i]['value'] = $ans['label'];
                    $i++;
                }
                if( count($answers_results) > 0 ) {
                    for( $c = 0; $c < (count( $answers_true )); $c++ ) {
                        for( $a = 0; $a < count($answers_results); $a++ ) {
                            $arr_ans['rows'][$a][0] = ' ';
                            $arr_ans['rows'][$a][$c+1] = 0;
                        }
                    }
                } else {
                    for( $c = 0; $c < (count( $answers_true )); $c++ ) {
                        $arr_ans['rows'][0][0] = ' ';
                        $arr_ans['rows'][0][$c+1] = 0;
                    }
                }
                $r = 0;
                foreach( $answers_results as $result ) {
                    $answers = explode( ',', $result->answers );
                    foreach($answers as $answ ) {
//echo '<pre>';var_dump( $arr_ans['rows'] );
                        $arr_ans['rows'][$r][0] = ' ';
                        $tmp_answ = explode('=:', $answ); 
                        $q = 'q'.$res_id.'_blank';
                        $k = substr($tmp_answ[0], strlen($q));
                        $b = $k;
                        if( strtolower(trim($arr_ans['cols'][$r+1]['value'])) == strtolower(trim($tmp_answ[1])) ) {
                            $arr_ans['rows'][$r][$b] += 1;
                        }
//echo '<pre>';var_dump( $arr_ans['rows'] );
                    }
                    $r++;
//echo '<pre>';var_dump( $arr_ans['rows'] );
//die;
//echo '<pre>';var_dump(  $arr_ans['rows'] );
                }
                break;
            case 'mark_the_words' :
                $arr_ans = array();
                $arr_ans['cols'][0]['type'] = 'string';
                $arr_ans['cols'][0]['value'] = ' ';
                $pos = array();
                $i = 1;
                foreach( $answers_true as $key => $ans ) {
                    $arr_ans['cols'][$i]['type'] = 'number';
                    $arr_ans['cols'][$i]['value'] = $ans['label'];
                    $i++;
                }
                if( count($answers_results) > 0 ) {
                    for( $c = 0; $c < (count( $answers_true )); $c++ ) {
                        for( $a = 0; $a < count($answers_results); $a++ ) {
                            $arr_ans['rows'][$a][0] = ' ';
                            $arr_ans['rows'][$a][$c+1] = 0;
                        }
                    }
                } else {
                    for( $c = 0; $c < (count( $answers_true )); $c++ ) {
                        $arr_ans['rows'][0][0] = ' ';
                        $arr_ans['rows'][0][$c+1] = 0;
                    }
                }
                $at = 1;
                foreach( $answers_true as $key => $ans ) {
                    $r = 0;
                    foreach( $answers_results as $result ) {
                        $answers = explode( ',', $result->answers );

                        if( in_array( 'w'.$ans['position'], $answers ) ) {
                            $arr_ans['rows'][$r][$at] += 1;
                        }
                        $r++;
                    }
                    $at++;
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
                foreach( $answers_true as $ans ) {
                    foreach( $answers_results as $result ) {
                        $answers = explode( ',', $result );
                        foreach($answers as $answ ) {
                            $q = 'q'.$res_id.'_a';
                            $k = substr($answ, strlen($q));
                            if( $i == $k ) {
                                $true = 'false';
                                $clr = '#f00;';
                                if( isset( $ans['true'] ) ) {
                                    $true = 'true';
                                    $clr = '#099a4d;';
                                } elseif( $ans['value'] > 0 ) {
                                    $true = 'true';
                                    $clr = '#099a4d;';
                                }
                                $tr_d .= '<tr><td><span style="color: '.$clr.'">'.$true.'</span></td><td>'.$ans['label'].'</td><td> : '.$ans['feedback'].'</td></tr>';
                            }
                        }
                    }
                    $i++;
                }
                break;
            case 'fill_in_the_blank' :
                $tr_d = '';
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
                                $true = 'empty';
                                $clr = '#f00;';
                            } elseif( strtolower(trim($ans['label'])) == strtolower(trim($result)) ) {
                                $true = 'true';
                                $clr = '#099a4d;';
                            } else {
                                $true = 'false';
                                $clr = '#f00;';
                            }
                            $tr_d .= '<tr><td><span style="color: '.$clr.'">'.$true.'</span></td><td>'.$result.'</td><td> = '.$ans['label'].'</td><td> : '.$ans['feedback'].'</td></tr>';
                        }
                    }
                    $i++;
                }
                break;
            case 'mark_the_words' :
                $tr_d = '';
                $pos = array();
                $i = 0;
                foreach( $answers_true as $key => $ans ) {
                    $true = '';
                    $arr[$i] = 0;
                    if( in_array( 'w'.$ans['position'], $answers_results ) ) {
                        $true = 'true';
                        $clr = '#099a4d;';
                    } else {
                        $true = 'not marked';
                        $clr = '#f00;';
                    }
                    $tr_d .= '<tr><td><span style="color: '.$clr.'">'.$true.'</span></td><td>'.$ans['label'].'</td><td> : '.$ans['feedback'].'</td></tr>';
                    $pos[] = 'w'.$ans['position'];
                }
                foreach( $answers_results as $result ) {
                    $wrong = 0;
                    if( !empty($result) && !in_array( $result, $pos ) ) {
                        $wrong = 'wrong marked';
                        $clr = '#f00;';
//                        $tr_d .= '<tr><td><span style="color: '.$clr.'">'.$wrong.'</span></td><td></td><td></td></tr>';
                    }
                }
                break;
        }
        $tbl = $tr_h . $tr_d;

        return $tbl;
    }


}
