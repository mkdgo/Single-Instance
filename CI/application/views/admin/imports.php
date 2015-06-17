<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.fineuploader-3.5.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/admin-user-import.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>css/fineuploader-3.5.0.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/prettyCheckable/prettyCheckable.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/prettyCheckable/prettyCheckable.css" type="text/css" />

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h2>User Management</h2>
                    <div class="col-lg-12"><a id="clear-tables" href="javascript:;" style="float: right;"><button class="btn btn-danger">Clear Tables</button></a></div>

                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="active">Users :: Import</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>User Import</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="portlet-body">
                            <div id="manual-fine-uploader" class="btn btn-default" style="padding:0 10px;height: 22px;margin-top:10px;"></div>
                            <div style="padding: 10px 10px 0;">
                                <em>*Please note that your spreadsheet <strong>must</strong> containt the following header row values (case insensitive):</em><br />
                                <ul>
                                    <li>Type (values either "student" or "teacher")</li>
                                    <li>Email <strong><em>or</em></strong> Email Address <strong><em>or</em></strong> EmailAddress</li>
                                    <li>Password</li>
                                    <li>First <strong><em>or</em></strong> First Name <strong><em>or</em></strong> FirstName</li>
                                    <li>Last <strong><em>or</em></strong> Last Name <strong><em>or</em></strong> LastName</li>
                                    <li>Year</li>
                                </ul>
                            </div>
                            <div class="text-danger" style="padding: 10px 10px 0; display: none;" id="file-errors">
                                <strong>
                                    Your file failed validation for the following reasons:
                                    <ul></ul>
                                </strong>
                            </div>
                            <div class="text-info" style="padding: 10px 10px 0; display: none;" id="file-valid">
                                <strong class="text-ediface-darker">
                                    Your file passed validation, here's how it will be mapped during import:<br />
                                    <ul class="text-ediface-lighter"></ul>
                                </strong>
                                <h3 class="text-ediface-darker">
                                    <input type="checkbox" id="autocreate" checked="checked" data-label="Automatically create missing years and classes" />
                                    <input type="hidden" id="filename" value="" />
                                </h3>
                                <div>
                                    <input type="button" value="Import Data" name="importdata" id="importdata" class="btn btn-small btn-primary btn-primary-override form-control" style="width: 125px;">                                    
                                </div>
                            </div>
                            <div class="text-ediface-darker" style="padding: 10px 10px 0; display: none;" id="file-success">
                                <strong>
                                    Your file was imported. Here's a short summary:<br />
                                    <ul class="text-ediface-lighter"></ul>
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#clear-tables').on('click', function() {
        var el = this;
        bootbox.confirm("<center style='font-weight:700;'><span style='color:#f00;'>This action will delete all content of the database.</span><br /> Are you sure to proceed?<br />(exceptions: sources, site settings, admin)</center>", function (result) {
            if( result == true ) {
                bootbox.dialog({
                    title: "Choose which tables you want to clear.",
                    message: '<div class="row">  ' +
                        '<div class="col-md-12"> ' +
                        '<form id="clear-form" class="form-horizontal"> ' +
                        '<div class="form-group"><div class="col-sm-offset-2 col-sm-10"><div class="checkbox"><label><input class="cl_form" id="all" onclick="checkAll()" name="all" type="checkbox" value="1">All</label></div></div></div>' +
                        '<div class="form-group"><div class="col-sm-offset-2 col-sm-10"><div class="checkbox"><label><input class="cl_form" id="users" name="users" type="checkbox" value="1">Users</label></div></div></div>' +
                        '<div class="form-group"><div class="col-sm-offset-2 col-sm-10"><div class="checkbox"><label><input class="cl_form" id="classes" name="classes" type="checkbox" value="1">Classes</label></div></div></div>' +
                        '<div class="form-group"><div class="col-sm-offset-2 col-sm-10"><div class="checkbox"><label><input class="cl_form" id="assignments" name="assignments" type="checkbox" value="1">Assignments</label></div></div></div>' +
                        '<div class="form-group"><div class="col-sm-offset-2 col-sm-10"><div class="checkbox"><label><input class="cl_form" id="resources" name="resources" type="checkbox" value="1">Resources</label></div></div></div>' +
                        '<div class="form-group"><div class="col-sm-offset-2 col-sm-10"><div class=""><p id="err_msg"></p></div></div></div>' +
                        '</form></div></div>',
                    buttons: {
                        success: {
                            label: "Clear",
                            className: "btn-success",
                            callback: function () {
                                var chckd = false;
                                $.each( $(".cl_form"), function( index, element ) {
                                    if( $(element).prop('checked') == true ) {
                                        chckd = true;
                                    }
                                });
                                if( chckd ) {
                                    doClearTables();
                                } else {
                                    $('#err_msg').css('color','red');
                                    $('#err_msg').html('You have to choose at least one option!')
                                    return false;
                                }
                            }
                        },
                        cancel: {
                            label: "Cancel",
                            className: "btn-default",
                            callback: function() {
                                bootbox.hideAll();
                            }
                        }
                    }
                });
            }
        });
    });

    function checkAll() {
        if( $('#all').prop('checked') == false ) {
            
        } else {
            $('#users').prop('checked', true);
            $('#classes').prop('checked', true)
            $('#assignments').prop('checked', true)
            $('#resources').prop('checked', true)
        }
    }

    function doClearTables() {
        $body.addClass("loading");
        $.post( '<?php echo base_url() . 'admin/settings/clearTables' ?>', $( "#clear-form" ).serialize(), function(response) {
            // Do something with the request
            if( response.status == true ) {
                bootbox.alert("The contents was deleted.");
            } else {
                bootbox.alert("Error ocured.");
            }
        }, 'json')
        .done(function() {})
        .fail(function() {
            $body.removeClass("loading");
        })
        .always(function() {
            $body.removeClass("loading");
        })
    };

</script>