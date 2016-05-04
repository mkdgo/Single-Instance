<script type="text/javascript" src="<?php echo base_url() ?>res/js/jquery.selection.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>res/js/nicEdit/nicEdit.js"></script>
<div id="fill_in_the_blank" class="form-group grey resource_type" style="height: 90px;">
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
                    <input type="checkbox" id="file_uploaded_f"  value="" disabled="disabled" checked="checked">
                    <label for="file_uploaded_f" id="file_uploaded_label" style="height: 39px;width:auto!important;float: left" ></label>
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
                <textarea style=" overflow: auto;" type="text" name="content[question]" id="question" data-validation-required-message="Please provide a resource file or location" value=""></textarea>
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
                    <textarea style="height: 150px; overflow: auto;" name="content[target]" id="target" class="textarea_fixed resizable" onkeyup="sendCode1(-1)"></textarea>
<!--                    <textarea style="height: 150px; overflow: auto;" name="content[target]" id="target" class="textarea_fixed resizable" onkeyup="sendCode(-1)"></textarea>-->
                </div>
            </div>
            <div style="display: inline-block; width: 100%;margin-top: 10px;">
<!--            <button onclick="toggleArea1();">Toggle DIV Editor</button>-->
                <a class="btn b1 right" href="javascript: selectBlank1();">INSERT BLANK<span class="icon i3"></span></a>
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
            <div class="controls options">
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    var l;
    var start_timer = 0;
    var manualuploader;

    var countBLANKS = 0;
    var BLANKS = [];
    var jsonBLANKS = [];
    var arrWORDS = [];

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
    })



    function blank(label, value, feedback, position, marked) {
        this.label = label;
        this.value = value;
        this.feedback = feedback;
        this.position = position;
        this.marked = marked;
    }
    function initBlanks() {

        var co = $(".options").children().length;

        if(countBLANKS > 0) {
            $('#controls-head').show();
            for( i = 1; i < (countBLANKS + 1); i++ ) {
                BLANKS[i-1] =  new blank( jsonBLANKS[i].label, jsonBLANKS[i].value, jsonBLANKS[i].feedback);
            }
        }
        renderBlanks();
//console.log(jsonBLANKS[i]);
    }

    function renderPreview() {
        var output = $("#output");
        output.html('');
        var txt = '';
        var n = 1;
        $.each(arrWORDS, function(i, v) {
            if( v.marked == 1 ) {
                word = '<input type="text" disabled="disabled" value=""" name="a'+n+'" style="width:100px;display: inline-block;padding:0px; background: #eee;" /> ';
                n++;
            } else {
                word = v.label+' ';
            }
            txt = txt+word;
        })
        output.html( txt.trim() );
    }

    function renderOptions() {
        var input = document.getElementById("target");
        var output = document.getElementById("output");
        var n = 1;
        $('.options').html('');
        $.each(arrWORDS, function(i, v) {
            if( v.marked == 1 ) {
                $('.options').append('<div class="option row" style="margin-left: 0; margin-right: 0; margin-bottom:10px;">'
                    +'<span style="float: left; margin-right: 10px;padding: 16px 0;line-height: 28px; width: 8%">[blank'+n+']</span>'
                    +'<input class="col-lg-4 col-md-4 col-sm-4 col-xs-12" type="text" name="content[answer]['+n+'][label]" id="answer_label_'+n+'" data-validation-required-message="" placeholder="Label" value="'+v.label+'" style="width: 27%; float: left;">'
                    +'<input onkeyup="setValue(this,'+v.position+')" class="col-lg-1 col-md-1 col-sm-1 col-xs-12" type="text" name="content[answer]['+n+'][value]" id="answer_value_'+n+'" data-validation-required-message="" placeholder="Evaluation" value="'+v.value+'" style="width: 10%; float: left; margin-top: 0;">'
                    +'<input onkeyup="setFeedback(this,'+v.position+')" class="col-lg-6 col-md-6 col-sm-6 col-xs-12" type="text" name="content[answer]['+n+'][feedback]" id="answer_feedback_'+n+'" data-validation-required-message="" placeholder="Feedback" value="'+v.feedback+'" style="width: 48%; float: left; margin-top: 0;">'
                    +'<span class="" id="answer_delete_'+n+'" style=" float: right; " ><a class="delete2" href="javascript:removeOption1('+v.position+')" style="color: #e74c3c;display: inline-block; margin-top: 18px; width: 24px; height: 24px; margin-left: 3px; background: url(/img/Deleteicon_new.png) no-repeat 0 0;"></a></span>'
                    +'</div>'
                )
                n++;
            }
        })
    }

    function removeOption1(pos) {
        var input = document.getElementById("target");
        var output = document.getElementById("output");
        $.each(arrWORDS, function(i, v) {
            if( v.position == pos ) {
                v.marked = 0;
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

    function sendCode1(co){
        var input = document.getElementById("target");
        var output = document.getElementById("output");

        var words = input.value.trim()
        words = words.split(" ");
        var atxt = [];
        $("#output").empty();
        $.each(words, function(i, v) {
            if( arrWORDS[i] == undefined ) {
                arrWORDS[i] = new blank(v,1,'',i,0);
            } else {
                arrWORDS[i].label = v;
            }
//console.log( i );
//console.log( arrWORDS[i] );
        });
//console.log( arrWORDS );
        renderOptions();
        renderPreview();
    }

    function selectBlank1() {
        var input = document.getElementById("target");
        var count_options = $(".options").children().length;
        el = $('#target');
        var selectedText = el.selection('get');
        var selectedPos = el.selection('getPos');
//console.log( selectedText.length );
        selectedText = selectedText.trim();
        if(selectedText.length == 0 ) { return false; }

        $.each(arrWORDS, function(i, v) {
            if( v.label == selectedText ) {
                v.marked = 1;
            }
        })
        renderOptions();
        renderPreview();
    }





























    function selectBlank() {
        var count_options = $(".options").children().length;
        el = $('#target');
        var selectedText = el.selection('get');
        selectedText = selectedText.trim()
        if(selectedText.length == 0 ) { return false; }

        insertSpan(el,countBLANKS);

        addNewOption(selectedText);
//        sendCode(0);
//console.log("Selected text: " + selectedText + ' - lenght' +selectedText.length );
    }

    function insertSpan(el, co) {
        if(co == 0) {co++;}
        el.selection('insert', {text: '[', mode: 'before'});
        el.selection('insert', {text: ']', mode: 'after'});
        sendCode(co);
    }

    function sendCode(co){
        var input = document.getElementById("target");
        var output = document.getElementById("output");
        
        if( co >= 0 ) {
            var txt = input.value;
//            co = co+1;


var searched = /[[a-z0-9]+\s*]/ig;
var matches = txt.match(
    new RegExp(
        searched,
        "gi"
    )
);
console.log( matches );


            for( i = 0; i < co; i++ ) {
                var searched = /[[a-z0-9]+\s*]/ig;
                var txt1 = txt.replace(searched, '<input rel="'+co+'" disabled="disabled" type="text" value="" style="width:100px;display: inline-block;padding:0px; background: #eee;"/>');
//                var txt1 = txt.replace('[blank'+(i+1)+']', '<input disabled="disabled" type="text" value="" style="width:100px;display: inline-block;padding:0px; background: #eee;"/>');
console.log( txt1 );

                txt = txt1;
            }
        } else {
            txt1 = input.value;
        }

        output.innerHTML = txt1;
    }

    function addNewOption(seltxt) {
countBLANKS++;
jsonBLANKS[countBLANKS] = {label: seltxt, value: 1, feedback: ''};
BLANKS[countBLANKS] = new blank(seltxt, 1, '');//{label: seltxt, value: 1, feedback: ''};
renderBlanks();
    }

    function renderBlanks() {
        $('.options').html('');
console.log( jsonBLANKS );
        for( i = 0; i < countBLANKS; i++ ) {
            co = i+1;
            if( jsonBLANKS[co]== undefined ) {
                co++;
            }
console.log( co );
            $('.options').append('<div class="option row" style="margin-left: 0; margin-right: 0; margin-bottom:10px;">'
                +'<span style="float: left; margin-right: 10px;padding: 16px 0;line-height: 28px; width: 8%">[blank'+co+']</span>'
                +'<input class="col-lg-4 col-md-4 col-sm-4 col-xs-12" type="text" name="content[answer]['+co+'][label]" id="answer_label_'+co+'" data-validation-required-message="" placeholder="Label" value="'+jsonBLANKS[co].label+'" style="width: 27%; float: left;">'
                +'<input class="col-lg-1 col-md-1 col-sm-1 col-xs-12" type="text" name="content[answer]['+co+'][value]" id="answer_value_'+co+'" data-validation-required-message="" placeholder="Evaluation" value="'+jsonBLANKS[co].value+'" style="width: 10%; float: left; margin-top: 0;">'
                +'<input class="col-lg-6 col-md-6 col-sm-6 col-xs-12" type="text" name="content[answer]['+co+'][feedback]" id="answer_feedback_'+co+'" data-validation-required-message="" placeholder="Feedback" value="'+jsonBLANKS[co].feedback+'" style="width: 48%; float: left; margin-top: 0;">'
                +'<span class="" id="answer_delete_'+co+'" style=" float: right; " ><a class="delete2" href="javascript:removeOption('+co+')" style="color: #e74c3c;display: inline-block; margin-top: 18px; width: 24px; height: 24px; margin-left: 3px; background: url(/img/Deleteicon_new.png) no-repeat 0 0;"></a></span>'
                +'</div>'
            )        
        }
console.log( jsonBLANKS );
    }
    



    function removeOption(id) {
        countBLANKS--;
        var str_el = $('#answer_label_'+id).val();
        var str_replace = '['+str_el+']';

        var textarea_val = $('#target').val();
        var output_val = $('#output').val();
        $('#target').val(textarea_val.replace( str_replace, str_el ));
        $('#answer_label_'+id).parent().remove();

//    BLANKS.splice( id, 1 );
delete jsonBLANKS[id];
//    jsonBLANKS.splice( id, 1 );
renderBlanks();

        sendCode(0);

console.log( jsonBLANKS );
    }














/*
    function addNewOption(seltxt) {
        var co = $(".options").children().length;
        if(co == 0) {
            co++;
            $('.options').append('<div>'
                +'<span style="float: left; margin-right: 10px; width: 8%">&nbsp;</span>'
                +'<span class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="text-align: center; width: 27%;">Correct Text</span>'
                +'<span class="col-lg-1 col-md-1 col-sm-1 col-xs-12" style="text-align: center; width: 10%;">Score</span>'
                +'<span class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: center; width: 48%;">Feedback</span>'
                +'</div>');
        }
//console.log(co);
        $('.options').append('<div class="option row" style="margin-left: 0; margin-right: 0; margin-bottom:10px;">'
            +'<span style="float: left; margin-right: 10px;padding: 16px 0;line-height: 28px; width: 8%">[blank'+co+']</span>'
            +'<input class="col-lg-4 col-md-4 col-sm-4 col-xs-12" type="text" name="content[answer]['+co+'][label]" id="answer_label_'+co+'" data-validation-required-message="" placeholder="Label" value="'+seltxt+'" style="width: 27%; float: left;">'
            +'<input class="col-lg-1 col-md-1 col-sm-1 col-xs-12" type="text" name="content[answer]['+co+'][value]" id="answer_value_'+co+'" data-validation-required-message="" placeholder="Evaluation" value="1" style="width: 10%; float: left; margin-top: 0;">'
            +'<input class="col-lg-6 col-md-6 col-sm-6 col-xs-12" type="text" name="content[answer]['+co+'][feedback]" id="answer_feedback_'+co+'" data-validation-required-message="" placeholder="Feedback" value="" style="width: 48%; float: left; margin-top: 0;">'
            +'<span class="" id="answer_delete_'+co+'" style=" float: right; " ><a class="delete2" href="javascript:removeOption('+co+')" style="color: #e74c3c;display: inline-block; margin-top: 18px; width: 24px; height: 24px; margin-left: 3px; background: url(/img/Deleteicon_new.png) no-repeat 0 0;"></a></span>'
            +'</div>')
    }

    function removeOption(id) {
//        var co = $(".options").children().length;
//        if(co == 0) {co++;}
        var str_el = $('#answer_label_'+id).val();
        var str_replace = '[blank'+id+']';
        var textarea_val = $('#target').val();
        $('#target').val(textarea_val.replace( str_replace, str_el ));
        $('#answer_label_'+id).parent().remove();

//console.log( $(selectedText).outerHTML );
    }

    function selectBlank() {
        var count_options = $(".options").children().length;
        el = $('#target');
        var selectedText = el.selection('get');
        if(selectedText.length == 0 ) { return false; }
//        var selectedPosition = el.selection('getPos');
        insertSpan(el,count_options);
        addNewOption(selectedText);
//alert( el.val() );
//alert(selectedPosition.start + ' - '  + selectedPosition.end );
//console.log("Selected text: " + selectedText + ' - lenght' +selectedText.length );
    }

    function insertSpan(el, co) {
        if(co == 0) {co++;}
        el.selection('replace', {text: '[blank'+co+']'})
//        el.selection('insert', {text: '[a'+co, mode: 'before'});
//        el.selection('insert', {text: ']', mode: 'after'});
        sendCode(co);
    }

    var input = document.getElementById("target");
    var output = document.getElementById("output");

    function sendCode(co){
        if( co >= 0 ) {
            var txt = input.value;
            co = co+1;
            for( i=0; i < co; i++ ) {
                var txt1 = txt.replace('[blank'+(i+1)+']', '<input disabled="disabled" type="text" value="" style="width:100px;display: inline-block;padding:0px; background: #eee;"/>');
                txt = txt1;
            }
        } else {
            txt1 = input.value;
        }

        output.innerHTML = txt1;
    }
//*/
    
    
    
    
    
    
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
