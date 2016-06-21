<style type="text/css">
    .attained_marks {
        margin-left: 10px;
        display: none;
    }
    .attained {
        float: right;
        font-weight: bold;
        height: 40px;
        width: 40px;
        text-align: center;
        line-height: 40px;
        border-radius: 40px;
        border: 1px solid #333;
        margin-top: -10px;
    }
</style>

<div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>
<div  class="blue_gradient_bg">
    <div class="container">
        <h2>{title}</h2>
        <div class="row" style="margin: 0;">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-left: 0px;">
                <ul class="slides" style="width: 100%; padding-left: 0px;">
                    <li style="margin:10px 15px 0 0;list-style:none;">
                        <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 0 30px;float: left;">
                            <h3 class="" style="padding-bottom:4px; height:26px;overflow: hidden;  border-bottom:1px solid #c8c8c8;margin-top: 14px;font-weight: bold;">Homework Description</h3>
                            <div class="" style="float:right;background-size: 70%;margin-top:-36px; background-position: 0px -30px;"></div>
                            <div class="assignment" style="margin:0px auto;">
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="padding: 10px 0px 17px 0px;font-weight: normal; float: left;">{intro}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Set by: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{set_by}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Deadline Date: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{deadline_date}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Deadline Time: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{deadline_time}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Marks Given As: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{grade_type_label}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-right: 0;">
                {if resources}
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 0px 30px;float: left;">
                    <h3 style="padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Resources</h3>
                    <div style="float:right;background-size: 70%;height:22px;margin-top:-36px;"></div>
                    <div class="collapsed resources-student" style="margin:0px auto; display: block;">
                        <ul class="ul1 hw_resources">
                            <?php foreach( $resources as $res ): ?> 
                            <li id="li<?php echo $res['resource_id'] ?>" <?php echo $res['li_style'] ?>>
                                <a href="javascript:;" style="background: none;color:#e74c3c;padding-top: 4px;" onclick="$(this).next().children().click()">
                                    <?php echo $res['icon_type']; ?>&nbsp; <?php echo $res['resource_name']; ?>
                                </a>
                                <span class="show_resource" style="display:none;"><?php echo $res['preview']; ?></span>
                                <?php echo $res['required']; ?>
                            </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                {/if}
            </div>
        </div>
        <form id="save_assignment" class="form-horizontal" enctype="multipart/form-data" method="post" action="/f2_student/save">
            <input type="hidden" name="publish" id="publish" value="0">    
            <input type="hidden" name="assignment_id" value="{assignment_id}" />
            <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;">SAVE</button>
        </form>
        <form id="del_file" method="post" action="/f2_student/delfile">
            <input type="hidden" name="assignment_id" id="del_assignment_id" value="">
            <input type="hidden" name="resource_id" id="del_resource_id" value="">
        </form>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>

<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <?php if( $grade_type != 'offline' ): ?>
            <a  style="display: {hide_editors_publish};" href="javascript: saveAssigment('publish');" class="red_btn">{label_editors_publish}</a>
            <a  style="display: {hide_editors_save};" href="javascript:;" onclick="saveAssigment('save');" class="red_btn">{label_editors_save}</a>
            <?php endif ?>
        </div>
    </div>
</footer>

<div id="popupError" class="modal fade" style="z-index: 10000;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" onClick="$('#popupError').modal('hide');" style="background: #128c44;" class="btn btn-primary">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">

<?php
$error_msg = $this->session->flashdata('error_msg');
if ($error_msg != '') {
    ?>
        $(document).ready(function () {
            message = '<?php echo $error_msg; ?>';
            showFooterMessage({status: 'alert', mess: message, clrT: '#6b6b6b', clr: '#fcaa57', anim_a: 2000, anim_b: 1700});
        })
<?php } ?>

</script>

<script type="text/javascript">
    var flashmessage_pastmark = '<?php echo $flashmessage_pastmark ?>';
    var assignment_id = '<?php echo $assignment_id ?>';
    var base_assignment_id = <?php echo $base_assignment_id ?>;
    var marked = 1;
    var l;
    var start_timer = 0;

    $(function() {
        if( marked == 1 ) { $('.attained_marks').show() }
        $('.up_down___').on('click',function () {
            $(this).next('.up_down_homework').click();
        })

    })

//    var lesson_id = '';
    var slide_id = assignment_id;
    var identity = '<?php echo $identity; ?>';
    var behavior = 'homework';

    function submitAnswer( tbl_id, form_id, this_btn ) {
        form_id.find('input[name="slide_id"]').val(slide_id);
        form_id.find('input[name="identity"]').val(identity);
        form_id.find('input[name="behavior"]').val(behavior);

        post_data = form_id.serialize();

        $.post( "/f2_student/saveAnswer", {res_id: form_id.attr('name'), post_data: post_data}, function( data ) {
                $(this_btn).hide();
                //tbl_id.parent().parent()
                $('#li'+tbl_id.attr('rel')).css('background','#e6ffe6');
                //tbl_id.parent().parent().find
                $('.act'+tbl_id.attr('rel')).html('Question Answered');
        });
        $.colorbox.close();
    }

    function setResult(res_id) {
        $('#form_b'+res_id).find('input').attr('disabled',true);
        $('#form_b'+res_id).find('.ans').attr('onclick','');
        $('#form_b'+res_id).find('.ans').removeClass('choice-correct');
        $('#form_b'+res_id).find('.ans').removeClass('choice-true');
        $('#form_b'+res_id).find('.ans').removeClass('choice-wrong');
        $('#form_b'+res_id).find('.choice-correct-radio-value').remove();
        $('#form_b'+res_id).find('.choice-wrong-radio-value').remove();
        $('#form_b'+res_id).find('.choice-correct-value').remove();
        $('#form_b'+res_id).find('.choice-wrong-value').remove();
        $('#form_b'+res_id).find('label.choice-correct-radio').attr('class', '');
        $('#form_b'+res_id).find('label.choice-wrong-radio').attr('class', '');
        $('#form_b'+res_id).find('input.choice-wrong').attr('class', '');
        $('#form_b'+res_id).find('input.choice-true').attr('class', '');
        $('#form_b'+res_id).find('input.choice-correct').attr('class', '');

        $.get( "/f2_student/getStudentAnswers", { lesson_id: base_assignment_id, slide_id: assignment_id, resource_id: res_id, marked: marked }, function( data ) {
            switch(data.type) {
                case 'single_choice':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#i_'+data.answers[i]).attr('checked',true);
                    }
                    break;
                case 'multiple_choice':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#i_'+data.answers[i]).attr('checked',true);
                    }
                    break;
                case 'fill_in_the_blank':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#'+data.answers[i].key).val(data.answers[i].val);
                    }
                    break;
                case 'mark_the_words':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#q'+res_id+data.answers[i]).css('background', '#53EEEB');
                    }
                    break;
            }
            $.each(data.html.answers,function(key,val){
                $('#'+key).addClass(val.class);
                if(val.value) {
                    $('#'+key).after('<span class="'+val.class+'-value">'+val.value+'</span>');
                }
            })

            $('.tbl_b'+res_id).html(data.html.html);
        },'json');
    }
</script>
