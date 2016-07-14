<script type="text/javascript" src="https://app.box.com/js/static/select.js"></script>
<style type="text/css">
    span.select { background: #fff; height: 62px; line-height: 30px; }
    span.select .v { height: 62px; padding: 15px; }
    span.select .a { height: 62px; padding: 15px; }

#saveform .tip2 {
    display: block;
    position: absolute;
    right: 0;
    padding: .6em;
    background: #e74c3c;
    border: 1px solid #c8c8c8;
    color: #fff;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
    top: -42px;
}
</style>
<form class="form-horizontal add_resource" id="saveform" method="post" enctype="multipart/form-data" action="/c2n/save">
    <input type="hidden" name="type" value ="{type}" />
    <input type="hidden" name="elem_id" value ="{elem_id}" />
    <input type="hidden" name="subject_id" value ="{subject_id}" />
    <input type="hidden" name="year_id" value ="{year_id}" />
    <input type="hidden" name="module_id" value ="{module_id}" />
    <input type="hidden" name="lesson_id" value ="{lesson_id}" />
    <input type="hidden" name="content_id" value ="{content_id}" />
    <input type="hidden" class="new_upload" value ="" />
    <input type="hidden" name="search_query" value ="{search_query}" />
    <input id="add_another" type="hidden" name="add_another" value ="0" />
    <input type="hidden" name="resource_exists" value="{resource_exists}" />
    <input id="header_title" type="hidden" name="header[title]" value="" />
    <input id="header_description" type="hidden" name="header[description]" value="" />
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
                    <?php if( $saved == FALSE ): ?>
                    <h2> Create New Resource</h2>
                    <?php else: ?>
                    <h2>{resource_title}</h2>
                    <?php endif ?>

                    <div class="form-group grey no-margin">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><label for="is_remote0" class="scaled">Resource Type</label></div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <span></span>
                            <div class="controls">
                                <select onChange="chnageResourceType($(this));" name="header[type]" id="resource_type">
                                    <option class="classes_select_option" value="-1"></option>
                                    <?php echo $new_resource->renderTypes($header['type']) ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="resource_section" style="display: block;">
                        <div class="form-group grey no-margin">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><label id="label_resource_title" for="resource_title" class="scaled">Title</label></div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="controls">
                                    <span></span>
                                    <input type="text" id="resource_title" name="resource_title" class="required" data-validation-required-message="Please provide a title for this resource" value="{resource_title}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group grey no-margin">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><label id="label_resource_desc" class="scaled">Description</label></div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="controls">
                                    <span></span>
                                    <textarea id="resource_desc" class="textarea_fixed " data-autoresize name="resource_desc" data-validation-required-message="Please provide a detailed description for this resource"  placeholder="Write a description">{resource_desc}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="quiz_section" style="display: none;">
                        <div class="form-group grey no-margin">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><label id="label_resource_desc" class="scaled">Question Preface</label></div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="controls">
                                    <span></span>
                                    <textarea id="quiz_desc" class="textarea_fixed " data-autoresize name="quiz_desc" data-validation-required-message="Please provide a detailed description for this resource"  placeholder="Write a description">{resource_desc}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group grey no-margin">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><label id="label_resource_title" for="resource_title" class="scaled">Question</label></div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="controls">
                                    <span></span>
                                    <input type="text" id="quiz_title" name="quiz_title" class="required" data-validation-required-message="Please provide a title for this resource" value="{resource_title}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="res-container">
                        <?php echo $container; ?>
                    </div>

                    <div class="form-group grey no-margin keywords-container" >
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label for="resource_keywords" class="scaled">Keywords</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="keywords" id="keywords">
                                <input type="text" id="resource_keywords" name="resource_keywords"  value="{resource_keywords}" style="display: none;">
                                <input type="hidden" id="resource_keywords_a" name="resource_keywords_a" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group grey no-margin available-container">
                        <div class="c2_radios">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label class="scaled">Available to</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding-left: 0;">
                                <div class="clear"></div>
                                <?php foreach ($year_restriction as $restrction): ?>
                                    <input type="checkbox" name="info[access][]" id="year_restriction_<?php echo $restrction['year'] ?>" value="<?php echo $restrction['year'] ?>" <?php if (in_array($restrction['year'], $restricted_to) || $new_res) echo 'checked="checked"' ?>><label for="year_restriction_<?php echo $restrction['year'] ?>">Year <?php echo $restrction['year'] ?></label>
                                <?php endforeach ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if( $preview != '' && !in_array( $resource_type, array( 'single_choice','multiple_choice','fill_in_the_blank','mark_the_words' ) )  ): ?>
            <div class="form-group grey no-margin" style="padding:30px 0 30px 0; margin-top:11px;">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><label class="scaled">Preview</label></div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" <?php if($this->uri->segment('3') !='0'){?>style="height:470px;overflow: hidden" <?php } ?>>{preview}</div>
            </div>
            <?php endif ?>
        </div>
    </div>
