<!--<span class="glyphicon glyphicon-bold"></span>-->
<div class="blue_gradient_bg">
    <div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>
    <div class="container">
        <form action="/e2/save/" method="post" class="form-horizontal big_label" id="saveform" >
            <input type="hidden" name="subject_id" value="{subject_id}" />
            <input type="hidden" name="year_id" value="{year_id}" />
            <input type="hidden" name="module_id" value="{module_id}" />
            <input type="hidden" name="lesson_id" value="{lesson_id}" />
            <input type="hidden" id="cont_page_id" name="cont_page_id" value="{cont_page_id}" />
            <input id="is_preview" type="hidden" name="is_preview" class="is_preview" value="0" />
            <h2>{head_title}</h2>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 5px;">
                    <label class="label_fix_space" for="content_title" style="line-height: 48px;">Title</label>
                    <div class="controls">
                        <span></span>
                        <input type="text" name="content_title" value="{cont_page_title}" id="content_title" autocomplete="off" class="required"  placeholder="Enter text..."  minlength="2"  data-validation-required-message="Please provide a title for this slide">
                    </div>
                    <label class="label_fix_space" for="content_text" style="line-height: 48px;">Text</label>
                    <div class="controls">
                        <span></span>
                        <textarea name="content_text" id="content_text" class="textarea_fixed mce-toolbar-grp" placeholder="Enter text..." style="height: 150px;" >{cont_page_text}</textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="control-group">
                        <h4 for="content_title">Resources</h4>
                    </div>
                    <ul class="sortable ul1 resource {resource_hidden}">
                        {resources}
                        <li id="res_{resource_id}">
                            <span class="drag"></span>
                            <a href="javascript:;" onclick="$(this).next().children().click()">
                                <p>{icon_type}&nbsp; {resource_name}</p>
                            </a>
                            <span class="show_resource" style="display:none;">{preview}</span>
                            <div class="r"><a href="javascript: resourceModal({resource_id})" class="remove" style="font-size: 0;;padding-right: 14px;padding-bottom: 14px;"><span class="glyphicon glyphicon-remove"></span></a></div>
                        </li>
                        {/resources}
                    </ul>
                    <div class="buttons clearfix">
                        <a class="btn b1 right" onclick="$('#is_preview').val(2); $('.hidden_submit').click()" href="javascript:;" >Add New Resource<span class="icon i3"></span></a>
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;" onclick="$('#saveform').submit()">SAVE</button>
        </form>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <!--            <a href="#" onclick="$('[name=is_preview]').val(1); document.getElementById('saveform').submit()" class="grey_btn">Preview Slide</a>-->
            <a href="javascript:;" onclick="$('#is_preview').val(0);validate()" class="red_btn">SAVE</a>
        </div>
    </div>
</footer>
<div id="popupError" class="modal fade">
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
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CLOSE</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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

<script type="text/javascript">
    $(document).ready(function() {
        bkLib.onDomLoaded(function() { 
            new nicEditor({
                buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
    //            iconsPath : '<?php  //base_url("/js/nicEdit/nicEditorIcons_1.gif") ?>'
            }).panelInstance('content_text');
        })
    })
    
    function submitSave() {
        
    }
</script>

