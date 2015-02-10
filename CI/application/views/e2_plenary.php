<link rel="stylesheet" href="<?= base_url("/css/e2_plenary.css") ?>" type="text/css"/>
<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <form action="/e2_plenary/save/" method="post"  class="big_label"  id="e2_plenary" >
            <h2>{head_title}</h2> 
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="control-group">
                        <label class="label_fix2" for="content_title">Title</label>
                        <div class="controls">
                            <span></span>
                            <input type="text" name="content_title" value="{cont_page_title}" id="content_title" autocomplete="off" class="required"  placeholder="Enter text..."  minlength="10"  data-validation-required-message="Please provide a title for this slide">
                        </div>
                    </div>
                    <label class="label_fix2" for="content_text">Text</label>
                    <div class="controls">
                        <span></span>
                        <textarea name="content_text" id="content_text" class="textarea_fixed mce-toolbar-grp" placeholder="Enter text..." >{cont_page_text}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-sm-offset-2">
                    <div class="launch_lesson_wrap">
                        <h3>&nbsp;Plenaries</h3>
                        <fieldset data-role="controlgroup" class="checkbox_fw">
                            {available_plenaries}
                            <input type="checkbox" name="available_plenaries[]" id="plenary-{id}" value="{id}" {checked} />
                            <label for="plenary-{id}">{label}</label>
                            {/available_plenaries}
                        </fieldset>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="subject_id" value="{subject_id}" />
            <input type="hidden" name="module_id" value="{module_id}" />
            <input type="hidden" name="lesson_id" value="{lesson_id}" />
            <input type="hidden" name="cont_page_id" value="{cont_page_id}" />
            <input type="hidden" name="is_preview" value="0" />
            <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;">SAVE</button>

        </form>
    </div>
</div>
<footer>
    <div class="container clearfix">
        <div class="left unvisible">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <!--            <a href="#" onclick="$('[name=is_preview]').val(1); document.getElementById('saveform').submit()" class="grey_btn">Preview Slide</a>-->
            <a href="javascript:;" onclick="$('[name=is_preview]').val(0);validate()" class="red_btn">SAVE</a>
        </div>
    </div>
</footer>
    
  
    