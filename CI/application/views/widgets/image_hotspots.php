
{widget_assets}
<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
               {page_content_html}


                {inline_scripting}
            </div>
        </div>
    </div>


    </div>









<div id="message" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="popupPubl" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>


                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <label for="hotspot_title">Title</label>
                <input type="text" class="hotspot_title" style="width: 90%;margin: 0 auto;padding: 0;"/>
                <label for="hotspot_message">Description</label>
                <textarea class="hotspot_message" style="width: 90%;min-height:140px;margin: 0 auto;padding: 0;"></textarea>
                <input type="hidden" class="elem_id" value=""/>
            </div>

            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupPublBTN" typeof="update" type="button"    class="btn orange_btn">UPDATE</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="popupPublAdd" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>


                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <label for="hotspot_title">Title</label>
                <input type="text" placeholder="Add title" class="hotspot_title_add" style="width: 90%;margin: 0 auto;padding: 0;"/>
                <label for="hotspot_message">Description</label>
                <textarea class="hotspot_message_add" placeholder="Add description" style="width: 90%;min-height:140px;margin: 0 auto;padding: 0;"></textarea>
                <input type="hidden" class="elem_id" value=""/>
            </div>

            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupPublAddBTN" typeof="add" type="button"    class="btn orange_btn">ADD</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<prefooter>
    <div class="container"></div>
</prefooter>


<footer>
    <div class="container">
        <div class="left unvisible">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="javascript: publishModal();" class="publish_btn {publish_active}" ><span>{publish_text}</span></a>
            <a href="javascript:;" onclick="document.getElementById('int_lesson_form').action = '/e1_teacher/save/';
                    document.getElementById('int_lesson_form').submit()" class="red_btn">SAVE</a>
            <a href="javascript:;" onclick="document.getElementById('int_lesson_form').submit()" class="red_btn">LAUNCH LESSON</a>
        </div>
        <div class="clear"></div>
    </div>
</footer>





