<script type="text/javascript" src="<?php echo base_url() ?>res/js/jquery.selection.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>res/js/nicEdit/nicEdit.js"></script>
<div id="mark_the_words" class="form-group grey resource_type" style="padding-top:21px; margin-bottom: 11px;">
    <div class="form-group grey no-margin" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled">Question Image</label>
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
                <textarea style="overflow: auto;" type="text" name="content[question]" id="question" data-validation-required-message="Please provide a resource file or location" value=""></textarea>
            </div>
        </div>
    </div>
-->
    <div class="form-group grey no-margin" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled">Answer</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="controls ">
                <div class="option">
                    <span class="tiny-txt"></span>
<!--                    <textarea name="answer" id="answer" class="textarea_fixed resizable" minlength="30" style="height: 150px;" onselect="selectWord()"></textarea>-->
                    <textarea style="height: 150px; overflow: auto;" name="content[target]" id="target" class="textarea_fixed resizable" onkeyup="sendCode(-1)"></textarea>
                </div>
            </div>
            <div style="display: inline-block; width: 100%;margin-top: 10px;">
<!--            <button onclick="toggleArea1();">Toggle DIV Editor</button>-->
                <a class="btn b1 right" href="javascript: selectWord();">HIGHLIGHT WORD<span class="icon i3"></span></a>
            </div>
            <div><span style="padding: 5px 5px 0;">Preview</span></div>
            <div id="output" style="border: 1px solid #c8c8c8; padding: 10px;"></div>
        </div>
    </div>

    <div class="form-group grey no-margin" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled"></label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="controls options"></div>
        </div>
    </div>

</div>
<script type="text/javascript">
    var l;
    var start_timer = 0;
    var manualuploader;
//    var co = 0;
    var opts = [];

    $(document).ready(function(){
        l = Ladda.create(document.querySelector('#saveform .ladda-button'));

        manualuploader = $('#manual-file-uploader').fineUploader({
            request: {
                endpoint: '<?php echo base_url() ?>' + 'c2/resourceUpload'
            },
            multiple: false,
            validation: {
                allowedExtensions: ['jpg|JPEG|png'],
                sizeLimit: 22120000, // 20000 kB -- 20mb max size of each file
                itemLimit: 40
            },
            showMessage: function (message) {
                $('.modal-body').html('').append('<div class="alert-error">' + message + '</div>');
                $('#popupError').modal('show');
            },
            //listElement: document.getElementById('files'),
            messages: {
                typeError: "An issues was experienced when uploading this file. Please check the file and then try again. If the problem persists, it may be a file that can't be uploaded."
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
    })

    function addNewOption(seltxt) {
        var co = $(".options").children().length;
        if(co == 0) {
            co++;
            $('.options').append('<div>'
                +'<span style="float: left; width: 9%">&nbsp;</span>'
                +'<span class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: center; width: 29%;">Hotspot Word</span>'
                +'<span class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="text-align: center; width: 10%;">Score</span>'
                +'<span class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="text-align: center; width: 50%;">Feedback</span>'
                +'</div>');
        }
//console.log('add');
//console.log(co);
        $('.options').append('<div class="option row" style="margin-left: 0; margin-right: 0; margin-bottom:10px;">'
            +'<span style="float: left; margin-right: 10px;padding: 16px 0;line-height: 28px;">[word'+co+']</span>'
            +'<input class="col-lg-8 col-md-8 col-sm-8 col-xs-12" type="text" name="content[answer]['+co+'][label]" id="answer_label_'+co+'" data-validation-required-message="" placeholder="Label" value="'+seltxt+'" style="width: 31%; float: left;">'
            +'<input class="col-lg-4 col-md-4 col-sm-4 col-xs-12" type="text" name="content[answer]['+co+'][value]" id="answer_value_'+co+'" data-validation-required-message="" placeholder="Evaluation" value="1" style="width: 10%; float: left; margin-top: 0;"><input type="hidden" id="answer_pos_'+co+'" name="content[answer]['+co+'][position]" value="">'
            +'<input class="col-lg-8 col-md-8 col-sm-8 col-xs-12" type="text" name="content[answer]['+co+'][feedback]" id="answer_feedback_'+co+'" data-validation-required-message="" placeholder="Label" value="" style="width: 50%; float: left; margin-top: 0;">'
            +'</div>')
    }

    function selectWord() {
        var co = $(".options").children().length;
        if(co == 0) {co++;}
//console.log('sel');
//console.log(co);
        el = $('#target');
        var selectedText = el.selection('get');
        if(selectedText.length == 0 ) { return false; }
        var selectedPosition = el.selection('getPos');
        addNewOption(selectedText);
        insertSpan(el,co);

        el.selection('replace', {text: '[word'+co+']'})
/*
        if( count_options >= 0 ) {
            var txt = el.val();
            count_options = count_options+1;
            for( i=0; i < count_options; i++ ) {
                var txt1 = txt.replace('[a'+i+']', '<span style="color:#ccc">'+selectedText+'</span>');
                txt = txt1;
            }
        } else {
            txt1 = input.value;
        }
        output.innerHTML = txt1;
//*/
//alert( el.val() );
//alert(selectedPosition.start + ' - '  + selectedPosition.end );
//console.log( $(selectedText).outerHTML );
    }

    function insertSpan(el, co) {
        if(co == 0) {co++;}
//        opts = el.selection('get');
        el.selection('replace', {text: '[word'+co+']'});
//        el.selection('insert', {text: '[a'+co, mode: 'before'});
//        el.selection('insert', {text: ']', mode: 'after'});
/*        el.selection('insert', {text: '<span id="a'+co+'" style="color:#333;">', mode: 'before'});
        el.selection('insert', {text: '</span>', mode: 'after'});*/
        sendCode(co);
    }

    
    
    

    var input = document.getElementById("target");
    var output = document.getElementById("output");

    function sendCode(co){

        var words = input.value.split(" ");
        var atxt = [];
        $("#output").empty();
        $.each(words, function(i, v) {
            atxt[i] = '<span id="w'+i+'" class="">'+v+'</span>';
            l = v.length;
            s = v.substring( 0, 5);
            n = parseInt(v.slice(5,l));

            if( s == '[word' ) {
                $('#answer_pos_'+(n)).val(i);
            }
        });
        var tmp_txt = atxt.join(' ');
        if( co >= 0 ) {
            $.each(atxt, function(i, v) {
                var txt1 = tmp_txt.replace('[word'+(i+1)+']', '<span style="background: #ff0;" >'+$('#answer_label_'+(i+1)).val()+'</span>');
                tmp_txt = txt1;
            })
        }

        $('#output').html(tmp_txt);
    }

    
    
    
    
    
    
    
/* About nicEditor */
var area1;
var editor;
function makeEditor(){
    toggleArea1();
}
function toggleArea1() {
    if(!area1) {
        area1 = new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','fontSize','fontFamily'],
        }).panelInstance('answer');
    } else {
        area1.removeInstance('answer');
        area1 = null;
    }
  }
</script>
