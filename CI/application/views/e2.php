<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>
<script type="text/javascript">loadTinymce();</script>
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
                        <textarea name="content_text" id="content_text" class="textarea_fixed mce-toolbar-grp" placeholder="Enter text..." >{cont_page_text}</textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="control-group">
                        <label class="label_fix_space" for="content_title">Resources</label>
                    </div>
                    <ul class="ul3_resource  {resource_hidden}">
                        {resources}
                        <li><a href="javascript:;" onclick="$(this).next().children().click()"><p><span class="icon {type}"></span>&nbsp; {resource_name}</p></a>
                            <span class="show_resource" style="display:none;">{preview}</span>

                        </li>

                        {/resources}
                    </ul>
                    <div class="buttons clearfix">
                        <a class="btn b1 right" onclick="$('.is_preview').val(2); $('.hidden_submit').click()" href="javascript:;">Add New Resource<span class="icon i3"></span></a>
                    </div>
                </div>
            </div>
            <input type="hidden" name="subject_id" value="{subject_id}" />
            <input type="hidden" name="module_id" value="{module_id}" />
            <input type="hidden" name="lesson_id" value="{lesson_id}" />
            <input type="hidden" name="cont_page_id" value="{cont_page_id}" />
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
    
  
    