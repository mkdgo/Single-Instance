<script>
    var mark_id={mark_id};
    var student_name="{student_name}";
    var HOST = '/f4_teacher/';
    var URL_save = HOST+'savedata/'+mark_id;
    var URL_load = HOST+'loaddata/'+mark_id;
    var homeworks_html_path = "{homeworks_html_path}";
    var homework_categories = {assignment_categories_json};
    var pages_num={pages_num};

</script>

<script src="<?=base_url("/js/resize/jquery.drag.resize.js")?>"></script>
<script src="<?=base_url("/js/f4_teacher.js")?>"></script>

<link rel="stylesheet" href="<?=base_url("/css/f4_teacher.css")?>" type="text/css" media="screen" title=""/>

<div class="breadcrumb_container">
    <div class="container">{breadcrumb}</div>
</div>

<div class="blue_gradient_bg">
    <div class="container">
        <h2>{assignment_name}</h2>
        <h3>{student_name}<span style=' color: #111; font-family: "Glyphicons Halflings"; font-size: 10px; margin: 0 10px;position: relative;top: -2px;'></span><span style="color:#a8a8a8;">{resource_name}</span></h3>
        <hr class="m2">
        <!--marks-->
        <div id="editor_holder" class="">
            <div id="editor" class="editor"></div>
            <div id="editor_image"></div>  
            <div class="pagenavig">
                <div id="arrow_left"><img id="arrow_left_i" src="/img/img_dd/prev.png"  onClick="paginnation_doPage(-1);" border="0"></div>
                <div id="caption_b"></div>
                <div id="arrow_right"><img id="arrow_right_i" src="/img/img_dd/next.png" onClick="paginnation_doPage(1);" border="0"></div>
            </div>
        </div>

        <div id="area" class="dd_block snap-to-grid" style='width:100px; height:100px;' title="">
            <div class="dd_dot"><div class="dot_number">-1</div></div>
            <div class="dd_handle"></div>
            <div class="dd_resize"></div>
        </div>            

        <a id="download_resource_link" target="_blank" class="downloader" href="/f2_student/resource/{resource_id}"><div class="downloader_label">Download</div></a>

        <div id="comments">
            <!--LOADING Data ...-->
            <div class="clear"></div>
            <h3>Marks</h3>
            <div id="categories_rows">
                <div id="category_row" class="category_row">
                    <div class="category_row_left"></div>
                    <div class="category_row_right"></div>
                </div>
            </div>

            <div class="clear"></div>
            <h3 style="float: left; width:300px;" >Comments</h3><h3 style="float: left; width:80px;">Marks</h3>
            <div id="comments_rows">
                <div id="comment_row" class="comment_row">
                    <div class="comment_row_cell_one"><div class="comment_NM">D</div></div>
                    <div class="comment_row_cell_extra">
                        <select class="comment_CT customize">
                        </select>
                    </div>
                    <div class="comment_row_cell_two"><textarea class="comment_TA"></textarea></div>
                    <div class="comment_row_cell_three" style=""><input class="comment_TI" style="text-align: center" type="text"></div>

                    <div class="comment_row_cell_four">
                        <a href="javascript: void(0);" class="btn remove"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>

            <div id="caption_a">
                <div  class="buttons clearfix">
                    <a id="addcomment_bt" class="btn b1 right" href="javascript:;" onclick="addJustComment();" style="margin:0 10px 0 0px;" >ADD COMMENT<span class="icon i3"></span></a>
                </div>  
            </div>
            <div style="clear: both;"></div>
        </div>
        <div style="clear: both;"></div>  
        <!--marks-->
    </div>
</div>

<div id="popupMessage" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" onClick="$('#popupMessage').modal('hide');" style="background: #128c44;" class="btn btn-primary">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="popupDel" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Delete Comment</h4>
            </div>
            <div class="modal-body">
                <p>
                    Please confirm you want to delete your Comment !
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="color: #fff; background: #5f5f5f;" onClick="undoDeleteComment()">CANCEL</button>
                <button id="popupDelBT" cm="" p="" type="button" onClick="doDeleteComment()" style="background: #128c44;" class="btn btn-primary">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<prefooter>
    <div class="container"></div>
</prefooter>

<footer>
    <div class="container clearfix">
        <div class="left unvisible">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a id="savedraft_bt" style="" href="javascript: saveData();" class="red_btn">SAVE ASSIGNMENT</a>
        </div>
    </div>
</footer>