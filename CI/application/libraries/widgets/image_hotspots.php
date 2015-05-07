<?php
class image_hotspots {
    private $_CI;
    public function __construct() {
        $this->_CI = & get_instance();

    }




    public function get()
    {

        $res = $this->_CI->db->get_where('widgets_data',array('cont_page_id'=>$this->_CI->input->post('cont_page')))->row_array();

echo '['.$res['data'].']';

       //echo '[{ "x":288, "y":190, "Title":"Title 1","Message":"Image annotation 1" },{ "x":143, "y":200, "Title":"Title 2","Message":"Image annotation 2" },{ "x":100, "y":250, "Title":"Title 3","Message":"Image annotation 3" }]';


    }

    public function index()
    {
        $this->_CI->load->model('modules_model');
        $this->_CI->load->model('subjects_model');
        $this->_CI->load->library('breadcrumbs');
        $this->_CI->load->library('nativesession');

        $subject_id = $this->_CI->uri->segment(4);
        $module_id = $this->_CI->uri->segment(5);
        $lesson_id = $this->_CI->uri->segment(6);
        $lesson = $this->_CI->lessons_model->get_lesson($lesson_id);
        $selected_year = $this->_CI->getSelectYearTeacher($this->_CI->nativesession, $this->_CI->subjects_model, $subject_id, '');
        $this->_CI->breadcrumbs->push('Home', base_url());
        $this->_CI->breadcrumbs->push('Subjects', '/d1');

        if ($subject_id) {
            $subject = $this->_CI->subjects_model->get_single_subject($subject_id);
            $this->_CI->breadcrumbs->push($subject->name, "/d1a/index/" . $subject_id);
        }

        $this->_CI->breadcrumbs->push('Year ' . $selected_year->year, "/d2_teacher/index/" . $subject_id);

        $module = $this->_CI->modules_model->get_module($module_id);
        $this->_CI->breadcrumbs->push($module[0]->name, "/d4_teacher/index/" . $subject_id . "/" . $module_id);

        $this->_CI->breadcrumbs->push($lesson->title, "/d5_teacher/index/" . $subject_id . "/" . $module_id . "/" . $lesson_id);
        $this->_CI->breadcrumbs->push("Slides", "/e1_teacher/index/" . $subject_id . "/" . $module_id . "/" . $lesson_id);

        $this->_CI->breadcrumbs->push("Image Hotspots", "/");

        $this->_CI->_data['widget_assets'] = $this->load_assets();
        $this->_CI->_data['inline_scripting'] = $this->parse_js('admin');
        $this->_CI->_data['page_content_html'] = $this->parse_html();



        $slide = $this->_CI->db->get_where('content_page_slides',array('lesson_id'=>$this->_CI->uri->segment(6),'id'=>$this->_CI->uri->segment(7)))->row_array();
        $this->_CI->_data['cont_page_title']=$slide['title'];
        $this->_CI->_data['cont_page_text']=$slide['text'];


        $this->_CI->_data['breadcrumb'] = $this->_CI->breadcrumbs->show();
        $this->_CI->_paste_public('widgets/image_hotspots');
    }
public function preview()
{
    $this->_CI->_data['widget_assets'] = $this->load_assets();
    $this->_CI->_data['inline_scripting'] = $this->parse_js('display');
    $this->_CI->_data['page_content_html'] = $this->parse_html();
    $slide = $this->_CI->db->get_where('content_page_slides',array('lesson_id'=>$this->_CI->uri->segment(6),'id'=>$this->_CI->uri->segment(7)))->row_array();
    $this->_CI->_data['cont_page_title']=$slide['title'];
    $this->_CI->_data['cont_page_text']=$slide['text'];

    $this->_CI->_data['_header'] = '';
    $this->_CI->_data['_footer'] = '';
    $this->_CI->_paste_preview('widgets/image_hotspots_preview');
}

    public function save()
    {
        //print_r($this->_CI->input->post());

      $row=  $this->_CI->db->get_where('widgets_data',array('cont_page_id'=>$this->_CI->input->post('cont_page')));
        if($row->num_rows()<1)
        {
            $this->_CI->db->insert('widgets_data', array('data' => $this->_CI->input->post('result'),'cont_page_id'=>$this->_CI->input->post('cont_page'),'background_image'=>$this->_CI->input->post('bg_img',true)));
        }
        else {
            $this->_CI->db->where(array('cont_page_id' => $this->_CI->input->post('cont_page')));
            $this->_CI->db->update('widgets_data', array('data' => $this->_CI->input->post('result'),'background_image'=>$this->_CI->input->post('bg_img',true)));
        }

        $this->_CI->db->where(array('id'=>$this->_CI->input->post('cont_page')));
        $this->_CI->db->update('content_page_slides',array('title'=>$this->_CI->input->post('title',true),'text'=>$this->_CI->input->post('text',true)));


echo 'true';

    }



