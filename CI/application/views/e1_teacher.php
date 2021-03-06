<!--<link rel="stylesheet" href="<?=base_url("/css/e1_teacher.css")?>" type="text/css"/>-->
<!--<script src="<?=base_url("/js/sortable.js")?>"></script>
<script src="<?=base_url("/js/e1_teacher.js")?>"></script>-->

<?php
$msg = $this->session->flashdata('msg');
if($msg !='') { ?>
    <script>
        $(document).ready(function() {
            showFooterMessage({status: 'success', mess: '<?php echo $msg ?>', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        })

    </script>

<?php } ?>
<div class="blue_gradient_bg">
    <div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <h2>{lesson_title}</h2>
                <ul class="menu2 clearfix">
                    {items}
                    <li idn="{item_type}{item_id}">
                        <a href="javascript: void(0);" data-role="button" class="question-m"></a>
                        <a href="javascript: delRequest('/{item_type}/{item_type_delete}/{subject_id}/{year_id}/{module_id}/{lesson_id}/{item_id}','{item_title}');" data-rel="popup" data-position-to="window" data-inline="true" data-transition="pop" class="close"></a>

                        <div class="main">
                            <div class="img">
                                <a href="/{item_type}/index/{subject_id}/{year_id}/{module_id}/{lesson_id}/{item_id}"><img alt="" src="/img/icon_{item_iconindex}.png" /></a>
                            </div>
                            <h4>
                                <a href="/{item_type}/index/{subject_id}/{year_id}/{module_id}/{lesson_id}/{item_id}">{item_title}</a>
                            </h4>
                        </div>
                        <div class="info" style="padding: 0;">
                            <p style="margin: 0 8px;">
                                {resources_label}
                                <a onclick="$('div.preview{item_id} a:first-child').click()" class="" style="cursor: pointer;" title="View resources">
                                    <span class="glyphicon glyphicon glyphicon-list-alt"></span>
                                    <span class="glyphicon glyphicon-facetime-video"></span>
                                    <span class="glyphicon glyphicon-picture"></span>
                                </a>
                            </p>
                            <a href="{slide_preview}" class="btn red_btn" style="width: 100%; font-size: 12px; line-height: 32px; padding: 0; margin: 0;">Preview</a>
<!--                            <a onclick="$('div.preview{item_id} a:first-child').click()" class="btn red_btn" style="width: 100%; font-size: 12px; line-height: 32px; padding: 0; margin: 0;">Preview</a>-->
<!--                            <a onclick="$('div.preview{item_id} a:first-child').click()" class="btn red_btn" style="width: 100%; font-size: 12px; line-height: 32px; padding: 0; margin: 0;">Preview</a>-->
                            <div class="preview{item_id}" style="display:none;">{resources_preview}</div>
                        </div>
                    </li>
                    {/items}
                    <li idn="addnew">
                        <a href="/e2/index/{subject_id}/{year_id}/{module_id}/{lesson_id}" class="new main">
<!--                        <a href="javascript: addNew();" class="new main">-->
                            <span class="img">
                                <span class="glyphicon glyphicon-plus"></span>
                            </span>
                            <span class="title">New Slide</span>
                        </a>

                        <div id="addPopup" class="modal fade">
                            <div class="modal-dialog">
                                <button type="button" onClick="document.location='/e2/index/{subject_id}/{year_id}/{module_id}/{lesson_id}'" class="btn btn-default" data-dismiss="modal">Content Page</button>
                                <button type="button" onClick="document.location='/e3/index/{subject_id}/{year_id}/{module_id}/{lesson_id}'" class="btn btn-default" data-dismiss="modal">Interactive Assesment Page</button>
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <form method="post" id="int_lesson_form" action="/e1_teacher/launch/">
                    <input type="hidden" name="resources_order" id="resources_order">
                    <div class="launch_lesson_wrap">
                        <h3>&nbsp;Launch Lesson For</h3>
                        <fieldset data-role="controlgroup" class="checkbox_fw">
                            {classes}
                            <input type="checkbox" name="classes[]" id="{id}" value="{id}" {checked} />
                            <label for="{id}">Class {year}{group_name}</label>
                            {/classes}
                        </fieldset>
                        <div class="clear"></div>
                    </div>
                    <input type="hidden" name="subject_id" value="{subject_id}" >
                    <input type="hidden" name="subject_curriculum_id" value="{subject_curriculum_id}" />
                    <input type="hidden" name="year_id" value="{year_id}" />
                    <input type="hidden" name="module_id" value="{module_id}" >
                    <input type="hidden" name="lesson_id" value="{lesson_id}" >
                    <input type="hidden" id="publish" name="publish" value="{publish}" />
                    <input type="hidden" id="parent_publish" name="parent_publish" value="{parent_publish}" />
                    <input type="hidden" id="secret" name="secret" value="" />
                    <input type="hidden" id="socketId" name="socketId" value="" />
                </form>
            </div>
        </div>
    </div>
</div>
<?php if( $has_answers != 0 ): ?>
<form action="/r2_teacher/" method="post" id="report">
    <input type="hidden" name="r2_teacher_id" value="all" />
    <input type="hidden" name="r2_subject_id" value="{subject_id}" />
    <input type="hidden" name="r2_year" value="all" />
    <input type="hidden" name="r2_class_id" value="all" />
    <input type="hidden" name="r2_assignment_id" value="{lesson_id}" />
    <input type="hidden" name="r2_behavior" value="online" />
    <input type="hidden" name="report" value="homework" />
</form>
<?php endif ?>
<div class="clear" style="height: 1px;"></div>

<prefooter><div class="container"></div></prefooter>
<footer>
    <div class="container">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <?php if( $has_answers != 0 ): ?>
            <a href="javascript: $('#report').submit();" class="red_btn" id="copy">SHOW QUIZ REPORT</a>
            <?php endif?>
            <a href="javascript: publishModal();" class="publish_btn {publish_active}" rel="{parent_publish}" ><span>{publish_text}</span></a>
            <a href="javascript:;" onclick="document.getElementById('int_lesson_form').action='/e1_teacher/save/';document.getElementById('int_lesson_form').submit()" class="red_btn">SAVE</a>
            {if !items }
            <a href="javascript:;" onclick="notSbmt()" class="btn-lunch red_btn" style="opacity: .5">LAUNCH LESSON</a>
            {else}
            <a href="javascript:;" onclick="sbmt()" class="btn-lunch red_btn">LAUNCH LESSON</a>
            {/if}
        </div>
        <div class="clear"></div>
    </div>
</footer>

<div id="popupDel" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                 <p></p>
            </div>
            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupDelBT" do="1" type="button" onClick="doDel()" delrel=""  class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
                <p></p>
            </div>
            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupPublBT" do="1" type="button" onClick="doPubl()" class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="popupNL" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                 <p>There are no slides available to play lesson!</p>
            </div>
            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">OK</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(function  () {
        $.getJSON( "http://77.72.3.90:1948/token", function( data ) {
            document.getElementById('secret').value = data.secret;
            document.getElementById('socketId').value = data.socketId;
        });
    })

    $(document).ready(function () {
        $('.preview').each(function() {
            var idd = $(this).attr('data-id');
            $(".group_" + idd).colorbox({rel:'group_' + idd, width:"70%", height:"80%"});
            $(".clr_iframe_" + idd).colorbox({rel:'group_' + idd, iframe:true, width:"70%", height:"80%"});
        })
    });

    function sbmt() {
        document.getElementById('int_lesson_form').submit();
    }

    function notSbmt() {
        $('#popupNL').modal('show');
    }
</script>
