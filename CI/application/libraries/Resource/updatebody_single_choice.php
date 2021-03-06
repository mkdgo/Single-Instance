<div id="single_choice" class="form-group grey resource_type" style="height: 90px;">
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
            <span></span>
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
    var count_true = 0;

    $(document).ready(function(){
        l = Ladda.create(document.querySelector('#saveform .ladda-button'));

        manualuploader = $('#manual-file-uploader').fineUploader({
            request: {
                endpoint: '<?php echo base_url() ?>' + 'c2n/resourceUpload?res_id='+res_id
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

/*        $('.option input[type="checkbox"]').bind('click',function(e) {
console.log(count_true);
if( count_true > 1 ) {
    e.preventDefault();
//    $(this).attr("checked",false);
    $(this).prop("checked",false);
    return;
}
        })
*/
    })

    function addNewOption() {
        var co = $(".options").children().length;
        $(".options").prev('span.tip2').fadeOut('3333');
        $(".options").css({"border-color": "#f5f5f5","border-width":"1px","border-style":"solid"})
        $('.options').append('<div class="option row" style="margin-left: 0; margin-right: 0;margin-bottom:10px;">'
            +'<input onclick="setCheck(this)" class="col-lg-1 col-md-1 col-sm-1 col-xs-12 set-answer-true" type="checkbox" name="content[answer]['+co+'][true]" id="answer_true_'+co+'" data-validation-required-message="" value="1">'
            +'<label class="col-lg-1 col-md-1 col-sm-1 col-xs-12 set-answer-true-label" for="answer_true_'+co+'">true</label>'
            +'<input class="col-lg-3 col-md-3 col-sm-3 col-xs-12 set-answer-label" type="text" name="content[answer]['+co+'][label]" id="answer_label_'+co+'" data-validation-required-message="" placeholder="Option" value="">'
            +'<input class="col-lg-2 col-md-2 col-sm-2 col-xs-12 set-answer-value" type="text" name="content[answer]['+co+'][value]" id="answer_value_'+co+'" data-validation-required-message="" placeholder="Score" value="">'
            +'<input class="col-lg-5 col-md-5 col-sm-5 col-xs-12 fb set-answer-feedback" type="text" name="content[answer]['+co+'][feedback]" id="answer_feedback_'+co+'" data-validation-required-message="Please fill Evaluation" placeholder="Automated Feedback" value="" />'
            +'<span class="set-answer-delete-span" id="answer_delete_'+co+'" ><a class="delete2 set-answer-delete" href="javascript:removeOption('+co+')"></a></span>'
            +'</div>');

        $('#answer_label_'+co).focus();
    }
    function setCheck(el) {
        var checked = $(el).is(':checked');
        var fb = $(el).siblings( ".fb" );
           
        $(".option input[type='checkbox']").attr('checked',false);
        $(".option input[type='checkbox']").each(function() {
            if( $(this).siblings( ".fb" ).val() == 'Well done.' ) {
                $(this).siblings( ".fb" ).val('');
            }
        })
        if(checked) {
            $(el).prop("checked", true);
            if( $(fb).val().length == 0 ) {
                $(fb).val('Well done.');
            }
        }
    }
    function removeOption(id) {
        $('#answer_label_'+id).parent().remove();
    }

</script>
