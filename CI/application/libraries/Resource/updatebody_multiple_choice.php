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
[QFILE]
                <div class="error_filesize"></div>
            </div>
        </div>
    </div>
    <div class="form-group grey no-margin" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled">Options</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="controls options">
[ANSWERS]
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

    })

    function addNewOption() {
        var co = $(".options").children().length;
        $('.options').append('<div class="option row" style="margin-left: 0; margin-right: 0;margin-bottom:10px;">'
            +'<input class="col-lg-1 col-md-1 col-sm-1 col-xs-12" type="checkbox" name="content[answer]['+co+'][true]" id="answer_true_'+co+'" data-validation-required-message="" value="1" style="width: 9%; float: left;">'
            +'<label class="col-lg-1 col-md-1 col-sm-1 col-xs-12" for="answer_true_'+co+'" style="padding-top: 17px; padding-bottom: 17px; width: 12%; float: left;"> true</label>'
            +'<input class="col-lg-3 col-md-3 col-sm-3 col-xs-12" type="text" name="content[answer]['+co+'][label]" id="answer_label_'+co+'" data-validation-required-message="" placeholder="Label" value="" style="width: 24%; float: left;">'
            +'<input class="col-lg-2 col-md-2 col-sm-2 col-xs-12" type="text" name="content[answer]['+co+'][value]" id="answer_value_'+co+'" data-validation-required-message="" placeholder="Evaluation" value="" style="width: 7%; float: left; margin-top: 0;">'
            +'<input class="col-lg-5 col-md-5 col-sm-5 col-xs-12" type="text" name="content[answer]['+co+'][feedback]" id="answer_feedback_'+co+'" data-validation-required-message="Please fill Evaluation" placeholder="Feedback" value="" style="width: 50%; float: left; margin-top: 0;" />'
            +'<span class="" id="answer_delete_'+co+'" style=" float: right; " ><a class="delete2" href="javascript:removeOption('+co+')" style="color: #e74c3c;display: inline-block; margin-top: 18px; width: 24px; height: 24px; margin-left: 3px; background: url(/img/Deleteicon_new.png) no-repeat 0 0;"></a></span>'
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