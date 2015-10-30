<link rel="stylesheet" href="/css/colorbox.css" type="text/css"/>
<style type="text/css">
.btn.b1 {
    background: #34495E;
    border: solid 1px #062b39;
    line-height: 100%;
    text-transform: uppercase;
    color: #fff;
/*    padding: 10px 47px 10px 14px;*/
    position: relative;
    -webkit-border-radius: 2px;
    border-radius: 2px;
}

.tip2 {
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
.tip2:after, .tip2:before {
    top: 100%;
    left: 50%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}
.tip2:before {
    border-color: rgba(204, 204, 204, 0);
    border-top-color: #c8c8c8;
    border-width: 11px;
    margin-left: -11px;
}
.tip2:after {
    border-color: rgba(231, 76, 60, 0);
    border-top-color: #e74c3c;
    border-width: 10px;
    margin-left: -10px;
}



</style>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h2>Site Settings Management</h2>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="active">Site Settings :: Management</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Site Settings</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="portlet-body">
                            <form class="form-horizontal" id="siteSettingsForm" name="siteSettingsForm" method="POST" action="settings/save">

                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 control-label">Identity Data Provider</label>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="default_identity_data_provider" value="ediface" <?php if ($settings['default_identity_data_provider'] == 'ediface') echo 'checked="checked"'; ?>>Ediface
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="default_identity_data_provider" value="onelogin" <?php if ($settings['default_identity_data_provider'] == 'onelogin') echo 'checked="checked"'; ?>>One Login
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-xs-12 col-sm-4 control-label">Logout redirect</label>
                                        <div class="col-xs-12 col-sm-8">
                                            <div class="radio">
                                                <label>
                                                    <input onclick="setLogoutUrl('default')" type="radio" name="logout_url" value="default" <?php if( $settings['logout_url'] == 'default' ) echo 'checked="checked"'; ?>>Ediface default
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input onclick="setLogoutUrl('custom')" type="radio" name="logout_url" value="custom" <?php if( $settings['logout_url'] == 'custom' ) echo 'checked="checked"'; ?>>Custom
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="logout_url" class="row margin-top-10px">
                                        <label class="col-xs-12 col-sm-4 control-label">Custom logout redirect</label>
                                        <div class="col-xs-12 col-sm-8">
                                            <input class="col-xs-12 col-md-6 input" type="text" name="logout_url_custom" value="<?php echo $settings['logout_url_custom']; ?>" >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-xs-12 col-sm-4 control-label">Elastic Search URL (omit protocol)</label>
                                        <div class="col-xs-12 col-sm-8">
                                            <input class="col-xs-12 input" type="text" name="elastic_url" value="<?php echo $settings['elastic_url']; ?>" >
                                        </div>
                                    </div>
                                    <div class="row margin-top-10px">
                                        <label class="col-xs-12 col-sm-4 control-label">Elastic Search Default Index</label>
                                        <div class="col-xs-12 col-sm-8">
                                            <input class="col-xs-12 col-md-6 input" type="text" name="elastic_index" value="<?php echo $settings['elastic_index']; ?>" >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group hidden">
                                    <label class="col-xs-12 col-sm-4 control-label"></label>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="fall_back_to_default_identity_data_provider" value="1" <?php if ($settings['fall_back_to_default_identity_data_provider']) echo 'checked="checked"'; ?>>
                                                Fall back to Ediface Identity Data Provider
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 control-label">Website Head Title</label>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                <input type="text" name="website_head_title" value="<?php echo $settings['website_head_title'] ?>" />
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 control-label"></label>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="checkbox">
                                            <label>Teacher's Video lessons:</label>
                                        </div>
                                    </div>
                                    <label class="col-xs-12 col-sm-4 control-label">Creatting Resources</label>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                <?php if( $tvls['tvlesson_creating_resources']['value'] ): ?>
                                                <?php echo $tvls['tvlesson_creating_resources']['resource_view']; ?>
                                                <?php endif ?>
                                                <a class="btn b2" onclick="loadRes('tvlesson_creating_resources');">EDIT</a>
                                                <input type="hidden" name="tvlesson_creating_resources" value="<?php echo $settings['tvlesson_creating_resources'] ?>" />
                                            </label>
                                        </div>
                                    </div>
                                    <label class="col-xs-12 col-sm-4 control-label">Interactive Lessons</label>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                <?php if( $tvls['tvlesson_interactive_lessons']['value'] ): ?>
                                                <?php echo $tvls['tvlesson_interactive_lessons']['resource_view']; ?>
                                                <?php endif ?>
                                                <a class="btn b2" onclick="loadRes('tvlesson_interactive_lessons');">EDIT</a>
                                                <input type="hidden" name="tvlesson_interactive_lessons" value="<?php echo $settings['tvlesson_interactive_lessons'] ?>" />
                                            </label>
                                        </div>
                                    </div>
                                    <label class="col-xs-12 col-sm-4 control-label">Setting Homework</label>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                <?php if( $tvls['tvlesson_setting_homework']['value'] ): ?>
                                                <?php echo $tvls['tvlesson_setting_homework']['resource_view']; ?>
                                                <?php endif ?>
                                                <a class="btn b2" onclick="loadRes('tvlesson_setting_homework');">EDIT</a>
                                                <input type="hidden" name="tvlesson_setting_homework" value="<?php echo $settings['tvlesson_setting_homework'] ?>" />
                                            </label>
                                        </div>
                                    </div>
                                    <label class="col-xs-12 col-sm-4 control-label">Submitting Homework</label>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                <?php if( $tvls['tvlesson_submitting_homework']['value'] ): ?>
                                                <?php echo $tvls['tvlesson_submitting_homework']['resource_view']; ?>
                                                <?php endif ?>
                                                <a class="btn b2" onclick="loadRes('tvlesson_submitting_homework');">EDIT</a>
                                                <input type="hidden" name="tvlesson_submitting_homework" value="<?php echo $settings['tvlesson_submitting_homework'] ?>" />
                                            </label>
                                        </div>
                                    </div>
                                    <label class="col-xs-12 col-sm-4 control-label">Marking Homework</label>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                <?php if( $tvls['tvlesson_marking_homework']['value'] ): ?>
                                                <?php echo $tvls['tvlesson_marking_homework']['resource_view']; ?>
                                                <?php endif ?>
                                                <a class="btn b2" onclick="loadRes('tvlesson_marking_homework');">EDIT</a>
                                                <input type="hidden" name="tvlesson_marking_homework" value="<?php echo $settings['tvlesson_marking_homework'] ?>" />
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 control-label">&nbsp;</label>
                                    <div class="col-xs-12 col-sm-2 col-sm-offset-6">
                                        <input type="submit" class="btn btn-primary btn-primary-override form-control" id="save" name="save" value="Save">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery.colorbox-min.js"></script>
<div class="modal fade" id="editRes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add/Edit Lessons</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal add_resource" id="saveform" method="post" enctype="multipart/form-data" action="/c2/save">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group grey" style="display: none;">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label for="is_remote0" class="scaled">Resource Type</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <fieldset onchange="chnageResourceType();" data-role="controlgroup" data-type="horizontal" data-role="fieldcontain" class="radio_like_button"> 
                                        <input type="radio" name="is_remote" id="is_remote0" value="0" >
                                        <label for="is_remote0" >Local file</label>
                                        <input type="radio" name="is_remote" id="is_remote1" value="1" >
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
                                    <input type="hidden" name="resource_exists" value="">
                                </div>
                            </div>
                            <div id="resource_remote" class="form-group grey " style="height: 90px;padding-top:21px;">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label for="resource_link" class="scaled">Resource URL</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <div class="controls">
                                        <span></span>
                                        <input class="col-lg-12 col-md-12 col-sm-12 col-xs-12" type="text" name="link" id="resource_link" data-validation-required-message="Please provide a resource file or location" value="">
                                    </div>
                                </div>
                            </div>
                            <input id="setting_id" type="hidden" name="setting_id" value="" />
                            <input id="res_id" type="hidden" name="res_id" value="" />
                            <input id="type" type="hidden" name="type" value="" />
                            <input id="resource_name" type="hidden" name="resource_name" value="" />
                            <input id="name" type="hidden" name="name" value="" />
                            <input id="description" type="hidden" name="description" value="" />
                            <input id="file_uploaded" type="hidden" name="file_uploaded" value ="" />
                            <input type="hidden" class="new_upload" value="" />
                        </div>
                    </div>
                </form>
            </div>
            <input type="hidden" id="resource_id" value="0" />
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveLesson();">Save</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url("/js/crypt/aes.js") ?>"></script>
<script src="<?= base_url("/js/crypt/upload.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.fineuploader-3.5.0.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>css/fineuploader_resources.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/spin.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/ladda.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>css/ladda.css" type="text/css" />

<script type="text/javascript">
    var logout_url = '<?php echo $settings['logout_url'] ?>';
    $(document).ready(function() {

        initLogout();

        $body = $("body");
        $(document).on({
            ajaxStart: function () {
                $body.addClass("loading");
            },
            ajaxStop: function () {
                $body.removeClass("loading");
            },
            ajaxError: function () {
                $body.removeClass("loading");
                showAJAXError();
            },
            ajaxComplete: function () {
    //            console.log('TODO: Attach AJAX Complete Events');
            }
        });

    })
    function chnageResourceType() {
        if ($('#saveform input[name=is_remote]:checked').val() == 1) {
            $('#saveform #resource_url').removeClass('required');
            $('#saveform #resource_link').addClass('required');
            $('#saveform #resource_file').hide();
            $('#saveform #resource_remote').show();
        } else {
            $('#saveform #resource_file').show();
            $('#saveform #resource_remote').hide();
            $('#saveform #resource_url').addClass('required');
            $('#saveform #resource_link').removeClass('required');
        }
    }

//    chnageResourceType();

    function saveLesson() {
        if( $('#resource_link').hasClass("required") ) {
            if( !isValidURL( $('#resource_link').val() ) ) {
                $('#resource_link').css({'border': '1px dashed red'});
                var msg = 'Resource URL is not valid!';
                $('#resource_link').prev('span').attr('id', 'scrolled');
                $('#resource_link').prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display': 'block'});
                $('#resource_link').prev('span').removeAttr('scrolled');
                return false;
            }
        }

        $.ajax({
            'url': base_url + 'admin/settings/saveVideoLesson',
            'type': 'POST',
            'dataType': 'json',
            'data': $('#saveform').serialize()
        }).done( function(data) {
//console.log( data );
            if( data ) {
                if( data.res_id > 0 ) { $('#editRes .modal-title').text('Edit Video Lesson') } else { $('#editRes .modal-title').text('Add Video Lesson') }
                if( data.is_remote == 1 ) { 
                    $('#editRes #is_remote1').click();
                    $('#editRes #resource_link').val(data.link);
                    $('#editRes #resource_link').addClass('required');
                    $('#editRes #resource_url').removeClass('required');
                } else { 
                    $('#editRes #is_remote0').click();
                    $('#editRes #resource_exist').val(data.resource_name);
                    $('#editRes #resource_link').removeClass('required');
                }
                $('#editRes').modal('hide');
            } else {
//                $('#deleteUserFailed').modal();
            }
        });

//        validate_resource();
    }

    function isValidURL(url) {
        var RegExp = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/i

        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }

    function loadRes( el ) {

        $('#editRes #setting_id').val(el);
        $.ajax({
            'url': base_url + 'admin/settings/loadResource',
            'type': 'GET',
            'dataType': 'json',
            'data': 'setting_id=' + el
        }).done( function(data) {
//console.log( data );
            if( data ) {
                if( data.id > 0 ) { $('#editRes .modal-title').text('Edit Lesson') } else { $('#editRes .modal-title').text('Add Lesson') }
                if( data.is_remote == 1 ) { 
                    $('#editRes #is_remote1').click();
                    $('#editRes #resource_link').val(data.link);
                    $('#editRes #resource_link').addClass('required');
                    $('#editRes #resource_url').removeClass('required');
                } else { 
                    $('#editRes #is_remote0').click();
                    $('#editRes #resource_exist').val(data.resource_name);
                    $('#editRes #resource_link').removeClass('required');
                }
                $('#editRes #res_id').val(data.id);
                $('#editRes #type').val(data.type);
            } else {
//                $('#deleteUserFailed').modal();
            }
        });

        $('#editRes').modal('show');
    }

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
                    window.location.href = '<?php echo base_url()?>c1'
                }
            });
        } else {
            window.location.href = '<?php echo base_url()?>c1'
        }
    }

    function showAJAXError() {
        alert("Uh-oh! A ninja stole our code or a horrible error occurred.");
    }

    function setLogoutUrl(logouturl) {
        logout_url = logouturl;
        initLogout();
    }
    function initLogout() {
        if( logout_url == 'custom' ) {
            $('#logout_url').show();
        } else {
            $('#logout_url').hide();
        }
    }
</script>
