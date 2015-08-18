
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.fineuploader-3.5.0.min.js"></script>


<link rel="stylesheet" href="<?php echo base_url() ?>css/fineuploader_resources.css" type="text/css" />


<script type="text/javascript" src="<?php echo base_url() ?>js/spin.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/ladda.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>css/ladda.css" type="text/css" />


<form class="form-horizontal add_resource" id="saveform" method="post" enctype="multipart/form-data" action="/c2/save">
    <div class="blue_gradient_bg" style="min-height: 149px;">
        <div style="text-align: center; padding-top: 10px; width: 250px; height: 50px; background-color: #c72d2d; display:none;" data-dismissible="false" data-role="popup" id="saving_data" data-overlay-theme="b" data-theme="b">
            Saving Data / Uploading file...
        </div>
        <div class="breadcrumb_container">
            <div class="container">{breadcrumb}</div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php if ($saved == FALSE): ?>
                        <h2> Create New Resource</h2>
                    <?php else: ?>
                        <h2>{resource_title}</h2>
                    <?php endif ?>
                    <div class="form-group grey">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="is_remote0" class="scaled">Resource Type</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <fieldset onchange="chnageResourceType();" data-role="controlgroup" data-type="horizontal" data-role="fieldcontain" class="radio_like_button"> 
                                <input type="radio" name="is_remote" id="is_remote0" value="0" {is_remote_0}>
                                <label for="is_remote0" >Local file</label>
                                <input type="radio" name="is_remote" id="is_remote1" value="1" {is_remote_1}>
                                <label for="is_remote1">Online file</label>
                            </fieldset> 
                        </div>
                    </div>

                    <div id="resource_file" class="form-group grey"  style="display: none;height: 90px;">
                        <div class="col-lg-3 col-md-3 col-sm-sm3 col-xs-12" >
                            <label class="label_fix2 scaled" for="resource_url">Resource File</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"  >
                            <div class="controls" style="position: relative">


                                <section class="progress-demo" style="padding:0 10px;height: 22px;margin-top:20px;float: left;">
                                    <div id="manual-fine-uploader"style="padding:10px;height: 22px;width:140px;height:40px;position:absolute;z-index:100;margin-top:0px;"></div>
                                    <button class="ladda-button" data-color="blue"  data-size="s" data-style="expand-right" type="button" >Browse file</button>
                                </section>

                                <div class="c2_radios upload_box" style="float: left;margin-top: 20px;display: none;">
                                    <input type="checkbox"  id="file_uploaded_f"  value="" disabled="disabled" checked="checked">
                                    <label for="file_uploaded_f" id="file_uploaded_label" style="height: 40px;width:auto!important;float: left" ></label>
                                </div>

                                <div class="error_filesize"></div>
                            </div>
                            {resource_exists} 
                        </div>
                    </div>

                    <div id="resource_remote" class="form-group grey " style="height: 90px;padding-top:21px;">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="resource_link" class="scaled">Resource URL</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="controls">
                                <span></span>
                                <input type="text" name="resource_link" id="resource_link" data-validation-required-message="Please provide a resource file or location" value="{resource_link}">
                            </div>
                        </div>
                    </div>

                    <div id="resource_remote" class="form-group grey no-margin">
                        <hr width="95%" style="margin: 0 auto"/>
                    </div>
                    <div class="form-group grey no-margin">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="resource_title" class="scaled">Title</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="controls">
                                <span></span>
                                <input type="text" id="resource_title" name="resource_title" class="required"  data-validation-required-message="Please provide a title for this resource" value="{resource_title}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group grey no-margin">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label class="scaled">Description</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="controls">
                                <span></span>
                                <textarea id="resource_desc" class="textarea_fixed required" data-autoresize  name="resource_desc" data-validation-required-message="Please provide a detailed description for this resource"  placeholder="Write a description">{resource_desc}</textarea>
                            </div>



                        </div>
                    </div>
                    <div class="form-group grey no-margin " >
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="resource_keywords" class="scaled">Keywords</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="keywords" id="keywords">
                                <input type="text" id="resource_keywords"  name="resource_keywords"  value="{resource_keywords}" style="display: none;">
                                <input type="hidden" id="resource_keywords_a" name="resource_keywords_a" >
                                <!-- <textarea id="resource_keywords_a" name="resource_keywords_a" style="border: solid 1px #999; width:814px; height: 40px;"></textarea> -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group grey no-margin">
                        <div class="c2_radios">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label class="scaled">Available to</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="clear"></div>
                                <?php foreach ($year_restriction as $restrction): ?>
                                    <input type="checkbox" name="year_restriction[]" id="year_restriction_<?php echo $restrction['year'] ?>" value="<?php echo $restrction['year'] ?>" <?php if (in_array($restrction['year'], $restricted_to) || $new_resource) echo 'checked="checked"' ?>><label for="year_restriction_<?php echo $restrction['year'] ?>">Year <?php echo $restrction['year'] ?></label>
                                <?php endforeach ?>
                                {classes}
                                <label><input type="checkbox" name="year_restriction[]" id="{id}" value="{id}" {checked}/>Class {year}{group_name}</label>
                                {/classes}
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <input type="hidden" name="type" value ="{type}" />
                    <input type="hidden" name="elem_id" value ="{elem_id}" />
                    <input type="hidden" name="subject_id" value ="{subject_id}" />                         
                    <input type="hidden" name="module_id" value ="{module_id}" />
                    <input type="hidden" name="lesson_id" value ="{lesson_id}" />
                    <input type="hidden" name="assessment_id" value ="{assessment_id}" />
                    <input type="hidden" name="file_uploaded" id="file_uploaded" value ="" />
                    <input type="hidden" class="new_upload" value ="" />

                </div>
            </div>
            <div class="form-group grey no-margin" style="padding:30px 0 30px 0">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label class="scaled">Preview</label>
                </div>

                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8"  <?php if($this->uri->segment('3') !='0'){?>style="width:870px;height:470px;overflow: hidden" <?php } ?>>

                    {preview}
                </div>
            </div>
        </div>
    </div>
