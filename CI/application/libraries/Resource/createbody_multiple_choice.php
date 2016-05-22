<div id="multiple_choice" class="form-group grey resource_type" style="height: 90px;">
    <div class="form-group grey no-margin" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled">Question Image</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="controls" style="position: relative;">
                <section class="progress-demo" style="padding:0 0px;height: 22px;margin-top:10px;float: left;">
                    <div id="manual-file-uploader"style="padding:10px;height: 22px;width:140px;height:40px;position:absolute;z-index:100;margin-top:0px;"></div>
                    <button class="ladda-button" data-color="blue"  data-size="s" data-style="expand-right" type="button" >Upload file</button>
                </section>
                <div class="c2_radios upload_box" style="float: left;margin: 10px;display: none;">
                    <input type="hidden" name="content[intro][file]" id="file_uploaded" value ="" />
                    <input type="checkbox" id="file_uploaded_f"  value="" disabled="disabled" checked="checked">
                    <label for="file_uploaded_f" id="file_uploaded_label" ></label>
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
            <label for="resource_link" class="scaled">Options</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="controls options">
                <div class="option row" style="margin-right: 0; margin-left: 0; margin-bottom:10px;">
                    <input onclick="setCheck(this)" class="col-lg-1 col-md-1 col-sm-1 col-xs-12 set-answer-true" type="checkbox" name="content[answer][0][true]" id="answer_true_0" value="1" >
                    <label class="col-lg-1 col-md-1 col-sm-1 col-xs-12 set-answer-true-label" style="margin-left: 0 !important;" for="answer_true_0" >true</label>
                    <input class="col-lg-3 col-md-3 col-sm-3 col-xs-12 set-answer-label" type="text" name="content[answer][0][label]" id="answer_label_0" data-validation-required-message="Please fill Label" placeholder="Option" value="" />
                    <input class="col-lg-2 col-md-2 col-sm-2 col-xs-12 set-answer-value" type="text" name="content[answer][0][value]" id="answer_value_0" data-validation-required-message="Please fill Evaluation" placeholder="Score" value="" />
                    <input class="col-lg-5 col-md-5 col-sm-5 col-xs-12 fb set-answer-feedback" type="text" name="content[answer][0][feedback]" id="answer_feedback_0" data-validation-required-message="Please fill Evaluation" placeholder="Automated Feedback" value="" />

<!--                    <span></span>
                    <input class="col-lg-2 col-md-2 col-sm-2 col-xs-16" type="text" name="content[answer][0][label]" id="answer_label_0" data-validation-required-message="Please fill Label" placeholder="Label" value="" style="width: 200px; float: left;" />
                    <input class="col-lg-2 col-md-2 col-sm-2 col-xs-16" type="text" name="content[answer][0][value]" id="answer_value_0" data-validation-required-message="Please fill Evaluation" placeholder="Evaluation" value="" style="width: 200px; float: left; margin-top: 0;" />
                    <input type="checkbox" name="content[answer][0][true]" id="answer_true_0" value="1">
                    <label for="answer_true_0" style="padding-top: 17px; padding-bottom: 17px;"> true</label>-->
                </div>
            </div>
            <div><a class="btn b1 right" href="javascript: addNewOption();">ADD OPTION<span class="icon i3"></span></a></div>
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
                endpoint: '<?php echo base_url() ?>' + 'c2n/resourceUpload'
            },
            multiple: false,
            validation: {
                allowedExtensions: ['jpg|JPEG|png|pdf'],
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
                $('#saveform #file_uploaded_label').html(responseJSON.preview+file_name+'</a>');
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
/*
        $('.option input[type="checkbox"]').click(function() {
            if( $(this).is(":checked") ) {
                var fb = $(this).siblings( ".fb" );
                $($(this).siblings( ".fb" )).val('Well done.');
            } else {
                $(this).siblings( ".fb" ).val('');
            }
        })
*/
    })

    function addNewOption() {
        var co = $(".options").children().length;
        $('.options').append('<div class="option row" style="margin-left: 0; margin-right: 0;margin-bottom:10px;">'
            +'<input onclick="setCheck(this)" class="col-lg-1 col-md-1 col-sm-1 col-xs-12 set-answer-true" type="checkbox" name="content[answer]['+co+'][true]" id="answer_true_'+co+'" data-validation-required-message="" value="1">'
            +'<label class="col-lg-1 col-md-1 col-sm-1 col-xs-12 set-answer-true-label" style="margin: 0px 10px 0px 0px !important" for="answer_true_'+co+'">true</label>'
            +'<input class="col-lg-3 col-md-3 col-sm-3 col-xs-12 set-answer-label" type="text" name="content[answer]['+co+'][label]" id="answer_label_'+co+'" data-validation-required-message="" placeholder="Option" value="">'
            +'<input class="col-lg-2 col-md-2 col-sm-2 col-xs-12 set-answer-value" type="text" name="content[answer]['+co+'][value]" id="answer_value_'+co+'" data-validation-required-message="" placeholder="Score" value="">'
            +'<input class="col-lg-5 col-md-5 col-sm-5 col-xs-12 fb set-answer-feedback" type="text" name="content[answer]['+co+'][feedback]" id="answer_feedback_'+co+'" data-validation-required-message="Please fill Evaluation" placeholder="Automated Feedback" value="" />'
            +'<span class="set-answer-delete-span" id="answer_delete_'+co+'" ><a class="delete2 set-answer-delete" href="javascript:removeOption('+co+')"></a></span>'
            +'</div>');
            $('#answer_label_'+co).focus();
    }

    function setCheck(el) {
        var feedback = $(el).siblings( ".fb" );
        if( $(el).is(":checked") ) {
            if( $(feedback).val() == '' ) {
                $(feedback).val('Well done.');
            }
        } else {
            if( $(feedback).val() == 'Well done.' ) {
                $(feedback).val('');
            }
        }
    }
    function removeOption(id) {
        $('#answer_label_'+id).parent().remove();
    }
</script>