</form>
<div class="clear" style="height: 1px;"></div>
<prefooter><div class="container"></div></prefooter>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="javascript:void(0);" onclick="cancel_resource();" class="cancel_btn">CANCEL</a>
            <a href="javascript:void(0);" onclick="saveResourcePre()" class="red_btn">SAVE</a>
            <?php if( $type ): ?>
            <a href="javascript:void(0);" onclick="$('#add_another').val(1); saveResourcePre()" class="red_btn">SAVE AND ADD ANOTHER</a>
            <?php endif ?>
        </div>
    </div>
</footer>
<div id="message" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="popupError" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" style="margin: 20px;">
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
            showFooterMessage({status: 'alert', mess: message, clrT: '#6b6b6b', clr: '#fcaa57', anim_a: 2000, anim_b: 1700});
        })
<?php } ?>
</script>
<script type="text/javascript">
    var l;
    var start_timer = 0;
    var manualuploader;
    var exist = <?php echo $saved ?>;
    var res_type = '<?php echo $header['type'] ?>';
    var res_id = <?php echo $elem_id ?>;
    var res_link = '<?php echo $resource_link ?>';

    $(document).ready(function(){
/*
        l = Ladda.create(document.querySelector('#saveform .ladda-button'));

        manualuploader = $('#manual-fine-uploader').fineUploader({
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
//*/
        if( $('#resource_type').val() != -1 )
        show_hide_extras();
        if( exist == 1 ) {
            $.get( "/c2n/getContent", { res_type: res_type, res_id: res_id }, function( data ) {
                $( "#res-container" ).html( data );
                if( res_type == 'remote_box' ) { initBox(res_link); }
                if( res_type == 'remote_video' || res_type == 'remote_url' ) { $('#resource_link').val(res_link); }
                $('#introduction_text').val();
                $('#question').val();

    /*            if( el.val() == 'fill_in_the_blank' ) { makeEditor(); }*/
            });
        }
    })

    function cancel_resource() {
        if($('#saveform .new_upload').val().length>0) {
            var filename = $('#saveform .new_upload').val();
            data={filename:filename}
            $.ajax({
                url: '<?php echo base_url()?>c2/delete_file',
                data:data,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    window.location.href = '<?php echo $btn_cancel ?>';
//                    window.location.href = '<?php //echo base_url()?>c1'
                }
            });
        } else {
            window.location.href = '<?php echo $btn_cancel ?>';
//            window.location.href = '<?php //echo base_url()?>c1'
        }
    }

    function update_text() {
        var t = $('.upload').val();
        var filename = t.replace(/^.*\\/, "");
        $("#uploadFile").text(filename);
    }

    function chnageResourceType(el) {
//console.log(el.val());
        el.parent().parent().prev('span.tip2').fadeOut('3333');
        el.parent().css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})

        $('.resource_type').hide();
        $('#'+el.val()).show();
        $.get( "/c2n/getContent", { res_type: el.val() }, function( data ) {
            $( "#res-container" ).html( data );
            if( el.val() == 'remote_box' ) { initBox(null); }
/*            if( el.val() == 'fill_in_the_blank' ) { makeEditor(); }*/
        });
        show_hide_extras();

    }

    function show_hide_extras() {
        el = $('#resource_type');
        if( $.inArray(el.val(),['local_image','local_file','remote_box','remote_url','remote_video']) == -1 ) {
//console.log(el.val());
            $('.keywords-container').hide();
            $('.available-container').hide();
            $(".available-container input[type='checkbox']").attr('checked',false)
            $('#quiz_section').show();
            $('#resource_section').hide();
//            $('#label_resource_title').html('Question');
//            $('#label_resource_desc').html('Question Preface');
        } else {
            $('.keywords-container').show();
            $('.available-container').show();
            $(".available-container input[type='checkbox']").attr('checked',true)
            $('#resource_section').show();
            $('#quiz_section').hide();
//            $('#label_resource_title').html('Title');
//            $('#label_resource_desc').html('Description');
        }
    }

    function saveResourcePre() {
        el_type = $('#resource_type');
        el_type_value = el_type.val();
        count_option = $(".options").children().length;
        errors = 0;
        if( el_type_value == -1 ) {
            el_type.parent().css({'border':'1px dashed red'});
            var msg = 'Please choose Resource type';
            el_type.parent().parent().prev('span').attr('id','scrolled');
            el_type.parent().parent().prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'}); 
            el_type.parent().parent().prev('span').removeAttr('scrolled');
            errors = 1;
        }
        if( $.inArray(el_type_value,['local_image','local_file','remote_box','remote_url','remote_video']) == -1 ) {
            var question = $('#quiz_title');
            if( question.val().trim() == '' || question.val() === undefined ) {
                question.css({'border':'1px dashed red'});
                var msg = 'Please provide a question for this resource';
                question.prev('span').attr('id','scrolled');
                question.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'}); 
                question.prev('span').removeAttr('scrolled');
                errors = 1;
                question.on('focus',function(){
                    question.prev('span.tip2').fadeOut('3333');
                    question.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
                })
            }

            if( el_type_value == 'multiple_choice' || el_type_value == 'single_choice') {
                if( count_option < 2 ) {
                    $(".options").css({'border':'1px dashed red'});
                    var msg = 'Please provide at least 2 options for this resource';
                    $(".options").prev('span').attr('id','scrolled');
                    $(".options").prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'}); 
                    $(".options").prev('span').removeAttr('scrolled');

                    $("#target").on('focus',function(){
                        $(".option").prev('span.tip2').fadeOut('3333');
                        $(".option").css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
                    })
                    errors = 1;
                } else {
                    not = 0;
                    $.each($('.option'), function(el) {
                        lbl = $('#answer_label_'+el);
                        if( lbl.val().trim() == '' || lbl.val() === undefined ) {
                            lbl.css({'border':'1px dashed red'});
                            var msg = 'Please type a label for those options';
                            if( not == 0 ) {
                                $('.options').prev('span').attr('id','scrolled');
                                $('.options').prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'}); 
                                $('.options').prev('span').removeAttr('scrolled');
                                not = 1;
                            }
                            errors = 1;
                            $('.set-answer-label').on('focus',function(){
                                $('.options').prev('span.tip2').html('').hide();
                                $('.set-answer-label').css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
                            })
                        }
                    })
                }
            } else if( el_type_value == 'mark_the_words' ) {
                if( count_option < 1 ) {
                    $(".option").css({'border':'1px dashed red'});
                    var msg = 'Please highlight at least one word';
                    $(".option").prev('span').attr('id','scrolled');
                    $(".option").prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'}); 
                    $(".option").prev('span').removeAttr('scrolled');

                    $("#target").on('focus',function(){
                        $(".option").prev('span.tip2').fadeOut('3333');
                        $(".option").css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
                    })
                    errors = 1;
                }
            } else {
                if( count_option < 1 ) {
                    $(".option").css({'border':'1px dashed red'});
                    var msg = 'Please insert at least one blank';
                    $(".option").prev('span').attr('id','scrolled');
                    $(".option").prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'}); 
                    $(".option").prev('span').removeAttr('scrolled');

                    $("#target").on('focus',function(){
                        $(".option").prev('span.tip2').fadeOut('3333');
                        $(".option").css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
                    })
                    errors = 1;
                }
            }

            $('#header_title').val($('#quiz_title').val());
            $('#header_description').val($('#quiz_desc').val());
        } else {
            if( $.inArray(el_type_value,['local_image','local_file']) != -1 ) {
                
            } else {
                el_link = $('#resource_link');
                el_link_value = $('#resource_link').val();
                if (!isValidURL(el_link_value)) {
                    el_link.css({'border': '1px dashed red'});
                    var msg = 'Resource URL is not valid!';
                    el_link.prev('span').attr('id', 'scrolled');
                    el_link.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display': 'block'});
                    $('html, body').animate({scrollTop: $('#scrolled').stop().offset().top - 500}, 300);
                    el_link.prev('span').removeAttr('scrolled');
                    errors = 1;
                    el_link.on('focus',function(){
                        el_link.prev('span.tip2').fadeOut('3333');
                        el_link.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
                    })
                }
            }

            el_title = $('#resource_title');
            el_title_value = $('#resource_title').val();
            if( el_title_value.trim() == '' || el_title_value === undefined ) {
                el_title.css({'border':'1px dashed red'});
                var msg = 'Please provide a title for this resource';
                el_title.prev('span').attr('id','scrolled');
                el_title.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'}); 
                el_title.prev('span').removeAttr('scrolled');
                errors = 1;
                el_title.on('focus',function(){
                    el_title.prev('span.tip2').fadeOut('3333');
                    el_title.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
                })
            }

            $('#header_title').val(el_title_value);
            $('#header_description').val($('#resource_desc').val());
        }
        if( errors ) {
            return false;
        } else {
            $('#saveform').submit();            
        }
//            return false;
    }
