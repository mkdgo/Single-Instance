<div id="single_choice" class="form-group grey resource_type" style="padding-top:21px; margin-bottom: 11px;">
    <div class="form-group grey no-margin" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled">Introduction Image</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="controls" style="position: relative">
                <section class="progress-demo" style="padding:0 10px;height: 22px;margin-top:20px;float: left;">
                    <div id="manual-file-uploader"style="padding:10px;height: 22px;width:140px;height:40px;position:absolute;z-index:100;margin-top:0px;"></div>
                    <button class="ladda-button" data-color="blue"  data-size="s" data-style="expand-right" type="button" >Upload file</button>
                </section>
                <div class="c2_radios upload_box" style="float: left;margin-top: 20px;display: none;">
                    <input type="checkbox" id="file_uploaded_f"  value="" disabled="disabled" checked="checked">
                    <label for="file_uploaded_f" id="file_uploaded_label" style="height: 40px;width:auto!important;float: left" ></label>
                </div>
                <div class="error_filesize"></div>
            </div>
        </div>
    </div>
<!--
    <div class="form-group grey no-margin" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled">Introduction Text</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="controls">
                <span></span>
                <textarea type="text" name="content[intro][text]" id="introduction_text" data-validation-required-message="Please provide a resource file or location"></textarea>
            </div>
        </div>
    </div>

    <div class="form-group grey no-margin" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled">Question</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="controls">
                <span></span>
                <input type="text" name="content[question]" id="question" data-validation-required-message="Please provide a resource file or location" value="">
            </div>
        </div>
    </div>
-->
    <div class="form-group grey no-margin" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled">Answers Options</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="controls options">
                <div class="option row" style="margin-left: 0; margin-right: 0; margin-bottom:10px;">
                    <input class="col-lg-1 col-md-1 col-sm-1 col-xs-12" type="checkbox" name="content[answer][0][true]" id="answer_true_0" value="1" style="width: 9%; float: left;" >
                    <label class="col-lg-1 col-md-1 col-sm-1 col-xs-12" for="answer_true_0" style="padding-top: 17px; padding-bottom: 17px; width: 11%; float: left;" > true</label>
                    <input class="col-lg-3 col-md-3 col-sm-3 col-xs-12" type="text" name="content[answer][0][label]" id="answer_label_0" data-validation-required-message="Please fill Label" placeholder="Label" value="" style="width: 25%; float: left;" />
                    <input class="col-lg-2 col-md-2 col-sm-2 col-xs-12" type="text" name="content[answer][0][value]" id="answer_value_0" data-validation-required-message="Please fill Evaluation" placeholder="Evaluation" value="" style="width: 14%; float: left; margin-top: 0;" />
                    <input class="col-lg-5 col-md-5 col-sm-5 col-xs-12" type="text" name="content[answer][0][feedback]" id="answer_feedback_0" data-validation-required-message="Please fill Evaluation" placeholder="Feedback" value="" style="width: 50%; float: left; margin-top: 0;" />
                </div>
            </div>
            <div><a class="btn b1 right" href="javascript: addNewOption();">ADD OPTION<span class="icon i3"></span></a></div>
<!--            <div><span style="padding: 5px 5px 0;">Preview</span></div>
            <div id="output" style="border: 1px solid #c8c8c8; padding: 10px;"></div>-->
        </div>
    </div>

</div>
<script type="text/javascript">
    var l;
    var start_timer = 0;
    var manualuploader;

    $(document).ready(function(){
        l = Ladda.create(document.querySelector('#saveform .ladda-button'));

        manualuploader = $('#manual-file-uploader').fineUploader({
            request: {
                endpoint: '<?php echo base_url() ?>' + 'c2/resourceUpload'
            },
            multiple: false,
            validation: {
                allowedExtensions: ['jpg|JPEG|png|doc|docx|xls|xlsx|pdf|ppt|pptx|mmap|pub'],
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

        $('.upload').bind('change', function () {
            var filesize = this.files[0].size;
            if (filesize > 20000000) {
                $('.error_filesize').html('').append('<p>Please select files less than 20mb</p>');
                $('.upload').val('');
                $("#uploadFile").text('Choose file');
            }
        });

//        chnageResourceType();

    })

    function addNewOption() {
        var co = $(".options").children().length;
        $('.options').append('<div class="option row" style="margin-left: 0; margin-right: 0;margin-bottom:10px;">'
            +'<input class="col-lg-1 col-md-1 col-sm-1 col-xs-12" type="checkbox" name="content[answer]['+co+'][true]" id="answer_true_'+co+'" data-validation-required-message="" value="1" style="width: 9%; float: left;">'
            +'<label class="col-lg-1 col-md-1 col-sm-1 col-xs-12" for="answer_true_'+co+'" style="padding-top: 17px; padding-bottom: 17px; width: 11%; float: left;"> true</label>'
            +'<input class="col-lg-3 col-md-3 col-sm-3 col-xs-12" type="text" name="content[answer]['+co+'][label]" id="answer_label_'+co+'" data-validation-required-message="" placeholder="Label" value="" style="width: 25%; float: left;">'
            +'<input class="col-lg-2 col-md-2 col-sm-2 col-xs-12" type="text" name="content[answer]['+co+'][value]" id="answer_value_'+co+'" data-validation-required-message="" placeholder="Evaluation" value="" style="width: 14%; float: left; margin-top: 0;">'
            +'<input class="col-lg-5 col-md-5 col-sm-5 col-xs-12" type="text" name="content[answer]['+co+'][feedback]" id="answer_feedback_'+co+'" data-validation-required-message="Please fill Evaluation" placeholder="Feedback" value="" style="width: 50%; float: left; margin-top: 0;" /></div>')
    }
</script>