<!-- wysihtml core javascript with default toolbar functions -->
<!--<script src="<?php echo base_url("/js/wysihtml-0.4.17/dist/wysihtml5x-toolbar.min.js") ?>"></script>-->
<!-- rules defining tags, attributes and classes that are allowed -->
<!--<script src="<?php echo base_url("/js/wysihtml-0.4.17/parser_rules/advanced_and_extended.js") ?>"></script>-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url("/js/wysihtml/examples/css/stylesheet.css") ?>">-->



<!--<link rel="stylesheet" href="<?php echo base_url("/js/tinyeditor/style.css") ?>" />
<script type="text/javascript" src="<?php echo base_url("/js/tinyeditor/tinyeditor.js") ?>"></script>-->

<!--<link rel="stylesheet" type="text/css" href="http://wysihtml.com/stylesheets/main.min.css?2" />-->
<!--
<script type="text/javascript" src="http://wysihtml.com/javascripts/modernizr.js"></script>
<script type="text/javascript" src="http://wysihtml.com/javascripts/application.min.js"></script>
<script type="text/javascript" src="http://static.voog.com/libs/picturefill/latest/picturefill.min.js"></script>
-->

<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url("/js/bootstrap-wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css") ?>"></link>-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url("/js/bootstrap-wysihtml5/lib/css/bootstrap.min.css") ?>"></link>-->
<!--<script src="<?php echo base_url("/js/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js") ?>"></script>
<script src="<?php echo base_url("/js/bootstrap-wysihtml5/lib/js/jquery-1.7.2.min.js") ?>"></script>
<script src="<?php echo base_url("/js/bootstrap-wysihtml5/lib/js/bootstrap.min.js") ?>"></script>
<script src="<?php echo base_url("/js/bootstrap-wysihtml5/dist/bootstrap-wysihtml5-0.0.2.min.js") ?>"></script>-->



<!--
<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>
<script type="text/javascript">loadTinymce();</script>
-->
<script type="text/javascript" src="<?= base_url("/js/nicEdit/nicEdit.js") ?>"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() { 
        new nicEditor({
            buttonList : ['bold','italic','underline','left','right','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat','html'],
//            buttonList : ['bold','italic','underline','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat','html'],
            iconsPath : '<?=  base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
        }).panelInstance('content_text');
    })
</script>
<script src="<?=base_url("/js/e2.js")?>"></script>

<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <form action="/e2/save/" method="post"  class="form-horizontal big_label"  id="saveform" >
            <h2>{head_title}</h2> 
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label class="label_fix_space" for="content_title">Title</label>
                    <div class="controls">
                        <span></span>
                        <input type="text" name="content_title" value="{cont_page_title}" id="content_title" autocomplete="off" class="required"  placeholder="Enter text..."  minlength="2"  data-validation-required-message="Please provide a title for this slide">
                    </div>
                    <label class="label_fix_space" for="content_text">Text</label>
                    <div class="controls">
                        <span></span>
                        <textarea name="content_text" id="content_text" class="textarea_fixed mce-toolbar-grp" placeholder="Enter text..." style="height: 150px;" >{cont_page_text}</textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="control-group">
                        <h4 for="content_title">Resources</h4>
                    </div>
                    <ul class="ul1 resource {resource_hidden}">
                        {resources}
                        <li id="res_{resource_id}">
                            <a href="javascript:;" style="border-bottom:1px solid #c8c8c8;color:#111;" onclick="$(this).next().children().click()">
                                <p style="margin: 0;"><span class="icon {type}" style="margin-top: -2px;color: #c8c8c8"></span>&nbsp; {resource_name}</p>
                            </a>
                            <span class="show_resource" style="display:none;">{preview}</span>
                            <div class="r" style="float: right;margin-top: -25px;"><a href="javascript: resourceModal({resource_id})" class="remove" style="font-size: 0;;padding-right: 14px;padding-bottom: 14px;"><span class="glyphicon glyphicon-remove"></span></a></div>
                        </li>
                        {/resources}
                    </ul>
                    <div class="buttons clearfix">
                        <a class="btn b1 right" onclick="$('.is_preview').val(2); $('.hidden_submit').click()" href="javascript:;" >Add New Resource<span class="icon i3"></span></a>
                    </div>
                </div>
            </div>
            <input type="hidden" name="subject_id" value="{subject_id}" />
            <input type="hidden" name="module_id" value="{module_id}" />
            <input type="hidden" name="lesson_id" value="{lesson_id}" />
            <input id="cont_page_id" type="hidden" name="cont_page_id" value="{cont_page_id}" />
            <input type="hidden" name="is_preview" class="is_preview" value="0" />
            <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;">SAVE</button>
        </form>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <!--            <a href="#" onclick="$('[name=is_preview]').val(1); document.getElementById('saveform').submit()" class="grey_btn">Preview Slide</a>-->
            <a href="javascript:;" onclick="$('[name=is_preview]').val(0);validate()" class="red_btn">SAVE</a>
        </div>
    </div>
</footer>

<div id="popupDelRes" class="modal fade">
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
                <input type='hidden' class='res_id' value="" />
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupDel" do="1" type="button" onClick="doDelRes()" class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
