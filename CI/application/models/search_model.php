<?php
class Search_model extends CI_Model {

    public function __construct() {
            
        parent::__construct();
        $this->load->model('resources_model');
        $this->load->model('modules_model');
        $this->load->model('lessons_model');
        $this->load->model('content_page_model');
        $this->load->model('interactive_assessment_model');
        $this->load->model('assignment_model');
        $this->load->model('user_model');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene'); 
        $this->zend->load('Zend/Pdf'); 
        $this->config->load('upload');
        $this->load->library('upload');
    }

	public function add_resource($resource) {
		
            
            
        // Set file location:
        if($resource['is_remote'] != 1){
            $dir = $this->config->item('upload_path');
    		$uploaded_file = $dir.$resource['resource_name']; 
            $resource_type = $this->getFileResourceType($resource['resource_name']);
        }else{
            $resource_type = $this->getURLResourceType($resource['link']);
        }
        
        $index = Zend_Search_Lucene::open(APPPATH . 'search/index');

        if($resource['is_remote'] == 1){
            $doc = Zend_Search_Lucene_Document_Html::loadHTMLFile($resource['link']);
            // Initialise entry with blank values, these can be overwritten with actual data
            $this->init_search_entry($doc);
            $doc->addField(Zend_Search_Lucene_Field::UnStored('contents', $doc->getHTML($resource['link'])));
        }
        elseif($resource_type[0] == 'doc'){

            if($resource_type[1] == 'pdf'){
                $doc = new Zend_Search_Lucene_Document($uploaded_file);
                $this->init_search_entry($doc);
                $doc->addField(Zend_Search_Lucene_Field::UnStored('contents', $uploaded_file));
            }
            elseif($resource_type[1] == 'msword'){
                    $doc = Zend_Search_Lucene_Document_Docx::loadDocxFile($uploaded_file);
                    $this->init_search_entry($doc);
                    $doc->addField(Zend_Search_Lucene_Field::UnStored('contents', $uploaded_file));
            }
            elseif($resource_type[1] == 'text'){
                $doc = new Zend_Search_Lucene_Document($uploaded_file);
                $this->init_search_entry($doc);
                $doc->addField(Zend_Search_Lucene_Field::UnStored('contents', file_get_contents($uploaded_file)));
            }
            elseif($resource_type[1] == 'ms-powerpoint'){
                $doc = Zend_Search_Lucene_Document_Pptx::loadPptxFile($uploaded_file);
                $this->init_search_entry($doc);
                $doc->addField(Zend_Search_Lucene_Field::UnStored('contents', $uploaded_file));
            }
            else{

            }          

        }        
        elseif($resource_type[0] == 'video' || $resource_type[0] == 'image' || $resource_type[0] == 'audio' || $resource_type[0] == 'misc'){
            $doc = new Zend_Search_Lucene_Document();
            $this->init_search_entry($doc);
        }
        else{
            $doc = new Zend_Search_Lucene_Document();
            $this->init_search_entry($doc);
        }

        $doc->addField(Zend_Search_Lucene_Field::Text('link', $resource['link']));
        $doc->addField(Zend_Search_Lucene_Field::Text('resource_name', $resource['resource_name']));
        $doc->addField(Zend_Search_Lucene_Field::Text('name', $resource['name']));
        $doc->addField(Zend_Search_Lucene_Field::Text('type', $resource['type']));
        $doc->addField(Zend_Search_Lucene_Field::Text('teacher_id', $resource['teacher_id']));
        $doc->addField(Zend_Search_Lucene_Field::Text('year_restriction', $resource['restriction_year']));
        //
        $keywords = @str_replace(',',' ',$resource['keywords']);




        $doc->addField(Zend_Search_Lucene_Field::Text('keyword', $keywords));
        // $keywords = json_decode( $resource->resource_keywords_a);
        //if(is_array($keywords)) {
         //   foreach ($keywords as $keyword) {
               // $doc->addField(Zend_Search_Lucene_Field::Keyword('keyword', $keyword));
         //   }
       // }
        $doc->addField(Zend_Search_Lucene_Field::Text('description', $resource['description']));
        $doc->addField(Zend_Search_Lucene_Field::Text('resource_id', $resource['id']));
        $doc->addField(Zend_Search_Lucene_Field::Text('search_type', 'resource'));


        $index->addDocument($doc);
        $index->commit();
        //echo $keywords;

       // die();
    }

    // Search Commands:

