<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resource {

    private $_head = array();
    private $_content;
    private $_info = array();

    private $_res_id;
    private $_res;
    private $_html;
    private $_intro;
    private $_body;
    public $_xml;
    public $_resource_types = array();

    public function __construct() {
//        $this->ci =& get_instance();
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

    public function renderTypes() {
        $show_types = '';
        foreach( $this->_resource_types as $key => $val ) {
//            $show_types .= '<input id="'.$key.'" type="radio" name="header[type]" value="'.$key.'" /><label for="">'.$val.'</label>';
            $show_types .= '<option value="'.$key.'">'.$val.'</option>';
        }
        return $show_types;
    }

    public function renderBody($action = 'create', $type = 'local_file', $resource = null ) {

        if( $resource ) {
            $this->_res_id = $resource->id;
//echo $resource->type;die;
            $this->_type = $resource->type;
            $this->_res = json_decode( $resource->content, true );
        } else {
            $this->_res_id = '';
            $this->_type = $type;
            $this->_res = null;
        }

        $filename = $action.'body_'.$this->_type.'.php';
        $file = APPPATH."libraries/Resource/$filename";
        switch( $action ) {
            case 'create' : $myvar = $this->_create($file);
                break;
            case 'edit' : $myvar = $this->_edit($file, $resource);
                break;
            case 'show' : $myvar = $this->_show($file);
                break;
        }
        return $myvar;
    }

    public function renderShowTeacherForm( $resource, $user_id ) {
//echo '<pre>';var_dump( $resource );die;
        $content = $this->renderBody( 'show', $resource->type, $resource );
        $table = '';
        $html_form = '<div id="' . $resource->id  . '" class="container">
    <form class="form-horizontal form_' . $resource->id  . '" id="form_' . $resource->id  . '" name="form_' . $resource->id  . '" method="post" action="">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'.$content.'</div>
        </div>
        <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; padding-top:20px; padding-bottom: 30px;">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <label for="" class="scaled"></label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div style="text-align: left;"><a href="javascript:;" onclick="refreshTableAnswer($(\'.tbl_'.$resource->id.'\'), $(\'.form_'.$resource->id.'\'))" class="green_btn">Refresh Results</a></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; ">
                    <table class="tbl_'.$resource->id.' tbl_results" rel='.$resource->id.' style="margin: 0 auto 20px; width: auto;" cellpadding="10">'.$table.'</table>
                </div>
            </div>
        </div>
    </form>
</div>';
        return $html_form;
    }

    public function renderEditTeacherForm( $resource, $user_id ) {
//echo '<pre>';var_dump( $resource );die;
        $content = $this->renderBody( 'edit', $resource->type, $resource );
        $table = '';
        $html_form = '<div id="' . $resource->id  . '" class="container">
    <form class="form-horizontal form_' . $resource->id  . '" id="form_' . $resource->id  . '" name="form_' . $resource->id  . '" method="post" action="">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'.$content.'</div>
        </div>
<!--        <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; padding-top:20px; padding-bottom: 30px;">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <label for="" class="scaled"></label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div style="text-align: left;"><a href="javascript:;" onclick="refreshTableAnswer($(\'.tbl_'.$resource->id.'\'), $(\'.form_'.$resource->id.'\'))" class="green_btn">Refresh Results</a></div>
            </div>
        </div>-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; ">
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
        $html_form = '<div id="' . $resource->id  . '" class="container">
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
                <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; padding-top:20px; padding-bottom: 30px;">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <label for="" class="scaled"></label>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div style="text-align: left;"><a href="javascript:;" onclick="submitAnswer($(\'.tbl_'.$resource->id.'\'), $(\'#form_'.$resource->id.'\'), this)" class="green_btn submit-answer">Submit</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; ">
                    <table class="tbl_'.$resource->id.' tbl_results" rel='.$resource->id.' style="margin: 0 auto 20px; width: auto;" cellpadding="10">'.$table.'</table>
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
            'lesson_id' => $post_data['lesson_id'],
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
//echo '';var_dump( $resource );die;
        if( file_exists( $file ) ) {
            ob_start();
            include $file;
            $this->_html = ob_get_contents();
            ob_end_clean();
            $this->_setFormName();
            $this->_setIntroImg();
            $this->_setIntroTxt();
            $this->_setQuestion();
            $this->_renderAnswer();
            $this->_setBehavior();
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
            $this->_setIntroImg();
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
        $img = $this->_res['content']['intro']['file'];
        if( $img != '' ) {
            $this->_html = str_replace( '[IMG]', '<img src="/uploads/resources/temp/'.$img.'" style="width: inherit; height: inherit; border: none;" />', $this->_html );
        } else {
            $this->_html = str_replace( '[IMG]', '', $this->_html );
        }
    }

    private function _setIntroTxt() {
        $txt = $this->_res['content']['intro']['text'];
        if( $txt != '' ) {
            $this->_html = str_replace( '[TEXT]', $txt, $this->_html );
        } else {
            $this->_html = str_replace( '[TEXT]', '', $this->_html );
        }
    }

    private function _setQuestion() {
        $q = $this->_res['content']['question'];
        if( $q != '' ) {
            $this->_html = str_replace( '[QUESTION]', $q, $this->_html );
        }
    }

    private function _setBehavior() {
        $q = $this->_res['content']['behavior'];
//var_dump( $q );die;
        if( $q != '' ) {
            $this->_html = str_replace( '[BEHAVIOR]', $q, $this->_html );
        }
    }

    private function _renderAnswer() {
        $answers = $this->_res['content']['answer'];
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
                        $html_ans .= '<p><input type="checkbox" name="answer[q'.$id.'_a'.$i.']" id="q'.$id.'_a'.$i.'" value="q'.$id.'_a'.$i.'">';
                        $html_ans .= '<label for="q'.$id.'_a'.$i.'" >'.$ans['label'].'</label></p>';
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
                    $txt = $this->_res['content']['target'];
                    for( $i = 0; $i < $ca; $i++ ) {
                        $txt1 = str_replace( '[blank'.($i+1).']', '<input type="text" name="answer[q'.$id.'_blank'.($i+1).']" id="q'.$id.'_blank'.($i+1).'" value="" style="width:100px;display: inline-block;padding:0px;"/>', $txt );
                        $txt = $txt1;
                    }
                    $html_ans = $txt;
                    $this->_html = str_replace( '[ANSWERS]', $html_ans, $this->_html );
                }
                break;
            case 'mark_the_words' :
                $ca = count($answers);
//echo '<pre>';var_dump( $this->_res_id );die;
                $arr_txt = explode(' ', $this->_res['content']['target']);
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
                        $txt1 = str_replace( '[word'.($i+1).']', $answers[$i+1]['label'], $str_txt );
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
//echo '<pre>';var_dump( $ans );die;
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
