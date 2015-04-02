
{widget_assets}

<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
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

            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
               {page_content_html}





            </div>

        </div>


            <div id="manual-fine-uploader" class="btn btn-primary" style="margin-top: 10px;margin-bottom: 50px;padding-top: 5px;">

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
        <div class="right" id="app_here">


        </div>
        <div class="clear"></div>
    </div>
</footer>

{inline_scripting}

<script type="text/javascript" src="<?php echo base_url()?>widgets_assets/image_hotspots/js/jquery.fineuploader-3.5.0.min.js"></script>

<script type="text/javascript">
    var base_url = '<?php echo base_url()?>';
    $(document).ready(function() {
        var manualuploader = $('#manual-fine-uploader').fineUploader({
            request: {
                endpoint: '<?php echo base_url()?>widgets/image_hotspots/upload_pic'
            },
            multiple: false,
            validation: {
                allowedExtensions: ['jpg|jpeg|png'],
                sizeLimit: 9120000, // 9000 kB -- 9mb max size of each file
                itemLimit:  1
            },
            autoUpload: true,
            text: {
                uploadButton: 'Upload background'
            }
        }).on('complete', function(event, id, file_name, responseJSON) {
            if (responseJSON.success) {


                $('.bg_img').attr('src',base_url+'uploads_widgets/image_hotspots/'+responseJSON.file_name);
                $('.back_pic').val(responseJSON.file_name);


            };
            $('#triggerUpload').click(function() {
                manualuploader.fineUploader('uploadStoredFiles');
            });
        });






    });
</script>