    public function slide()
    {


        $widget = $this->_CI->uri->segment(2);

       $widget_details= $this->_CI->db->get_where('widgets',array('controller_name'=>$widget))->row();
if($widget_details) {
 $this->_CI->db->insert('content_page_slides', array('widget_fk_id'=>$widget_details->widget_id,'lesson_id'=>$this->_CI->uri->segment(6),'slide_type'=>'widget'));
    $last_id=    $this->_CI->db->insert_id();
}

        if($last_id)
        {
            redirect('widgets/image_hotspots/index/'.$this->_CI->uri->segment(4).'/'.$this->_CI->uri->segment(5).'/'.$this->_CI->uri->segment(6).'/'.$last_id);
        }
        else
        {
            redirect($this->_CI->base_url());
        }



    }





//assets

public function load_assets()
{

    $assets= '<link rel="stylesheet" type="text/css" href="'.base_url().'widgets_assets/image_hotspots/css/jquery.hotspot.css">'.PHP_EOL;
    $assets.= '<link rel="stylesheet" type="text/css" href="'.base_url().'widgets_assets/image_hotspots/css/style.css">'.PHP_EOL;
    $assets.= '<link rel="stylesheet" type="text/css" href="'.base_url().'widgets_assets/image_hotspots/css/fineuploader-3.5.0.css">'.PHP_EOL;




    return $assets;
}



public function parse_html()
{
    $res = $this->_CI->db->get_where('widgets_data',array('cont_page_id'=>$this->_CI->uri->segment(7)))->row_array();

if($res['background_image']=='')
{
    return '
        <div id="theElement-a">
	<img src="'.base_url().'widgets_assets/image_hotspots/img/demo.jpg" width="700" height="500" class="bg_img"/>
	<input type="hidden" class="back_pic" value=""/>
</div>';
}
    else
    {
        return '
        <div id="theElement-a">
	<img src="'.base_url().'uploads_widgets/image_hotspots/'.$res['background_image'].'" width="700" height="500" class="bg_img"/>
	<input type="hidden" class="back_pic" value="'.$res['background_image'].'"/>
</div>';
    }

}


public function parse_js($type)
{
    return '
<script type="text/javascript" src="'.base_url().'widgets_assets/image_hotspots/js/jquery.hotspot_dev.js"></script>

<script type="text/javascript">
var cont_page= "'.$this->_CI->uri->segment(7).'"
    $("#theElement-a").hotspot({
	mode: "'.$type.'",

	ajax: true,
   ajaxOptionsSave: {
        url: \''.base_url().'widgets/image_hotspots/save\',
        type: \'POST\',
        data:{cont_page:cont_page,result:"result"}

    },
    ajaxOptionsGet: {
        url: \''.base_url().'widgets/image_hotspots/get\',
        type: \'POST\',
        async: false,
        data:{cont_page:cont_page}
    },
		interactivity: "click",
    LS_Variable: "HotspotPlugin-a",
	done_btnId: \'done-a\',
	remove_btnId: \'remove-a\',
	server_btnId: \'server-a\',
	afterSave: function(message) {

},
	afterRemove: function(message) {
    alert(message);
    window.location.reload();
},
	afterSyncToServer: function(message) {
    window.location.reload()
}
});

</script>';
}


    function upload_pic()
    {

        // Configure Upload class

        $config['upload_path'] = './uploads_widgets/';
        $config['allowed_types'] = 'jpeg|jpg|png|JPEG|JPG';
        $config['max_size']	= '10000';
        $config['max_width']  = '2000';
        $config['max_height']  = '1000';
        $config['encrypt_name']=TRUE;
        $this->_CI->load->library('upload', $config);

        // Output json as response
        if ( ! $this->_CI->upload->do_upload('qqfile'))
        {
            $json['status'] = 'error';
            $json['issue'] = $this->_CI->upload->display_errors('','');
            echo json_encode($json);

        }
        else
        {


            $json['status'] = 'true';
            $json['success']='true';




            foreach($this->_CI->upload->data() as $k => $v)
            {
                $json[$k] = $v;

            }
        }
        $nn = $this->_CI->upload->data();
        $new_name = $nn['file_name'];


        $img = './uploads_widgets/'.$new_name;
        list($width,$height) = getimagesize($img);






        echo json_encode($json);

        if($json['status']=='true')
        {

                $this->img_resize($new_name,700,500);



        }


    }

    public function img_resize($new_name,$width,$height)
    {
        $this->_CI->load->library('image_lib');

        $path = './uploads_widgets/'.$new_name;

        $newpath = './uploads_widgets/image_hotspots/'. $new_name;
        $configresize['image_library'] = 'gd2';
        $configresize['source_image']    = $path;
        $configresize['new_image'] = $newpath;
        $configresize['maintain_ratio'] = TRUE;
        $configresize['width']     = $width;
        $configresize['height']    = $height;

        $this->_CI->image_lib->initialize($configresize);

        if ( ! $this->_CI->image_lib->resize())
        {
            echo $this->_CI->image_lib->display_errors();
        }


        unset($configresize);
        unlink($path);
        $this->_CI->image_lib->clear();




    }
}

    ?>
