<?php
class image_hotspots {
    private $_CI;
    public function __construct() {
        $this->_CI = & get_instance();

    }


public function edit()
{
    echo 'sdsd';
}


    public function get()
    {

        $res = $this->_CI->db->get_where('widgets_data',array('cont_page_id'=>$this->_CI->input->post('cont_page')))->row_array();

echo '['.$res['data'].']';

       //echo '[{ "x":288, "y":190, "Title":"Title 1","Message":"Image annotation 1" },{ "x":143, "y":200, "Title":"Title 2","Message":"Image annotation 2" },{ "x":100, "y":250, "Title":"Title 3","Message":"Image annotation 3" }]';


    }

    public function index()
    {
        $this->_CI->_data['widget_assets'] = $this->load_assets();
        $this->_CI->_data['inline_scripting'] = $this->parse_js();
        $this->_CI->_data['page_content_html'] = $this->parse_html();

        $this->_CI->_paste_public('widgets/image_hotspots');
    }


    public function save()
    {
        //print_r($this->_CI->input->post());


        $this->_CI->db->where(array('cont_page_id'=>$this->_CI->input->post('cont_page')));
        $this->_CI->db->update('widgets_data',array('data'=>$this->_CI->input->post('result')));
echo 'true';

    }





//assets

public function load_assets()
{

    $assets= '<link rel="stylesheet" type="text/css" href="'.base_url().'widgets_assets/image_hotspots/css/jquery.hotspot.css">'.PHP_EOL;
    $assets.= '<link rel="stylesheet" type="text/css" href="'.base_url().'widgets_assets/image_hotspots/css/style.css">'.PHP_EOL;





    return $assets;
}



public function parse_html()
{
    return '
        <div id="theElement-a">
	<img src="'.base_url().'widgets_assets/image_hotspots/img/demo.jpg" width="500" height="500" class="bg_img"/>
</div>';
}


public function parse_js()
{
    return '
<script type="text/javascript" src="'.base_url().'widgets_assets/image_hotspots/js/jquery.hotspot_dev.js"></script>
<script type="text/javascript">
var cont_page= "'.$this->_CI->uri->segment(7).'"
    $("#theElement-a").hotspot({
	mode: "display",

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
    alert(message);
},
	afterRemove: function(message) {
    alert(message);
    window.location.reload();
},
	afterSyncToServer: function(message) {
    alert(message);
}
});
/*
    $("#theElement-b").hotspot({
mode: "admin",

LS_Variable: "HotspotPlugin-b",
done_btnId: \'done-b\',
remove_btnId: \'remove-b\',
server_btnId: \'server-b\',
afterSave: function(message) {
    alert(message);
},
afterRemove: function(message) {
    alert(message);
    window.location.reload();
},
afterSyncToServer: function(message) {
    alert(message);
}
});
*/
</script>';
}



}

    ?>