/*
    function saveResource() {
        if ($('#resource_link').hasClass("required")) {
            if (!isValidURL($('#resource_link').val())) {
                $('#resource_link').css({'border': '1px dashed red'});
                var msg = 'Resource URL is not valid!';
                $('#resource_link').prev('span').attr('id', 'scrolled');
                $('#resource_link').prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display': 'block'});
                $('html, body').animate({scrollTop: $('#scrolled').stop().offset().top - 500}, 300);
                $('#resource_link').prev('span').removeAttr('scrolled');
                $('#resource_link').on('focus',function(){
                    $('#resource_link').prev('span.tip2').fadeOut('3333');
                    $('#resource_link').css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
                })
                return false;
            }
        }
        validate_resource();
    }
//*/
    function isValidURL(url) {
        var RegExp = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/i

        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }


$(document).ready(function() {
    var obj;
    var boxSelect = new BoxSelect();
    // Register a success callback handler
    boxSelect.success(function(response) {
        obj = response;
        $('#resource_title').val(response[0].name);
        $('#resource_link').val(response[0].url);
//console.log(obj);
    });
    // Register a cancel callback handler
    boxSelect.cancel(function() {
//        console.log("The user clicked cancel or closed the popup");
    });
});

    function initBox(lnk) {
        var obj;
        $('#resource_link').val(lnk);
        var boxSelect = new BoxSelect();
        // Register a success callback handler
        boxSelect.success(function(response) {
            obj = response;
            $('#resource_title').val(response[0].name);
            $('#resource_link').val(response[0].url);
            console.log(obj);
        });
        // Register a cancel callback handler
        boxSelect.cancel(function() {
    //        console.log("The user clicked cancel or closed the popup");
        });
    }
