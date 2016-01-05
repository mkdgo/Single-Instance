<script>
    var mark_id = {mark_id};
    var base_assignment_id = 0;
    var assignment_id = 0;
    var student_name = "{student_name}";
    var HOST = '/f4_teacher/';
    var URL_save = HOST + 'savedata/' + mark_id;
    var URL_load = HOST + 'loaddata/' + mark_id;
    var URL_cat_total = HOST + 'getCategoriesTotal/' + base_assignment_id;
    var homeworks_html_path = "{homeworks_html_path}";
    var homework_categories = {};

    var total = 0;
    var total_total = 0;
    var total_avail = 0;
    $.each(homework_categories, function (khm, vhm) {
        total_avail += parseInt(homework_categories[khm].category_marks);
        total_total += parseInt(homework_categories[khm].category_total);
    });

    var pages_num = {pages_num};

</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?= base_url("/js/resize/jquery.drag.resize.js") ?>"></script>
<script src="<?= base_url("/js/f5_teacher.js") ?>"></script>

<link rel="stylesheet" href="<?= base_url("/css/f4_teacher.css") ?>" type="text/css" media="screen" title=""/>

<div class="breadcrumb_container">
    <div class="container">{breadcrumb}</div>
</div>

<div class="blue_gradient_bg">
    <div class="container">
        <br />
        <div class="nav clearfix" style=" margin-bottom: 25px;">
            <a style="display: {prev_work_item_visible}" href="{prev_work_item}" class="prev-page arrow-left left"></a>
            <a style="display: {next_work_item_visible}" href="{next_work_item}" class="next-page arrow-right right"></a>
        </div>

        <?php if ($this->_data['remote_work_item']): ?>
        <div id="editor_holder" style="margin-bottom: 50px; height: 600px;">
            <?php if ($this->_data['remote_type'] == 'video'): ?>
            <iframe width="728" height="595" src="<?php echo $this->_data['remote_embed']; ?>" frameborder="0" allowfullscreen></iframe>
            <?php else: ?>
            <iframe src="<?php echo $this->_data['remote_link']; ?>" width="100%"></iframe>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div id="editor_holder" class="" style="margin-bottom: 50px;">
            <div id="editor" class="editor"></div>
            <div id="editor_image"></div>  
            <div class="pagenavig">
                <div id="arrow_left"><img id="arrow_left_i" src="/img/img_dd/prev.png"  onClick="paginnation_doPage(-1);" border="0"></div>
                <div id="caption_b"></div>
                <div id="arrow_right"><img id="arrow_right_i" src="/img/img_dd/next.png" onClick="paginnation_doPage(1);" border="0"></div>
            </div>
        </div>
        <?php endif; ?>

        <div id="area" class="dd_block snap-to-grid" style='width:100px; height:100px;' title="">
            <div class="dd_dot"><div class="dot_number">-1</div></div>
            <div class="dd_handle"></div>
            <div class="dd_resize"></div>
        </div>            

        <a id="download_resource_link" class="downloader" href="/f2_student/resourceDownload/{resource_id}"><div class="downloader_label">Download</div></a>

        <div id="comments">
            <div class="clear"></div>
            <h3 style="float: left; width:400px;">Comments</h3>
            <div id="comments_rows">
                <div id="comment_row" class="comment_row">
                    <a href="javascript: void(0);" class="btn remove"><span class="glyphicon glyphicon-remove"></span></a>
                    <div class="comment_row_cell_one"><div class="comment_NM">D</div></div>
                    <div class="comment_row_cell_extra"></div>
                    <div class="comment_row_cell_two" style="width: 338px;"><textarea class="comment_TA" style="height: 80px; width: 326px;"></textarea></div>
                    <div style="clear: both;"></div>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
        <div style="clear: both;"></div>  
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
            <a id="savedraft_bt" style="" href="javascript: saveData();" class="red_btn">SAVE WORK ITEM</a>
        </div>
    </div>
</footer>

<style>
    .comment_row div.editable {
        width: 338px!important;
    }
</style>