    private function init_search_entry($doc){

        $doc->addField(Zend_Search_Lucene_Field::Text('name', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('type', null));
        $doc->addField(Zend_Search_Lucene_Field::UnStored('contents', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('teacher_id', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('description', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('search_type', null));

        // Resource Specific
        $doc->addField(Zend_Search_Lucene_Field::Text('link', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('resource_name', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('resource_id', null));

        // User Specific
        $doc->addField(Zend_Search_Lucene_Field::Text('user_id', null));

        // Module Specific
        $doc->addField(Zend_Search_Lucene_Field::Text('module_id', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('intro', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('objectives', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('teaching_activities', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('assessment_opportunities', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('notes', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('publish', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('active', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('subject_id', null));
        $doc->addField(Zend_Search_Lucene_Field::Text('year_id', null));

    }

    //

    public function add_user($user) {

        $index = Zend_Search_Lucene::open(APPPATH . 'search/index');
        $doc = new Zend_Search_Lucene_Document();
        // Initialise entry with blank values, these can be overwritten with actual data
        $this->init_search_entry($doc);

        $doc->addField(Zend_Search_Lucene_Field::Text('name', $user['first_name'].' '.$user['last_name']));
        $doc->addField(Zend_Search_Lucene_Field::Text('type', $user['user_type']));
        $doc->addField(Zend_Search_Lucene_Field::Text('user_id', $user['id']));
        $doc->addField(Zend_Search_Lucene_Field::Text('search_type', 'user'));

        $index->addDocument($doc);
        $index->commit();

    }

    public function add_module($module) {

        $index = Zend_Search_Lucene::open(APPPATH . 'search/index');
        $doc = new Zend_Search_Lucene_Document();
        // Initialise entry with blank values, these can be overwritten with actual data
        $this->init_search_entry($doc);

        $doc->addField(Zend_Search_Lucene_Field::Text('name', $module['name']));
        $doc->addField(Zend_Search_Lucene_Field::Text('module_id', $module['id']));
        $doc->addField(Zend_Search_Lucene_Field::Text('intro', $module['intro']));
        $doc->addField(Zend_Search_Lucene_Field::Text('objectives', $module['objectives']));
        $doc->addField(Zend_Search_Lucene_Field::Text('teaching_activities', $module['teaching_activities']));
        $doc->addField(Zend_Search_Lucene_Field::Text('assessment_opportunities', $module['assessment_opportunities']));
        $doc->addField(Zend_Search_Lucene_Field::Text('notes', $module['notes']));
        $doc->addField(Zend_Search_Lucene_Field::Text('publish', $module['publish']));
        $doc->addField(Zend_Search_Lucene_Field::Text('active', $module['active']));
        $doc->addField(Zend_Search_Lucene_Field::Text('subject_id', $module['subject_id']));
        $doc->addField(Zend_Search_Lucene_Field::Text('year_id', $module['year_id']));
        $doc->addField(Zend_Search_Lucene_Field::Text('search_type', 'module'));

        $index->addDocument($doc);
        $index->commit();

    }

    public function add_lesson($lesson) {

        $index = Zend_Search_Lucene::open(APPPATH . 'search/index');
        $doc = new Zend_Search_Lucene_Document();
        // Initialise entry with blank values, these can be overwritten with actual data
        $this->init_search_entry($doc);

        $doc->addField(Zend_Search_Lucene_Field::Text('title', $lesson['title']));
        $doc->addField(Zend_Search_Lucene_Field::Text('lesson_id', $lesson['id']));
        $doc->addField(Zend_Search_Lucene_Field::Text('subject_id', $lesson['subid']));
        $doc->addField(Zend_Search_Lucene_Field::Text('module_id', $lesson['module_id']));
        $doc->addField(Zend_Search_Lucene_Field::Text('teacher_id', $lesson['teacher_id']));
        $doc->addField(Zend_Search_Lucene_Field::Text('intro', $lesson['intro']));
        $doc->addField(Zend_Search_Lucene_Field::Text('objectives', $lesson['objectives']));
        $doc->addField(Zend_Search_Lucene_Field::Text('teaching_activities', $lesson['teaching_activities']));
        $doc->addField(Zend_Search_Lucene_Field::Text('assessment_opportunities', $lesson['assessment_opportunities']));
        $doc->addField(Zend_Search_Lucene_Field::Text('search_type', 'lesson'));

        $index->addDocument($doc);
        $index->commit();

    }

    // Helper Methods:

    public function getURLResourceType($resource_link){

        $video_sites = array('youtube', 'metacafe');

        if ($this->strposa($resource_link,$video_sites) !== false) {
           return array('video', 'url');
        }else{
           return array('url');
        }

    }

    public function getFileResourceType($resource_name){
        
        $ct['htm'] = 'text/html';
        $ct['html'] = 'text/html';
        $ct['txt'] = 'text/plain';
        $ct['asc'] = 'text/plain';
        $ct['bmp'] = 'image/bmp';
        $ct['gif'] = 'image/gif';
        $ct['jpeg'] = 'image/jpeg';
        $ct['jpg'] = 'image/jpeg';
        $ct['jpe'] = 'image/jpeg';
        $ct['png'] = 'image/png';
        $ct['ico'] = 'image/vnd.microsoft.icon';
        $ct['mpeg'] = 'video/mpeg';
        $ct['mpg'] = 'video/mpeg';
        $ct['mpe'] = 'video/mpeg';
        $ct['mp4'] = 'video/mpeg';
        $ct['qt'] = 'video/quicktime';
        $ct['mov'] = 'video/quicktime';
        $ct['avi']  = 'video/x-msvideo';
        $ct['wmv'] = 'video/x-ms-wmv';
        $ct['mp2'] = 'audio/mpeg';
        $ct['mp3'] = 'audio/mpeg';
        $ct['rm'] = 'audio/x-pn-realaudio';
        $ct['ram'] = 'audio/x-pn-realaudio';
        $ct['rpm'] = 'audio/x-pn-realaudio-plugin';
        $ct['ra'] = 'audio/x-realaudio';
        $ct['wav'] = 'audio/x-wav';
        $ct['css'] = 'text/css';
        $ct['zip'] = 'application/zip';
        $ct['pdf'] = 'application/pdf';
        $ct['doc'] = 'application/msword';
        $ct['docx'] = 'application/msword';
        $ct['bin'] = 'application/octet-stream';
        $ct['exe'] = 'application/octet-stream';
        $ct['class']= 'application/octet-stream';
        $ct['dll'] = 'application/octet-stream';
        $ct['xls'] = 'application/vnd.ms-excel';
        $ct['ppt'] = 'application/vnd.ms-powerpoint';
        $ct['wbxml']= 'application/vnd.wap.wbxml';
        $ct['wmlc'] = 'application/vnd.wap.wmlc';
        $ct['wmlsc']= 'application/vnd.wap.wmlscriptc';
        $ct['dvi'] = 'application/x-dvi';
        $ct['spl'] = 'application/x-futuresplash';
        $ct['gtar'] = 'application/x-gtar';
        $ct['gzip'] = 'application/x-gzip';
        $ct['js'] = 'application/x-javascript';
        $ct['swf'] = 'application/x-shockwave-flash';
        $ct['tar'] = 'application/x-tar';
        $ct['xhtml']= 'application/xhtml+xml';
        $ct['au'] = 'audio/basic';
        $ct['snd'] = 'audio/basic';
        $ct['midi'] = 'audio/midi';
        $ct['mid'] = 'audio/midi';
        $ct['m3u'] = 'audio/x-mpegurl';
        $ct['tiff'] = 'image/tiff';
        $ct['tif'] = 'image/tiff';
        $ct['rtf'] = 'text/rtf';
        $ct['wml'] = 'text/vnd.wap.wml';
        $ct['wmls'] = 'text/vnd.wap.wmlscript';
        $ct['xsl'] = 'text/xml';
        $ct['xml'] = 'text/xml';

        $extension = substr(strrchr($resource_name,'.'),1);

        if (!$type = $ct[strtolower($extension)]) {
            $type = 'misc';
        }

        $doc_file_types = array('pdf', 'text', 'msword', 'ms-powerpoint', 'ms-excel');

        if (strpos($type,'audio') !== false) {
            return array('audio');
        }elseif (strpos($type,'image') !== false) {
            return array('img');
        }elseif (strpos($type,'video') !== false) {
            return array('video');
        }elseif ($this->strposa($type,$doc_file_types) !== false) {
            return array('doc', $this->strposa($type,$doc_file_types));
        }else{
            return array('misc');
        }

    }

    public function strposa($haystack, $needle, $offset=0) {

        if(!is_array($needle)) $needle = array($needle);
        foreach($needle as $query) {
            if(strpos($haystack, $query, $offset) !== false) return $query; // stop on first true result
        }
        return false;

    }
       
		
}