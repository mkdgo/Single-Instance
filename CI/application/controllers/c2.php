<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require __DIR__.'./../libraries/AES/aes.class.php';
require __DIR__.'./../libraries/AES/aesctr.class.php';

class C2 extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('classes_model');
        $this->load->model('resources_model');
        $this->load->model('keyword_model');
        $this->load->model('search_model');
        $this->load->library('breadcrumbs');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene'); 
    }

    public function index($type = '', $elem_id = '0', $subject_id = '', $module_id = '',  $lesson_id = '', $assessment_id = '') {

        $this->_data['type'] = $type;
        $this->_data['elem_id'] = $elem_id;		
        $this->_data['subject_id'] = $subject_id;
        $this->_data['module_id'] = $module_id;
        $this->_data['lesson_id'] = $lesson_id;
        $this->_data['assessment_id'] = $assessment_id;
        $this->_data['_header']['firstBack'] = 'saveform';
        $this->_data['_header']['secondback'] = '0';
        //	$this->_data['back'] = "/c1/index/{$type}/{$elem_id}" . ($subject_id ? '/' . $subject_id : '') . ($module_id ? '/' . $module_id : '') . ($lesson_id ? '/' . $lesson_id : '') . ($assessment_id ? '/' . $assessment_id : '');


//        $index = Zend_Search_Lucene::open(APPPATH . 'search/index');
//
//		try{
//	        $hits = $index->find($query);
//	    }
//	    catch (Zend_Search_Lucene_Exception $ex) {
//	        $hits = array();
//	    }
//
//
//           $doc = $index->getDocument($subject_id);
//
//
//
//
//    //$doc = $index->getDocument($elem_id);
//    echo '<pre>';
//    print_r($doc);
//    echo '</pre>';
//           foreach ($hits as $hit) {
//    printf("%d  %s\n", $hit->id, $hit->name);
//}

        $resource = $this->resources_model->get_resource_by_id($elem_id);

        if (!empty($resource)) {

            $resource_keywords_ = $this->keyword_model->getResourceKeyword($resource->id);
            $resource_keywords = array();
            
            foreach($resource_keywords_ as $kk=>$vv) {
                $resource_keywords[]=$vv->word;
            }

            $this->_data['saved'] = TRUE;
            $this->_data['resource_exists'] = '<input type="hidden" name="resource_exists" value="'.$resource->resource_name.'" />';
            $this->_data['resource_title'] = $resource->name;
            $this->_data['resource_keywords'] = str_replace('"',"",json_encode($resource_keywords));
            $this->_data['resource_keywords_a'] = str_replace('"',"",json_encode($resource_keywords));
            $this->_data['resource_link'] = $resource->link;
            $this->_data['is_remote'] = $resource->is_remote;
            $this->_data['is_remote_0'] =  $this->_data['is_remote_1'] = '';
            if($resource->is_remote==0)$this->_data['is_remote_0']='checked';else $this->_data['is_remote_1']='checked';
            $this->_data['resource_desc'] = $resource->description;
            $this->_data['year_restriction'] = $this->classes_model->getAllYears();
//            $this->_data['year_restriction'] = $this->classes_model->get_classes_for_teacher($this->session->userdata('id'));
            $this->_data['restricted_to'] = explode(',', $resource->restriction_year);
//
//
//              foreach ($restrictions as $rest)
//           {
//                $this->_data['year_restriction'][$rest['id']]['year'] =$rest['restriction_year'];
//           }
//           print_r($this->_data['year_restriction']);
//
//           die();
            $this->_data['preview'] = $this->resoucePreview($resource, '/c1/resource/');

        } else {

            $this->_data['saved'] = FALSE;
            $this->_data['resource_exists'] = '';
            $this->_data['resource_title'] = '';
            $this->_data['resource_keywords'] = '';
            $this->_data['resource_link'] = '';
            $this->_data['is_remote'] = 1;
            $this->_data['is_remote_1']='checked';
            $this->_data['is_remote_0']='';
            $this->_data['resource_keywords_a'] = json_encode(explode(', ', ''));
            $this->_data['resource_desc'] = '';
            $this->_data['year_restriction'] = array();
            $this->_data['preview'] = '';
            $this->_data['year_restriction'] = $this->classes_model->getAllYears();
//            $this->_data['year_restriction'] = $this->classes_model->get_classes_for_teacher($this->session->userdata('id'));
            $this->_data['restricted_to'] = explode(',', $resource->restriction_year);
           
        }

        $this->_data['classes'] = array();

        //$classes = $resource->restriction_year; 
        
        /*foreach($classes as $key => $value){
        $this->_data['classes'][$value->id]['id'] = $value->id;
        $this->_data['classes'][$value->id]['year'] = $value->year;
        $this->_data['classes'][$value->id]['group_name'] = $value->group_name;
        $this->_data['classes'][$value->id]['checked'] = '';
        }
        /*
        $lesson_classes = $this->lessons_model->get_classes_for_lesson($lesson_id);

        foreach($lesson_classes as $key => $value) {
        $this->_data['classes'][$value->class_id]['checked'] = 'checked';
        }
        */
        $this->breadcrumbs->push('Home', base_url());
        $this->breadcrumbs->push('Resources', '/c1');
        $this->breadcrumbs->push('Add Resource', '/c2');
        $this->_data['breadcrumb'] = $this->breadcrumbs->show();
        $this->_paste_public();
    }

    public function suggestKeywords() {
        $kwq = $this->input->get('q');
        $kwd = Array();

        if(strlen($kwq)>1) {
            $kws = $this->keyword_model->suggestKeywords($kwq);
            foreach($kws as $kk=>$vv) {
                $kwd[]=$vv->word;
            }

            array_unshift($kwd, $kwq);
        }

        echo json_encode($kwd);
        die();
    }

    public function save() {

       // echo '<pre>';
      //  print_r($_POST);
      //  die();

        $this->_data['type'] = $type;
        $this->_data['elem_id'] = $elem_id;		
        $this->_data['subject_id'] = $subject_id;
        $this->_data['module_id'] = $module_id;
        $this->_data['lesson_id'] = $lesson_id;
        $this->_data['assessment_id'] = $assessment_id;

        $type = $this->input->post('type');

        $elem_id = $this->input->post('elem_id');
        $parent_id = $elem_id;
        if( $type != 'resource' && $type != '' ) $elem_id = 0;
        $subject_id = $this->input->post('subject_id');
        $module_id = $this->input->post('module_id');
        $lesson_id = $this->input->post('lesson_id');
        $assessment_id = $this->input->post('assessment_id');

        
        
        if($this->input->post('is_remote') != 1 ) {
            $link='';

            if( $this->input->post('resource_exists') && !isset($_FILES['fileupload']) ) {
                $res_name = $this->input->post('resource_exists');
                $resource_exists = 1;
            } elseif(($_FILES['fileupload']["error"] == 0)) {
                $res_name = $this->resourceUpload();
            } else {
                $res_name = $this->resourceUpload();
            }

            if (!$res_name) {
                return;
            }

            $uploaded_file = $this->config->item('upload_path').$res_name;
            $resource_type = $this->search_model->getFileResourceType($res_name);

        } else {
            $link = $this->input->post('resource_link');
            
           if((substr($link, 0, 7) == 'http://')) {
               $prefix = 'http://';
               $url = explode($prefix, $link);
               $link = $prefix.$url[1];
               
           } else if((substr($link, 0, 8) == 'https://')) {
               $prefix = 'https://';
               $url = explode($prefix, $link);
               $link = $prefix.$url[1];
           } else if((substr($link, 0, 4) == 'www.')) {
               $prefix = 'www.';
               $url = explode($prefix, $link);
               $link = 'http://'.$prefix.$url[1];
           }  else {
              
               $redirect_url = $type.'/'.$elem_id.'/'.$subject_id.'/'.$module_id.'/'.$lesson_id.'/'.$assessment_id;
               $this->session->set_flashdata('error_msg','Resource URL is not valid!');
               redirect(base_url('c2/index/'.$redirect_url));
               //here must set the error message
           }
            
//    if((substr($link, 0, 7) == 'http://') || substr($link, 0, 8) != 'http://') $link = 'http://'.$link;
            $resource_type = $this->search_model->getURLResourceType($link);
            $res_name = '';
        }

        if(count($this->input->post('year_restriction'))>1) {
            $restr = rtrim(implode(',', $this->input->post('year_restriction')), ',');
        } else if($this->input->post('year_restriction')!==false) {
            $restr = $this->input->post('year_restriction');
            $restr = $restr[0];
        } else {
            $restr = '';
        }

        $db_data = array(
            'teacher_id' => $this->session->userdata('id'),
            'is_remote'  => $this->input->post('is_remote'),
            'link'       => $link,
            'resource_name' => $res_name,
            'name' => $this->input->post('resource_title'),
            'keywords' => "",
            'description' => $this->input->post('resource_desc'),			
            'type' => $resource_type[0],
            'restriction_year' => $restr,
        );

         
        if($elem_id > 0) {
            $resource_id = $this->resources_model->save($db_data, $this->input->post('elem_id'));
            $this->delete_document($subject_id);
            
        } else {
            $resource_id = $this->resources_model->save($db_data);
        }

        // Keywords - re-enable here:
        $keywords = trim($this->input->post('resource_keywords'),'[],');
        $keywords = trim($keywords,",");
        //$keywords = str_replace(" ","", $keywords);
        $keywords = str_replace("[,", "", $keywords);
        $keywords = str_replace("]", "", $keywords);

        $db_data['id'] = $resource_id;
        $db_data['uploaded_file'] = $uploaded_file;
        $db_data['keywords']=$keywords;

        $this->keyword_model->updateResourceKeywords($keywords , $resource_id );
         $this->indexFile($db_data);

        if($type!='') {
            redirect("/c1/save/".$resource_id.'/'.$type.'/'.'/'.$subject_id.'/'.$module_id.'/'.$lesson_id.'/'.$assessment_id);
            //$resource_id, $type, $elem_id = '0', $subject_id = '', $module_id = '', $lesson_id = '', $assessment_id = ''
        } else {
            redirect("/c1", 'refresh');
        }
    }

    private function resourceUpload() {
        $key = 'dcrptky@)!$2014dcrpt';

        $this->config->load('upload');

        $this->load->library('upload');

        $CPT_POST = AesCtr::decrypt($this->input->post('fileupload_CPT'), $key, 256);
        $CPT_DATA = explode("::", $CPT_POST);

        // if ($this->upload->do_upload('fileupload')){
        //     $resource_data = $this->upload->data();
        // }

        $dir = $this->config->item('upload_path');
        $funm = explode('.', $_FILES['resource_url']['name']);
        $ext=$funm[count($funm)-1];
        array_pop($funm);
        $NAME=md5(implode('.', $funm)).time().'.'.$ext;

        $uploadfile = $dir.$NAME;

        if(move_uploaded_file($_FILES['resource_url']['tmp_name'], $uploadfile)){

            $NF_NAME = $dir.$NAME.'_tmp';

            rename( $uploadfile, $NF_NAME );

            $img_dataurl = base64_encode(file_get_contents($NF_NAME));

            if($CPT_DATA[0]==1)
            {
                $decrypt = AesCtr::decrypt($img_dataurl, $key, 256);
            }
            else
            {
                $half = $CPT_DATA[1];
                $SZ   = $CPT_DATA[2];
                $CPT_l= $CPT_DATA[3];

                $crypter_middle = substr($img_dataurl, $half-$SZ, $CPT_l);
                $crypter_middle_decr = AesCtr::decrypt($crypter_middle, $key, 256);

                $decrypt = str_replace($crypter_middle, $crypter_middle_decr, $img_dataurl);
            }

            file_put_contents($uploadfile, base64_decode($decrypt) );
            if(is_file($uploadfile))unlink($NF_NAME);

            return $NAME;

        } else {

            //echo $this->upload->display_errors();
            return false;
        }


    }

    
    
    
    public function delete_document($id) {
		$index = Zend_Search_Lucene::open(APPPATH . 'search/index');
		//$hit = $index->getDocument($id);
                //$rid    = $hit->getDocument()->id;
		$index->delete($id);
        }

    
    
    public function indexFile($resource){

        $this->search_model->add_resource($resource);
        return;

    }


    public function delete($resource_id)
    {
        if($this->session->userdata('user_type') == 'teacher')
        {
            $this->config->load('upload');

            $resource = $this->resources_model->get_resource_by_id($resource_id);
            if($resource)
            {
                $dir = $this->config->item('upload_path');

                $file = $dir.$resource->resource_name;
                if(is_file($file))unlink($file);

                $this->resources_model->delete_resource($resource_id);
            }
        } 
        redirect("/c1");
    }

}
?>
