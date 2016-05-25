<script type="text/javascript" src="<?php echo base_url() ?>res/js/jquery.selection.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>res/js/nicEdit/nicEdit.js"></script>
<div id="fill_in_the_blank" class="form-group grey resource_type" style="height: 90px;">
    <div class="form-group grey no-margin" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled">Question Image</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="controls" style="position:">
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
            <label for="resource_link" class="scaled">Answers Options</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="controls ">
                <span></span>
                <div class="option">
                    <span class="tiny-txt"></span>
<!--                    <textarea name="answer" id="answer" class="textarea_fixed resizable" minlength="30" style="height: 150px;" onselect="selectBlank()"></textarea>-->
                    <textarea style="height: 150px; overflow: auto;" name="content[target]" id="target" class="textarea_fixed resizable" onkeyup="sendCode(-1)">[TARGET]</textarea>
                </div>
            </div>
            <div style="display: inline-block; width: 100%;margin-top: 10px;">
<!--            <button onclick="toggleArea1();">Toggle DIV Editor</button>-->
                <a class="btn b1 right" href="javascript: selectBlank();">MAKE BLANK<span class="icon i3"></span></a>
            </div>
            <div><span style="padding: 5px 5px 0;">Preview</span></div>
            <div id="output" style="border: 1px solid #c8c8c8; padding: 10px;">[PREVIEW]</div>
        </div>
    </div>

    <div class="form-group grey no-margin" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled"></label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div id="controls-head" class="controls" style="display:none">
                <div>
                    <span style="float: left; margin-right: 10px; width: 8%">&nbsp;</span>
                    <span class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="text-align: center; width: 27%;">Correct Text</span>
                    <span class="col-lg-1 col-md-1 col-sm-1 col-xs-12" style="text-align: center; width: 10%;">Score</span>
                    <span class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: center; width: 48%;">Feedback</span>
                </div>
            </div>
            <div class="controls options">
                [ANSWERS]
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    var l;
    var start_timer = 0;
    var manualuploader;

    var countBLANKS = [COUNT_ANSWERS];
    var jsonBLANKS = [JSON_ANSWERS];
    var arrWORDS = [];


    function blank(label, value, feedback, position, marked) {
        this.label = label;
        this.value = value;
        this.feedback = feedback;
        this.position = position;
        this.marked = marked;
    }

    function initBlanks() {
        var input = document.getElementById("target");

        var words = input.value.trim();
        words = words.split(/\n+|\s+/g);
        var atxt = [];
        var b = 0;
        $("#output").empty();
        $.each(words, function(i, v) {
            if( v !== '' ) {
                v = v.replace('.','');
                v = v.replace(',','');
                v = v.replace('!','');
                v = v.replace('?','');
                if( arrWORDS[b] == undefined ) {
                    arrWORDS[b] = new blank(v,1,'',b,0);
                } else {
                    arrWORDS[b].label = v;
                }
                b++;
            }
        });
        $.each(arrWORDS, function(i, v) {
            patern = /\[\b/i;
            if( patern.test(v.label) ) {
                v.marked = 1;
                v.label = v.label.replace('[','');
                v.label = v.label.replace(']','');
                v.label = v.label.replace('.','');
                v.label = v.label.replace(',','');
                v.label = v.label.replace('!','');
                v.label = v.label.replace('?','');
            }
        })
        $.each(jsonBLANKS, function(i, v) {
            arrWORDS[v.position].feedback = v.feedback;
            arrWORDS[v.position].value = v.value;
        });

        renderOptions();
        renderPreview()

    }


    function renderPreview() {
        var str = $("#target").val().trim();
        var output = $("#output");
        output.html('');
        var txt = '';
        var n = 1;

        words = str.split(/\n+|\s+/g);
        $.each(words, function(i, v) {
            patt = /\[\b/i;
            res = patt.test(v);
            if( res == true ) {
                v = v.replace('[','');
                v = v.replace(']','');
                v = v.replace('.','');
                v = v.replace(',','');
                v = v.replace('!','');
                v = v.replace('?','');
                v = v.replace(':','');

                str = str.replace( '['+v+']', '<input type="text" disabled="disabled" value=""" name="a'+n+'" style="width:100px;display: inline-block;padding:0px; background: #eee;" />');
                n++;
            }
        })
        str = str.replace(/\n/g, '<br />');
        output.html( str.trim() );
    }

    function renderOptions() {
        var input = document.getElementById("target");
        var output = document.getElementById("output");
        var n = 1;
        $('.options').html('');
        countBLANKS = 0;
        $.each(arrWORDS, function(i, v) {
            if( v.marked == 1 ) {
                $('.options').append('<div class="option row" style="margin-left: 0; margin-right: 0; margin-bottom:10px;">'
                    +'<input type="hidden" name="content[answer]['+n+'][position]" id="answer_position_'+n+'"  value="'+v.position+'" >'
                    +'<span class="set-answer-blank">[blank'+n+']</span>'
                    +'<input class="col-lg-4 col-md-4 col-sm-4 col-xs-12 set-answer-label-blank" type="text" name="content[answer]['+n+'][label]" id="answer_label_'+n+'" data-validation-required-message="" placeholder="Label" value="'+v.label+'">'
                    +'<input onkeyup="setValue(this,'+v.position+')" class="col-lg-1 col-md-1 col-sm-1 col-xs-12 set-answer-value" type="text" name="content[answer]['+n+'][value]" id="answer_value_'+n+'" data-validation-required-message="" placeholder="Evaluation" value="'+v.value+'">'
                    +'<input onkeyup="setFeedback(this,'+v.position+')" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 set-answer-feedback" type="text" name="content[answer]['+n+'][feedback]" id="answer_feedback_'+n+'" data-validation-required-message="" placeholder="Feedback" value="'+v.feedback+'">'
                    +'<span class="set-answer-delete-span" id="answer_delete_'+n+'"><a class="delete2 set-answer-delete" href="javascript:removeOption('+v.position+')"></a></span>'
                    +'</div>'
                );
                countBLANKS++;
                n++;
            }
        })
        if(countBLANKS > 0 ) {
            $('#controls-head').show();
        } else {
            $('#controls-head').hide();
        }
    }

    function removeOption(pos) {
        el = $('#target');
        $.each(arrWORDS, function(i, v) {
            if( v.position == pos ) {
                v.marked = 0;
                var txt = el.val();
                txt = txt.replace( '['+v.label+']', v.label );
                el.val(txt);
            }
        })
        renderOptions();
        renderPreview()
    }

    function setValue(el,pos) {
        arrWORDS[pos].value = $(el).val();
    }

    function setFeedback(el,pos) {
        arrWORDS[pos].feedback = $(el).val();
    }

    function sendCode(co){
        var input = document.getElementById("target");
        var output = document.getElementById("output");

        var words = input.value.trim();
        words = words.split(/\n+|\s+/g);
        var atxt = [];
        var b = 0;
        $("#output").empty();
        $.each(words, function(i, v) {
            if( v !== '' ) {
                if( arrWORDS[b] == undefined ) {
                    arrWORDS[b] = new blank(v,1,'',b,0);
                } else {
                    arrWORDS[b].label = v;
                    v = v.replace('[','');
                    v = v.replace(']','');
                    v = v.replace('.','');
                    v = v.replace(',','');
                    v = v.replace('!','');
                    v = v.replace('?','');
                    v = v.replace(':','');

                    arrWORDS[b].label = v;
                }
                b++;
            }
        });
        renderOptions();
        renderPreview();
    }

    function selectBlank() {
        el = $('#target');
        var selectedText = el.selection('get');
        var selectedPos = el.selection('getPos');
        selectedText = selectedText.trim();
        selectedText = selectedText.replace('.','');
        selectedText = selectedText.replace(',','');
        selectedText = selectedText.replace('!','');
        selectedText = selectedText.replace('?','');
        selectedText = selectedText.replace(':','');
        if(selectedText.length == 0 ) { return false; }

        $.each(arrWORDS, function(i, v) {
            if( v.label == selectedText ) {
                v.marked = 1;
            }
        })
        var txt = el.val();
        txt = txt.replace( selectedText, '['+selectedText+']' );
        el.val(txt);
        renderOptions();
        renderPreview();
    }


    $(document).ready(function(){
        l = Ladda.create(document.querySelector('#saveform .ladda-button'));

        manualuploader = $('#manual-file-uploader').fineUploader({
            request: {
                endpoint: '<?php echo base_url() ?>' + 'c2n/resourceUpload'
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

        initBlanks();
    })

    
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