</form>
<div class="clear" style="height: 1px;"></div>
<div id="message" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<prefooter>
    <div class="container"></div>
</prefooter>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="javascript:void(0);" onclick="cancel_resource();" class="cancel_btn">CANCEL</a>
            <a href="javascript:void(0);" onclick="saveResource();" class="red_btn">SAVE</a>

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
<script type="text/javascript">

<?php
$error_msg = $this->session->flashdata('error_msg');
if ($error_msg != '') {
    ?>
        $(document).ready(function () {
            message = '<?php echo $error_msg; ?>';
            showFooterMessage({mess: message, clrT: '#6b6b6b', clr: '#fcaa57', anim_a: 2000, anim_b: 1700});
        })
<?php } ?>

    function update_text() {
        var t = $('.upload').val();
        var filename = t.replace(/^.*\\/, "");
        $("#uploadFile").text(filename);

    }
    $('.upload').bind('change', function () {
        var filesize = this.files[0].size;
        if (filesize > 20000000) {
            $('.error_filesize').html('').append('<p>Please select files less than 20mb</p>');
            $('.upload').val('');
            $("#uploadFile").text('Choose file');
        }
    });

    function chnageResourceType() {
        if ($('#saveform input[name=is_remote]:checked').val() == 1) {
<?php if ($saved == FALSE): ?>
                $('#saveform #resource_url').removeClass('required');
                $('#saveform #resource_link').addClass('required');
<?php endif ?>

            $('#saveform #resource_file').hide();
            $('#saveform #resource_remote').show();
        } else {
            $('#saveform #resource_file').show();
            $('#saveform #resource_remote').hide();
<?php if ($saved == FALSE): ?>
                $('#saveform #resource_url').addClass('required');
                $('#saveform #resource_link').removeClass('required');
<?php endif ?>
        }
    }

    chnageResourceType();

    function saveResource() {
        if ($('#resource_link').hasClass("required")) {
            if (!isValidURL($('#resource_link').val())) {
                $('#resource_link').css({'border': '1px dashed red'});
                var msg = 'Resource URL is not valid!';
                $('#resource_link').prev('span').attr('id', 'scrolled');
                $('#resource_link').prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display': 'block'});
                $('html, body').animate({scrollTop: $('#scrolled').stop().offset().top - 500}, 300);
                $('#resource_link').prev('span').removeAttr('scrolled');
                return false;
            }
        }
        validate_resource();
    }

    function isValidURL(url) {
        var RegExp = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/i

        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script type="text/javascript">

    var l = Ladda.create(document.querySelector('#saveform .ladda-button'));
    var start_timer = 0;
    var manualuploader = $('#manual-fine-uploader').fineUploader({
        request: {
            endpoint: '<?php echo base_url() ?>' + 'c2/resourceUpload'
        },
        multiple: false,
        validation: {
            allowedExtensions: ['jpg|JPEG|png|doc|docx|xls|xlsx|pdf|ppt|pptx'],
            sizeLimit: 22120000, // 20000 kB -- 20mb max size of each file
            itemLimit: 40
        },
        showMessage: function (message) {
            $('.modal-body').html('').append('<div class="alert-error">' + message + '</div>');
            $('#popupError').modal('show');
        },
        //listElement: document.getElementById('files'),
        messages: {
            typeError: "An issues was experienced when uploading this file.  Please check the file and then try again.  If the problem persists, it may be a file that can't be uploaded."
        },
        autoUpload: true,
        text: {
            uploadButton: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />&nbsp;&nbsp;&nbsp;&nbsp;'
        }
    }).on('progress', function (event, id, filename, uploadedBytes, totalBytes) {
        if (start_timer == 0) {
            $('#saveform .ladda-label').text('Uploading File');
            $('#saveform #file_uploaded').val('');
            $('#saveform #file_uploaded_label').text('');
            $('#saveform .upload_box').fadeOut(200);
            l.start();
        }

        start_timer++;
        var progressPercent = (uploadedBytes / totalBytes).toFixed(2);

        if (isNaN(progressPercent)) {
            $('#saveform #progress-text').text('');
        } else {
            var progress = (progressPercent * 100).toFixed();
            l.setProgress((progress / 100));
            if (uploadedBytes == totalBytes) {
                l.stop();
            }
        }
    }).on('complete', function (event, id, file_name, responseJSON) {
        start_timer = 0;
        if (responseJSON.success) {
            $('#saveform .ladda-label').text('File Uploaded');
            $('#saveform #file_uploaded').val(responseJSON.name);
            $('#saveform #file_uploaded_label').text(file_name);
            $('#saveform .upload_box').fadeIn(700);

            $('#saveform .new_upload').val(responseJSON.name);

        }
    });
    function cancel_resource()
    {
        if($('#saveform .new_upload').val().length>0)
        {
           var filename = $('#saveform .new_upload').val();
            data={filename:filename}
            $.ajax({
                url: '<?php echo base_url()?>c2/delete_file',
                data:data,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    window.location.href = '<?php echo base_url()?>c1'
                    }
                });
        }
        else
        {
            window.location.href = '<?php echo base_url()?>c1'
        }
    }

</script>


<script type="text/javascript" src="<?= base_url("/js/crypt/aes.js") ?>"></script>
<script src="<?= base_url("/js/crypt/upload.js") ?>"></script>  
