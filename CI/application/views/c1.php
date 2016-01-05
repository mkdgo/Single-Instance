<!-- <script src="<?=base_url(" /js/c1.js ")?>"></script> -->
<!-- <link rel="stylesheet" href="<?=base_url(" /css/c1.css ")?>" type="text/css" /> -->
<!--<link rel="stylesheet" href="<?php echo base_url("js/ladda/dist/ladda.min.css")?>" type="text/css" />-->
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
                            <button onclick='resourceSearch();' class="ladda-button" data-color="red" data-style="zoom-in"><span class="ladda-label">Search</span></button>
<!--                            <a href="javascript:void(0)" onclick='resourceSearch();'><span class="glyphicon glyphicon-search"></span></a>-->
                            <div class="fc">
                                <input type="text" id="query_value_ajax" name='query' placeholder="Type a keyword..." value="{query}" />
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
                        <a href="c2/index/resource/{resource_id}">
                            <span class="hidden">{resource_name}</span>
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
<prefooter><div class="container"></div></prefooter>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
        <?php if($this->session->userdata('user_type') == 'teacher' ): ?>
            <a href="{add_resource}" class="red_btn">CREATE NEW RESOURCE<i class="icon add"></i></a>
            <a href="{back}" class="red_btn">SAVE</a>
        <?php endif ?>
        </div>
    </div>
</footer>

<div class="add_resource_bottom_button">
    <a href="/c2/" class="add_resource_butt menu_red_button">CREATE NEW RESOURCE</a>
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

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <div id="editor_image" style=" font-family: Open Sans; height: 200px; width: 600px; margin: auto auto;padding-top: 20%; font-size: 20px;text-align: center;">
                    <p>Please click "Download" to view the file</p>
                    <a id="download_resource_link" style="font-family: Open Sans; text-align: center; margin:0px 70px; line-height:2; text-decoration: none; color: #fff; width:150px; height:36px; background: #ff0000;display: inline-block;" class="downloader" href="">Download</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
        </div>
    </div>
</div>

<!--<script src="<?php echo base_url("/js/ladda/dist/spin.min.js") ?>"></script>
<script src="<?php echo base_url("/js/ladda/dist/ladda.min.js") ?>"></script>-->
<script type="text/javascript">
    var ladda;
    $(document).ready(function(){

        // Create a new instance of ladda for the specified button
        ladda = Ladda.create( document.querySelector( 'button.ladda-button' ) );

//    $("#myModal").modal('show');

//*
    // Create a new instance of ladda for the specified button
//    var l = Ladda.create( document.querySelector( 'button.ladda-button' ) );
    // Start loading
//    l.start(); 
    // Will display a progress bar for 50% of the button width
//    l.setProgress( 0.5 );
    // Stop loading
//    l.stop();
    // Toggle between loading/not loading states
//    l.toggle();
    // Check the current state
//    l.isLoading();
//*/
    });

    function mdl(href) {
        $('.downloader').attr('href',href);
        $("#myModal").modal('show');
    }

    $("#resource_form_search_ajax").keyup(function(event){
        if(event.keyCode == 13){
//            console.log('query ajax', $('#query_value_ajax').val());
            // event.preventDefault();
            resourceSearch();
        }
    });

    function resourceSearch(){
        ladda.start(); 
        $.ajax({
            type: "POST",
            url: "/c1/ajaxquery",
            data: { query: $('#query_value_ajax').val(), user_type: user_type, save_resource: '{save_resource}', exist_resources: '{exist_resources}' }
        })
        .done(function( msg ) {
            $(".returned_results").html( msg );
            ladda.stop();
        });
    }

</script>

<?php
$error_msg = $this->session->flashdata('error_msg');
if($error_msg!=''){ ?>
<script type="text/javascript">
    $(document).ready(function() {
        message= "<?php echo $error_msg;?>";
        showFooterMessage({status: 'alert', mess: message, clrT: '#6b6b6b', clr: '#fcaa57', anim_a:2000, anim_b:1700});
    })
</script>
<?php } ?>


