<style type="text/css">
    header .right.open a.dropdown-toggle { height: 62px; }
    .dropdown-menu { background: #e74c3c; border-radius: 0; margin: 0; padding: 0 10px; right: 0; left: auto; }
    .dropdown-menu li { width: 100%; }
    .dropdown-menu li a { width: 100%; line-height: 3; border-left: none; border-right: none; border-bottom: 1px solid #e03b2d; }
    .dropdown-menu li a:before { height: 100%;}
    .dropdown-menu li a:hover { background: #e03b2d; text-decoration: underline;}
    .dropdown-menu li a span { vertical-align: baseline; text-transform: none; margin-right: 10px; }
</style>

<header data-role="header" data-position="inline" id="staticheader">
    <div class="container">
        <div class="left <?php if ($_SERVER['REDIRECT_QUERY_STRING'] != '/' && $_SERVER['REDIRECT_QUERY_STRING'] != '/b1' && $_SERVER['REDIRECT_QUERY_STRING'] != '/b2') : ?> resized_bar<?php endif; ?>">
            <?php if ($_SERVER['REDIRECT_QUERY_STRING'] != '/' && $_SERVER['REDIRECT_QUERY_STRING'] != '/b1' && $_SERVER['REDIRECT_QUERY_STRING'] != '/b2') : ?>
                <!-- <a onclick="backButtonPress('{firstBack}','{secondback}')" href="javascript:;" data-icon="arrow-l">Back</a>-->
                <a onclick="window.history.back()" href="javascript:;" id="backbutton"><span class="glyphicon glyphicon-chevron-left"></span></a>
            <?php endif; ?>
            <a href="/" class="home"><span class="glyphicon glyphicon-home"></span></a>   
            <form id="formsearch" action="javascript:void(0)" enctype="multipart/form-data" method="post">
                <a href="#" class="search"><span class="glyphicon glyphicon-search"></span></a>
                <div id="search-label"><label for="search-terms" id='search-label-target'>search</label></div>
                <div class='span2' id="input"><input type="text" data-type="search" name="search-terms" id="search-terms" placeholder="Enter search..."></div>
            </form>
        </div>
        <div class="right">
<!--            <a href="/logout" id="la_bt" class="logout"><span class="glyphicon glyphicon-user"></span></a>-->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span></a>
            <ul class="dropdown-menu">
                <li><a style="text-align: left;">{user_full_name}</a></li>
                <?php if( $onelogin_allowed ): ?>
                <li><a href="/a1/passwordchange" style="text-align: left;"><span class="glyphicon glyphicon-edit"></span><span>Change Password</span></a></li>
                <?php endif ?>
                <li><a href="/logout" id="la_bt" class="logout" style="text-align: left;"><span class="glyphicon glyphicon-log-out"></span><span>LOGOUT</span></a></li>
                <li role="separator" class="divider"></li>
                <?php if( $tagger_type === 'teacher' ): ?>
                <!--li>{tvl_creating_resources}</li>
                <li>{tvl_interactive_lessons}</li>
                <li>{tvl_setting_homework}</li>
                <li>{tvl_submitting_homework}</li>
                <li>{tvl_marking_homework}</li-->
                <?php endif ?>
                <?php if( $tagger_type === 'student' ): ?>
                <!--li>{svl_creating_resources}</li>
                <li>{svl_interactive_lessons}</li>
                <li>{svl_setting_homework}</li>
                <li>{svl_submitting_homework}</li>
                <li>{svl_marking_homework}</li-->
                <?php endif ?>
<!--                <li class="dropdown-header">Nav header</li>-->
            </ul>
        </div>
        <?php if( $enable_feedback ): ?>
        <div class="right">
            <a href="#" data-toggle="modal" data-target="#feedbackModal"><span class="glyphicon glyphicon-comment"></span></a>
        </div>
        <?php endif; ?>
        <div class="right"><a href="#" data-toggle="modal" data-target="#tagWorkModal"><span class="glyphicon glyphicon-paperclip"></span></a></div>
        <div class="logo">
            <a href="/" ><img src="/img/logo_top.png" /></a>
        </div>
    </div>
</header>

<div id="tagWorkModal" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div class="tag-work-modal-header">
                <h4 class="modal-title">Tag Work</h4>
            </div>
            <div class="tag-work-modal-body">
                <form class="form-horizontal" id="formWorkModal">
                    <input type="hidden" name="work_uuid" id="work_uuid" />
                    <input type="hidden" name="tagger_id" id="tagger_id" value="<?php echo($tagger_id); ?>" />
                    <div class="form-group grey no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label class="scaled pull-left">Work Type:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <fieldset onchange="changeTagWorkResourceType();" data-role="controlgroup" data-type="horizontal" data-role="fieldcontain" class="radio_like_button pull-left" style="width: 100%;"> 
                                <input type="radio" name="work_resource_remote_ctrl" id="work_resource_remote0" value="0">
                                <label for="work_resource_remote0" class="pull-left">Local file</label>
                                <input type="radio" name="work_resource_remote_ctrl" id="work_resource_remote1" value="1" checked="checked">
                                <label for="work_resource_remote1" class="pull-left">Online file</label>
                            </fieldset> 
                        </div>
                        <div class="col-sm-9 col-sm-offset-3 col-xs-12 hidden">
                            <div class="padding-top-15px" id="addedWorkItems">
                                <table class="table"></table>
                            </div>
                        </div>
                    </div>

                    <div id="work_resource_file" class="form-group grey no-side-margin side-padding-3" style="display: none;">
                        <div class="col-sm-3 col-xs-12">
                            <label class="scaled pull-left" for="work_resource_url">Work File:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <div class="controls" style="position: relative">
                                <span></span>
                                <section class="work-progress-demo" style="padding:0 10px; margin-top: 13px; float: left;">
                                    <div id="work-manual-fine-uploader" style="padding:10px; width:140px; position:absolute; z-index:100; margin-top:0px;"></div>
                                    <button class="ladda-button" data-color="blue" data-size="s" data-style="expand-right" type="button">Browse File</button>
                                </section>
                                <div class="c2_radios upload_box" style="float: left; margin-top: 13px; display: none;">
                                    <input type="checkbox" id="work_file_uploaded_f"  value="" disabled="disabled" checked="checked">
                                    <label for="work_file_uploaded_f" id="work_file_uploaded_label" style="width: auto!important;float: left;"></label>
                                </div>
                                <div class="error_filesize"></div>
                            </div>
                        </div>
                    </div>

                    <div id="work_resource_remote" class="form-group grey no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label for="work_resource_link" class="scaled pull-left">Work URL:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <div class="field search controls">
                                <span id="invalidWorkURL" class="tip2" style="display: none;">Work URL is not valid!</span>
                                <span id="unsubmittedWorkURL" class="tip2" style="display: none;">Please confirm the URL by pressing the 'Add' button!</span>
                                <button id="submitURLButton" class="ladda-button" data-color="blue" data-style="zoom-in"><span class="ladda-label">Add</span></button>
                                <div class="fc">
                                    <input type="text" name="work_resource_link" id="work_resource_link" data-validation-required-message="Please provide a resource file or location">
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if( $tagger_type === 'teacher') { ?>
                    <div id="work_taggees" class="form-group no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label for="work_tagged_students" class="scaled pull-left">Student(s):</label>
                        </div>
                        <div class="col-sm-9 col-xs-12" style="/*max-height: 120px; overflow-y: auto;*/">
                            <span id="no_students_tagged" class="tip2" style="display: none;">Please tag at least one student!</span>
                            <div class="tagged_students" id="tagged_students">
                                <input type="text" id="work_tagged_students" name="work_tagged_students" style="display: block;" />
                                <input type="hidden" id="work_tagged_students_a" name="work_tagged_students_a" />
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if ($tagger_type === 'student') { ?>
                    <div id="work_taggees" class="form-group no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label class="scaled pull-left">Student:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <input type="text" id="work_tagged_students" name="work_tagged_students" style="display: none;" value="-<?php echo $tagger_id; ?>-"/>
                            <label class="scaled pull-left" style="padding-left: 15px;"><?php echo $tagger_name; ?></label>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-group no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label for="work_title" class="scaled pull-left">Title:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <span id="no_title_entered" class="tip2" style="display: none;">Please enter title!</span>
                            <input type="text" name="work_title" id="work_title" placeholder="Type a title" maxlength="50" />
                        </div>
                    </div>

                    <div id="work-subject" class="form-group no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label for="work_subject" class="scaled pull-left">Subject:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <span id="no_subject_selected" class="tip2" style="display: none;">Please select subject!</span>
                            <select name="work_subject" id="work_subject" disabled="disabled">
                                <option value="0">Select Student(s) First</option>
                            </select>
                        </div>
                    </div>

                    <div id="work-assignments" class="form-group no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label for="work_assignment" class="scaled pull-left">Tag to Assignment?</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <select name="work_assignment" id="work_assignment" disabled="disabled">
                                <option value="0">Select Subject First</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tag-work-modal-footer tag-work-buttons">
                <h5 class="ajax-error text-error" style="display: none; text-align: right;">An error occurred while trying to submit your feedback.</h5>
                <h5 class="tag-work-pending text-pending" style="display: none; text-align: right;">Saving work, please wait...</h5>
                <h5 class="tag-work-complete text-success" style="display: none; text-align: right;">Your work has been saved.</h5>
                <button type="button" class="btn red_btn" data-dismiss="modal" id="cancel_work">CANCEL</button>
                <button type="button" class="btn green_btn" id="submit_work">SAVE</button>
            </div>
        </div>
    </div>
</div>

<div id="workItemDelete" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title"></h4>
            </div>
            <input type="hidden" id="deleteWorkItemID" />
            <div class="modal-body">Please confirm you would like to delete the work item "<span id="deleteWorkItemName" style="word-wrap: break-word; color: #e74c3c;"></span>"?</div>
            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="workItemDeleteBtn" type="button" class="btn orange_btn del_resource">CONFIRM</button>
            </div>
        </div>
    </div>
</div>

<div id="feedbackModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div class="feedback-modal-header">
                <h4 class="modal-title">Ediface Feedback</h4>
            </div>
            <div class="feedback-modal-body">
                <h5 class="no-error">Feedback Details</h5>
                <h5 class="feedback-error text-error">Please provide feedback details.</h5>
                <h5 class="ajax-error text-error">An error occurred while trying to submit your feedback.</h5>
                <textarea id="feedback_details" placeholder="Please enter details about what you would like to see, what issues you encountered or any other suggesstions or feedback you may have..."></textarea>
            </div>
            <div class="feedback-modal-footer feedback-buttons">
                <button type="button" class="btn red_btn" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn green_btn" id="submit_feedback">Submit</button>
            </div>
            <div class="feedback-modal-footer feedback-pending" style="display: none; padding-right: 10px;">
                <h5 style="text-align: right;">Submitting your feedback, please wait...</h5>
            </div>
            <div class="feedback-modal-footer feedback-confirmation" style="display: none;">
                <h5>Thank you. Your feedback has been submitted.</h5>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url("js/ladda/dist/ladda.min.css") ?>" type="text/css" />
<script src="<?php echo base_url("/js/ladda/dist/spin.min.js") ?>"></script>
<script src="<?php echo base_url("/js/ladda/dist/ladda.min.js") ?>"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.fineuploader-3.5.0.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>css/fineuploader_resources.css" type="text/css" />

<script src="/js/classie.js"></script>
<script src="/js/search.js"></script>
<script>
    var Sladda = Ladda.create(document.querySelector('a.search'));
    var tmOut;

    $("#formsearch").keyup(function (event) {
        if (event.keyCode == 13) {
            Sladda.start();
            $('#formsearch a.search').css('background-color', '#e74c3c');
            $('#formsearch a.search').children('.ladda-label').children('.glyphicon').remove();
            window.location.href = ('/s1/results/' + $('#search-terms').val());
        }
    });

    $(document).ready(function () {
        $('#feedbackModal').on('show.bs.modal', function (e) {
            $('.feedback-modal-body .no-error').hide();
            $('.feedback-modal-body .ajax-error').hide();
            $('.feedback-modal-body .feedback-error').hide();
            $('.feedback-confirmation').hide();
            $('.feedback-pending').hide();
            $('.feedback-buttons').show();
        });

        $('#tagWorkModal').on('show.bs.modal', function (e) {
            $.get('<?php echo base_url() ?>' + 'work/uuid', function (response) {
                var data = JSON.parse(response);
                var uuid = data.identifier;

                $('#tagWorkModal #work_uuid').val(uuid);
                $('#tagWorkModal .tag-work-modal-body .no-error').hide();
                $('#tagWorkModal .tag-work-modal-body .ajax-error').hide();
                $('#tagWorkModal .tag-work-modal-body .tag-work-error').hide();
                $('#tagWorkModal .tag-work-confirmation').hide();
                $('#tagWorkModal .tag-work-pending').hide();

                if (data.hasSubjects) {
                    $.each(data.subjects, function (k, v) {
                        $('#tagWorkModal #work_subject').append('<option value="' + v.id + '">' + v.name + '</option>');
                    });

                    $('#tagWorkModal #work_subject option[value="0"]').text('Select Subject');
                    $('#tagWorkModal #work-subject span.select span.v').text('Select Subject');
                    $('#tagWorkModal #work-subject span.select span.v').removeClass('disabled-control');
                    $('#tagWorkModal #work-subject span.select span.a').removeClass('disabled-control');
                    $('#tagWorkModal #work_subject').removeAttr('disabled');
                }

                $('#tagWorkModal .tag-work-buttons').show();
            });
        });

        $('#tagWorkModal').on('hidden.bs.modal', function (e) {
            $('#tagWorkModal #work_tagged_students').val('');
            $('#tagWorkModal #work_tagged_students_a').val('');
            $('#tagWorkModal .tagged_student').remove();
            $('#tagWorkModal #work_title').val('');
            $('#tagWorkModal #no_title_entered').hide();
            $('#tagWorkModal #work_title').removeClass('error-element');
            $('#tagWorkModal #work_subject').val('0');
            $('#tagWorkModal #work_subject').find("option:gt(0)").remove();
            $('#tagWorkModal #work_subject').trigger('change');
            $('#tagWorkModal #work-subject span.select span.v').text('Select Student(s) First');
            $('#tagWorkModal #work-subject span.select span.v').addClass('disabled-control');
            $('#tagWorkModal #work-subject span.select span.a').addClass('disabled-control');
            $('#tagWorkModal #work_subject').attr('disabled', 'disabled');
            $('#tagWorkModal #work_assignment').find("option:gt(0)").remove();
            $('#tagWorkModal #work_assignment').trigger('change');
            $('#tagWorkModal #work-assignments span.select span.v').addClass('disabled-control');
            $('#tagWorkModal #work-assignments span.select span.a').addClass('disabled-control');
            $('#tagWorkModal #work_assignment').attr('disabled', 'disabled');
            $('#tagWorkModal #submit_work').show();
            $('#tagWorkModal .tag-work-buttons .text-error').hide();
            $('#tagWorkModal .tag-work-buttons .text-success').hide();
            $('#tagWorkModal .tag-work-buttons .text-pending').hide();
            $('#tagWorkModal #addedWorkItems table').html('');
            $('#tagWorkModal #addedWorkItems').parent().addClass('hidden');
            $('#tagWorkModal #submit_work').show();
        });

        setTimeout(function () {
            $('#tagWorkModal #work-subject span.select span.v').addClass('disabled-control');
            $('#tagWorkModal #work-subject span.select span.a').addClass('disabled-control');
            $('#tagWorkModal #work-assignments span.select span.v').addClass('disabled-control');
            $('#tagWorkModal #work-assignments span.select span.a').addClass('disabled-control');
        }, 1000);

        $('#feedback_details').keyup(function () {
            var feedback = $('#feedback_details').val();
            if ($.trim(feedback) === '') {
                $('.feedback-modal-body .no-error').hide();
                $('.feedback-modal-body .ajax-error').hide();
                $('.feedback-modal-body .feedback-error').show();
            } else {
                $('.feedback-modal-body .feedback-error').hide();
                $('.feedback-modal-body .ajax-error').hide();
                $('.feedback-modal-body .no-error').show();
            }
        });

        $('#tagWorkModal #work_resource_link').change(function () {
            var url = $('#tagWorkModal #work_resource_link').val();
            if (validURL(url)) {
                $('#tagWorkModal #invalidWorkURL').hide();
                $('#tagWorkModal #work_resource_remote div.fc').removeClass('error-element');
            } else {
                $('#tagWorkModal #invalidWorkURL').show();
                $('#tagWorkModal #work_resource_remote div.fc').addClass('error-element');
            }
        });
    });

    $('#submit_feedback').click(function () {
        var breadcrumbs = '';
        var feedback = $('#feedback_details').val();
        if ($.trim(feedback) === '') {
            $('.feedback-modal-body .no-error').hide();
            $('.feedback-modal-body .ajax-error').hide();
            $('.feedback-modal-body .feedback-error').show();
            return;
        } else {
            $('.feedback-modal-body .feedback-error').hide();
            $('.feedback-modal-body .ajax-error').hide();
            $('.feedback-modal-body .no-error').show();
        }

        $('ul.breadcrumb li').each(function () {
                if (breadcrumbs !== '') {
                    breadcrumbs = breadcrumbs + ' > ';
                }
                breadcrumbs = breadcrumbs + $(this).text();
            });

        if (breadcrumbs === '') {
            breadcrumbs = 'Home';
        }

        $('.feedback-buttons').hide();
        $('.feedback-pending').show();

        $.ajax({
            'url': '/ajax/feedback/save_feedback',
            'type': 'POST',
            'dataType': 'json',
            'data': 'feedback=' + encodeURIComponent(feedback) + '&path=' + encodeURIComponent(breadcrumbs) + '&location=' + encodeURI(document.URL)
        }).done(function (data) {
            if (data.status) {
                $('.feedback-pending').hide();
                $('.feedback-confirmation').show();
                setTimeout(function () {
                    $('#feedback_details').val('');
                    $('#feedbackModal').modal('hide');
                }, 3000);
            } else {
                $('.feedback-modal-body .feedback-error').hide();
                $('.feedback-modal-body .no-error').hide();
                $('.feedback-modal-body .ajax-error').show();
            }
        }).fail(function () {
            $('.feedback-modal-body .feedback-error').hide();
            $('.feedback-modal-body .no-error').hide();
            $('.feedback-modal-body .ajax-error').show();
        });
    });

    $('#submitURLButton').click(function () {
                                    var url = $('#tagWorkModal #work_resource_link').val();
                                    if (validURL(url)) {
                                        $('#tagWorkModal #invalidWorkURL').hide();
                                        $('#tagWorkModal #work_resource_remote div.fc').removeClass('error-element');
                                        $.ajax({
                                            type: "POST",
                                            url: '<?php echo base_url() ?>' + 'work/url_upload',
                                            data: 'url=' + url + '&uuid=' + $('#tagWorkModal #work_uuid').val(),
                                            dataType: 'json',
                                            success: function (data) {
                                                $('#tagWorkModal #submitURLButton .ladda-label').text('Added');
                                                $('#tagWorkModal #addedWorkItems table').append('\n\
                                                    <tr data-id="' + data.id + '">\n\
                                                        <td class="width-10-percent text-center"><span class="icon ' + data.type + '"></span></td>\n\
                                                        <td class="text-left">' + data.name + '</td>\n\
                                                        <td class="width-10-percent text-center">\n\
                                                            <a href="javascript: deleteWorkItem(' + data.id + ',\'' + data.fullname + '\');" class="delete2"></a>\n\
                                                        </td>\n\
                                                    </tr>');
                                                $('#tagWorkModal #addedWorkItems').parent().removeClass('hidden');
                                                $('#tagWorkModal #unsubmittedWorkURL').hide();
                                                $('#tagWorkModal #work_resource_remote div.fc').removeClass('error-element');
                                                setTimeout(function () {
                                                    $('#tagWorkModal #submitURLButton .ladda-label').text('Add');
                                                    $('#tagWorkModal #work_resource_link').val('');
                                                }, 300);
                                            }
                                        });
                                    } else {
                                        $('#tagWorkModal #invalidWorkURL').show();
                                        $('#tagWorkModal #work_resource_remote div.fc').addClass('error-element');
                                    }

                                    return false;
        });

        $('#tagWorkModal #work_title').change(function () {
            if (parseInt($.trim($(this).val()).length, 10) > 0) {
                $('#tagWorkModal #no_title_entered').hide();
                $('#tagWorkModal #work_title').removeClass('error-element');
            }
        });

//        $('#tagWorkModal #cancel_work').click(function () {
//            $('#tagWorkModal').close();
//        })
        $('#tagWorkModal #submit_work').click(function () {
            var url = $('#tagWorkModal #work_resource_link').val();
            if ($.trim(url) != '') {
                $('#tagWorkModal #unsubmittedWorkURL').show();
                $('#tagWorkModal #work_resource_remote div.fc').addClass('error-element');
                $('#tagWorkModal #submit_work').show();
                return;
            }

            if (taggedStudentsCount() === 0) {
                $('#tagWorkModal #no_students_tagged').show();
                $('#tagWorkModal #work_taggees #tagged_students input').addClass('error-element');
                $('#tagWorkModal #submit_work').show();
                return;
            }

            var workTitle = $.trim($('#tagWorkModal #work_title').val());
            if (workTitle == '') {
                $('#tagWorkModal #no_title_entered').show();
                $('#tagWorkModal #work_title').addClass('error-element');
                $('#tagWorkModal #submit_work').show();
                return;
            }

            var subject = parseInt($('#tagWorkModal #work_subject').val(), 10);
            if (!subject > 0) {
                $('#tagWorkModal #no_subject_selected').show();
                $('#tagWorkModal #work_subject').parent().addClass('error-element');
                $('#tagWorkModal #submit_work').show();
                return;
            }

            $('#tagWorkModal .tag-work-buttons .text-error').hide();
            $('#tagWorkModal .tag-work-buttons .text-success').hide();
            $('#tagWorkModal .tag-work-buttons .text-pending').show();

            $('#tagWorkModal #submit_work').hide();
            var assignment = $('#tagWorkModal #work_assignment').val();

            $.ajax({
                                        type: "POST",
                                        url: '<?php echo base_url() ?>' + 'work/save_work',
                                        dataType: "json",
                                        data: {
                                            'taggedStudents': $('#work_tagged_students').val(),
                                            'title': workTitle,
                                            'subject': subject,
                                            'assignment': assignment,
                                            'uuid': $('#tagWorkModal #work_uuid').val()
                                        },
                                        success: function (data) {
                                            if (data.status) {
                                                $('#tagWorkModal .tag-work-buttons .text-pending').hide();
                                                $('#tagWorkModal .tag-work-buttons .text-success').show();
                                                setTimeout(function () {
                                                    $('#tagWorkModal').modal('hide');
                                                }, 3000);
                                            } else {
                                                $('#tagWorkModal #submit_work').show();
                                                $('#tagWorkModal .tag-work-buttons .text-error').show();
                                                $('#tagWorkModal .tag-work-buttons .text-success').hide();
                                                $('#tagWorkModal .tag-work-buttons .text-pending').hide();
                                            }
                                        },
                                        error: function () {
                                            $('#tagWorkModal #submit_work').show();
                                            $('#tagWorkModal .tag-work-buttons .text-error').show();
                                            $('#tagWorkModal .tag-work-buttons .text-success').hide();
                                            $('#tagWorkModal .tag-work-buttons .text-pending').hide();
                                        }
            });
        });

    $('#tagWorkModal #work_subject').change(function () {
        if (parseInt($(this).val(), 10) > 0) {
            $('#tagWorkModal #no_subject_selected').hide();
            $('#tagWorkModal #work_subject').parent().removeClass('error-element');
        }

        var totalStudentsCount = taggedStudentsCount();
        if (totalStudentsCount === 0) {
            clearAssignments();
        } else if (totalStudentsCount === 1) {
            if (parseInt($(this).val(), 10) > 0) {
                loadAssignments();
            } else {
                clearAssignments();
            }
        } else {
            clearAssignments('N/A');
        }
    });

    function changeTagWorkResourceType() {
        if ($('#tagWorkModal input[name="work_resource_remote_ctrl"]:checked').val() == 1) {
            $('#tagWorkModal #work_resource_url').removeClass('required');
            $('#tagWorkModal #work_resource_link').addClass('required');
            $('#tagWorkModal #work_resource_file').hide();
            $('#tagWorkModal #work_resource_remote').show();
        } else {
            $('#tagWorkModal #work_resource_file').show();
            $('#tagWorkModal #work_resource_remote').hide();
            $('#tagWorkModal #work_resource_url').addClass('required');
            $('#tagWorkModal #work_resource_link').removeClass('required');
        }
    }

    function validURL(url) {
        var RegExp = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/i
        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteWorkItem(id, name) {
        $('#deleteWorkItemName').text(name);
        $('#deleteWorkItemID').val(id);
        $('#workItemDelete').modal({
            backdrop: 'static'
        });
    }

    function taggedStudentsCount() {
        var tagged = $.trim($('#tagWorkModal #work_tagged_students').val());
        var students = tagged.split('-');
        var count = 0;

        $.each(students, function (k, v) {
            if (!isNaN(parseInt(v, 10))) {
                count++;
            }
        });
        return count;
    }

    function loadStudentsSubjects() {
            clearStudentSubjects();

            var totalStudentsCount = taggedStudentsCount();
            if (totalStudentsCount === 0) {
                clearStudentSubjects();
                clearAssignments('Select Subject First');
                return;
            }
            if (totalStudentsCount === 1) {
                clearAssignments('Select Subject First');
            } else {
                clearAssignments('N/A');
            }

            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>' + 'work/get_students_common_subjects',
                dataType: "json",
                data: {students: $('#tagWorkModal #work_tagged_students').val()},
                success: (function (data) {
                    if (data.hasCommonSubjects) {
                        $.each(data.subjects, function (k, v) {
                            $('#work_subject option[value="0"]').text('Select Subject');
                            $('#work-subject span.select span.v').text('Select Subject');
                            $('#tagWorkModal #work_subject').append('<option value="' + k + '">' + v + '</option>');
                            $('#tagWorkModal #work-subject span.select span.v').removeClass('disabled-control');
                            $('#tagWorkModal #work-subject span.select span.a').removeClass('disabled-control');
                            $('#tagWorkModal #work_subject').removeAttr('disabled');
                        });
                    } else {
                        if (totalStudentsCount === 1) {
                            $('#work_subject option[value="0"]').text('No subjects found');
                            $('#work-subject span.select span.v').text('No subjects found');
                        } else {
                            $('#work_subject option[value="0"]').text('No common subjects');
                            $('#work-subject span.select span.v').text('No common subjects');
                        }
                    }
                })
            });
        }

    function clearStudentSubjects() {
            $('#tagWorkModal #work_subject').find("option:gt(0)").remove();
            $('#tagWorkModal #work_subject option[value="0"]').text('Select Student(s) First');
            $('#tagWorkModal #work-subject span.select span.v').text('Select Student(s) First');
            $('#tagWorkModal #work_subject').trigger('change');
            $('#tagWorkModal #work-subject span.select span.v').addClass('disabled-control');
            $('#tagWorkModal #work-subject span.select span.a').addClass('disabled-control');
            $('#tagWorkModal #work_subject').attr('disabled', 'disabled');
        }

    function loadAssignments() {
            var addedStudents = $('#tagWorkModal #work_tagged_students').val().split('-');
            var studentID = addedStudents[1];
            var selectedSubject = $('#tagWorkModal #work_subject').val();

            $.ajax({
                url: '/work/load_student_assignments',
                data: {student_id: studentID, subject_id: selectedSubject},
                dataType: "json",
                success: function (data) {
                    if (data.hasAssignments) {
                        clearAssignments('Select assignment');
                        $.each(data.assignments, function (subject, v) {
                            var optGroup = $('<optgroup label="' + subject + '"></optgroup>');
                            $.each(v, function (k, vv) {
                                optGroup.append('<option value="' + vv.id + '">' + vv.title + '</option>');
                            });
                            optGroup.appendTo('#tagWorkModal #work_assignment');
                        });
                        $('#tagWorkModal #work-assignments span.select span.v').removeClass('disabled-control');
                        $('#tagWorkModal #work-assignments span.select span.a').removeClass('disabled-control');
                        $('#tagWorkModal #work_assignment').removeAttr('disabled');
                    } else {
                        clearAssignments('No assignments found');
                    }
                }
            });
        }

    function clearAssignments(newLabel) {
            var label = newLabel || 'Select Subject First';
            $('#tagWorkModal #work_assignment').find("option:gt(0)").remove();
            $('#tagWorkModal #work_assignment').find("optgroup").remove();
            $('#tagWorkModal #work_assignment option[value="0"]').text(label);
            $('#tagWorkModal #work-assignments span.select span.v').text(label);
            $('#tagWorkModal #work_assignment').trigger('change');
            $('#tagWorkModal #work-assignments span.select span.v').addClass('disabled-control');
            $('#tagWorkModal #work-assignments span.select span.a').addClass('disabled-control');
            $('#tagWorkModal #work_assignment').attr('disabled', 'disabled');
        }

    $('#workItemDeleteBtn').click(function () {
            var id = $('#deleteWorkItemID').val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>' + 'work/delete_temp_item',
                dataType: "json",
                data: {id: id, uuid: $('#tagWorkModal #work_uuid').val()},
                success: (function () {
                    $('#workItemDelete').modal('hide');
                    $('#tagWorkModal tr[data-id="' + id + '"]').remove();
                    if ($('#tagWorkModal tr[data-id]').length == 0) {
                        $('#tagWorkModal #addedWorkItems').parent().addClass('hidden');
                    }
                })
            });
        });

    var wl = Ladda.create(document.querySelector('.work-progress-demo .ladda-button'));
    var w_start_timer = 0;
    var manualuploader = $('#tagWorkModal #work-manual-fine-uploader').fineUploader({
        request: {
            endpoint: '<?php echo base_url() ?>' + 'work/item_upload'
        },
        validation: {
            allowedExtensions: ['jpg|JPEG|png|doc|docx|xls|xlsx|pdf|ppt|pptx'],
            sizeLimit: 22120000, // 20000 kB -- 20mb max size of each file
            itemLimit: 40
        },
        autoUpload: true,
        text: {
            uploadButton: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />&nbsp;&nbsp;&nbsp;&nbsp;'
        }
    }).on('progress', function (event, id, filename, uploadedBytes, totalBytes) {
        if (w_start_timer == 0) {
            $('#tagWorkModal #work_file_uploaded').val('');
            $('#tagWorkModal #work_file_uploaded_label').text('');
            $('#tagWorkModal .upload_box').hide();
            wl.start();
        }

        w_start_timer++;
        var wProgressPercent = (uploadedBytes / totalBytes).toFixed(2);
        if (isNaN(wProgressPercent)) {
            $('#tagWorkModal #work_resource_file #progress-text').text('');
        } else {
                var progress = (wProgressPercent * 100).toFixed();
                wl.setProgress((progress / 100));
            if (uploadedBytes == totalBytes) {
                wl.stop();
            }
        }
    }).on('upload', function (event, id, filename) {
        clearTimeout(tmOut);
        $(this).fineUploader('setParams', {'filename': filename, 'uuid': $('#work_uuid').val()});
    }).on('complete', function (event, id, file_name, responseJSON) {
        w_start_timer = 0;
        var data = JSON.parse(JSON.stringify(responseJSON));
        $('#tagWorkModal #addedWorkItems table').append('\n\
            <tr data-id="' + data.id + '">\n\
            <td class="width-10-percent text-center"><span class="icon ' + data.type + '"></span></td>\n\
            <td class="text-left">' + data.name + '</td>\n\
            <td class="width-10-percent text-center">\n\
            <a href="javascript: deleteWorkItem(' + data.id + ',\'' + data.fullname + '\');" class="delete2"></a>\n\
            </td>\n\
            </tr>');
        $('#tagWorkModal #addedWorkItems').parent().removeClass('hidden');
        $('#tagWorkModal #work_resource_file .ladda-label').text('File Uploaded. Add Another?');
        $('#tagWorkModal #work_resource_file #work_file_uploaded').val(data.name);
        $('#tagWorkModal #work_resource_file #work_file_uploaded_label').text(file_name);
        $('#tagWorkModal #work_resource_file .upload_box').fadeIn(300);
        tmOut = setTimeout(function () {
            $('#tagWorkModal #work_resource_file .ladda-label').text('Browse File');
            $('#tagWorkModal #work_resource_file .upload_box').hide();
            $('#tagWorkModal #work_resource_file #work_file_uploaded').val('');
            $('#tagWorkModal #work_resource_file #work_file_uploaded_label').text('');
        }, 3000);
    });
</script>
<script>
    $('.tagged_students').each(function () {
        var t = this;
        var $t = $(t);
        var $input = $('> input', t);
        var students = $input.val();
        st = students.slice(1, -1);
        students = st.split(',');

        var addStudent = function (student, drawOnly) {
            if (student) {
                var studentID = student.attr('data-student-id');
                var studentName = student.text();

                if (!drawOnly) {
                    var students2 = $.trim($input.val());
                    students2 = students2 + '-' + studentID + '-';
                    $input.val(students2);

                    loadStudentsSubjects();
                }
                $('.input-container', t).before('<div class="tagged_student" data-student-id="' + studentID + '"><span>' + studentName + '</span><a class="remove"></a></div>');
                $('.list').html('');

                $('#tagWorkModal #no_students_tagged').hide();
                $('#tagWorkModal #work_taggees #tagged_students input').removeClass('error-element');

                $('#tagWorkModal #tagged_students .input-container input').focus();
            }
        };

        var removeStudent = function () {
            var students2 = $input.val();
            students2 = students2.replace('-' + $(this).parent().attr('data-student-id') + '-', '');
            $input.val(students2);

            $(this).parent().remove();
            $('.list').html('');

            loadStudentsSubjects();

            $('#tagWorkModal #tagged_students .input-container input').focus();
        };

        $input.css({'display': 'none'});

        $t.append('<div class="input-container"><input value="" type="text"><div><div class="list"></div>');

        $t.on('keyup', '.input-container input', function () {
            var v = $.trim($(this).val());
            var to = $t.data('to');
            if (to)
                clearTimeout(to);
            to = false;
            if (v) {
                if (v.length > 1) {
                    to = setTimeout(function () {
                        $.ajax({
                            url: '/work/suggest_students',
                            data: {q: v},
                            dataType: "json",
                            success: function (data) {
                                var list = '';
                                if (data.length > 0) {
                                    $.each(data, function (i, v) {
                                        list += '<li data-student-id="' + v.id + '">' + v.name + '</li>';
                                    });
                                } else {
                                    list += '<li>No students found.</li>';
                                    setTimeout(function () {
                                        $('.list').html('');
                                    }, 3000);
                                }
                                $('.list').html('<ul>' + list + '</ul>');
                            }
                        });
                    }, 200);
                    $t.data('to', to);
                }
            }
        }).on('keydown', '.input-container input', function (e) {
            setTimeout(function () {
                $('#tagWorkModal #invalidWorkURL').hide();
                $('#tagWorkModal #work_resource_remote div.fc').removeClass('error-element');
            }, 5);
        }).on('click', '.list li[data-student-id]', function () {
            var student = $(this);
            if (student) {
                $('.input-container input', t).val('');
                addStudent(student);
            }
        }).on('click', '.tagged_student .remove', function () {
            removeStudent.call(this);
        });
    });
</script>