/*
var options = {
    clientId: YOUR_CLIENT_ID,
    linkType: YOUR_LINK_TYPE,
    multiselect: YOUR_MULTISELECT
};
var boxSelect = new BoxSelect(options);
*/
/*
function addResource(action) {
    action_url = action;
//    if( published == 1 ) { publ=1; } else { publ = 0; }
    if( action == 'saveaddresource' ) action_url += ('/'+publ);
    classes = [];
    $('#classes_holder input').each(function( index ) {
        E = $(this);
        if( E.prop('checked') )classes.push( E.attr('value') );
    });
    $('#class_id').val(classes.join(','));
//    $('#categories').val(JSON.stringify(assignment_categories_json));
//    $('#attributes').val(JSON.stringify(assignment_attributes_json));
//    $('#assignment_intro').val( nicEditors.findEditor('assignment_intro').getContent() );
    
    //$('#form_assignment').submit();

    $($('#message').find("div")[0]).html('Saving Data ...');
    //$('#message').popup('open');

    $.ajax({
        type: "POST",
        url: "/f2b_teacher/save",
        data: $("#form_assignment").serialize(),
        async: false,
        success: function(data) {
        //$('#message').popup('close');
            if( data.ok == 1 ) {
                if( action == 'saveaddresource' ) {
                    assignment_id = data.id;
                    document.location="/c1/index/collection/"+assignment_id;
                    return;
                }
                if( mode == 1 ) {
                    $($('#message_b').find("div")[0]).html('Your changes have been saved successfully!');
                    $('#message_b').popup('open');
                    $('#message_b').delay( 800 ).fadeOut( 500, function() {
                        $('#message_b').popup('close');
                        $('#message_b').fadeIn( 1 );
                    });
                    assignment_id = data.id;
                    $('#assignment_id').val(data.id);
                    if( action == 'savepublish' ) {
                        document.location="/f2b_teacher/index/"+assignment_id;
                        return;
                    }
                } else {
                    document.location="/f1_teacher";
                }
            } else {
                showFooterMessage({status: 'alert', mess: data.mess, clrT: '#6b6b6b', clr: '#fcaa57', anim_a:2000, anim_b:1700});
            }
        }
    });
}
//*/

</script>

<!--<script type="text/javascript" src="<?= base_url("/js/crypt/aes.js") ?>"></script>
<script src="<?= base_url("/js/crypt/upload.js") ?>"></script>-->
