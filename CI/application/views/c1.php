<!-- <script src="<?=base_url(" /js/c1.js ")?>"></script> -->
<!-- <link rel="stylesheet" href="<?=base_url(" /css/c1.css ")?>" type="text/css" /> -->
{save_resource}
<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <div class="all_resources">
            <h2>Resources</h2>
            <h3>Search resources</h3>
            <form id="resource_form_search_ajax" action="javascript:void(0);">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="field search">
                            <a href="javascript:void(0)" onclick='resourceSearch();'><span class="glyphicon glyphicon-search"></span></a>
                            <div class="fc">
                                <input type="search" id="query_value_ajax" name='query' placeholder="Type a keyword..." value="{query}" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="returned_results">{results}</div>
        </div>
        <div id="my_resources" class="hidden">
            <div class="gray_backg100 center filtertitle hide_my_resources}">
                <span style="margin-left: 0;" class="lesson_title">My Resources</span>
                <br/>
                <br/>
            </div>
            <ul data-role="listview" data-autodividers="true" data-icon="false" data-filter="true" class="height_487px" data-inset="true">
                {my_resources}
                <li>
                    <?php if( $hide_my_resources != 'hidden' ) :?>
                    <div style="float: right;">
                        <a style="margin-top:15px; " href="javascript: delRequest('/c2/delete/{resource_id}');">
                            <img style="margin-top:10px; margin-right:10px; " class="disable_dd" src="/img/del_icn.png">
                        </a>
                    </div>
                    <?php endif; ?>
                    <span style="margin-top:5px;font-size:20px;padding: 0 0 0  20px;" class=" lesson_button">
                        <a href="c2/index/resource/{resource_id}"><span class="hidden">{resource_name}</span>
                            <div class="yesdot">EDIT</div>
                        </a>
                        {preview}
                    </span>
                </li>
                {/my_resources}
            </ul>
        </div>
        <!-- <a href="{add}"  style="margin-bottom:0;margin-top:30px;" class="add_resource_butt red_button new_lesson_butt ui-link ce" >ADD RESOURCE</a> 
        <a href="{add}"  class="add_resource_butt red_button new_lesson_butt ui-link" >ADD STUDENT SPECIFIC RESOURCE</a>-->
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<prefooter>
    <div class="container"></div>
</prefooter>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
        <?php
        $user_type = $this->session->userdata('user_type');
	if($user_type == 'teacher'){	
        ?>
            <a href="{add_resource}" class="red_btn">ADD RESOURCE<i class="icon add"></i></a>
        <?php } ?>
        </div>
    </div>
</footer>

<div class="add_resource_bottom_button">
    <a href="/c2/" class="add_resource_butt menu_red_button">ADD RESOURCE</a>
    <span class='add_resource_plus'><span class='glyphicon glyphicon-plus'></span></span>
    <div class="clear"></div>
</div>
<!-- <div data-role="popup" id="popupDel" data-overlay-theme="a" data-theme="c" style="border-radius: 30px; border: solid 1px black; max-width:400px;" class="ui-corner-all">

<div data-role="content" data-theme="d" style="background-image: url('/img/popupbg.png'); background-repeat:repeat-x; background-position:center; text-align: center; " class="ui-corner-bottom ui-content">

<h3 style="margin: 20px;" class="ui-title">Are you sure you want to delete this resource?</h3>

<a id="popupDelBT" style="line-height: 15px; height:35px; width: 130px;" href="" data-role="button" data-inline="true" data-transition="flow" class="redbt" data-theme="r">Delete</a>
<a style="line-height: 15px; height:35px; width: 130px;" href="javascript: cancelPopup();" data-role="button" data-inline="true" class="greenbt" data-theme="a">Cancel</a>

</div>
</div> -->

<script>
    $("#resource_form_search_ajax").keyup(function(event){

        if(event.keyCode == 13){

            console.log('query ajax', $('#query_value_ajax').val());
            // event.preventDefault();

            resourceSearch();

        }
    });

    function resourceSearch(){
        $.ajax({
              type: "POST",
              url: "/c1/ajaxquery",
              data: { query: $('#query_value_ajax').val(), user_type: user_type, save_resource: '{save_resource}' }
            })
              .done(function( msg ) {
                $(".returned_results").html( msg );
                // $("ul").listview();
            });
    }
</script>


<?php
$error_msg = $this->session->flashdata('error_msg');
if($error_msg!=''){

    ?>
<script type="text/javascript">
    $(document).ready(function() {
    message= "<?php echo $error_msg;?>";
    showFooterMessage({mess: message, clrT: '#6b6b6b', clr: '#fcaa57', anim_a:2000, anim_b:1700});
    })
</script>
<?php } ?>


