<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.fineuploader-3.5.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/admin-user-import.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>css/fineuploader-3.5.0.css" type="text/css" />

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h2>User Management</h2>
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
                                <strong>
                                    Your file passed validation, here's how it will be mapped during import:<br />
                                    <ul></ul>
                                </strong>
                                <div>
                                    <label for="autocreate">Automatically create missing years and classes</label>
                                    <input type="checkbox" id="autocreate" checked="checked"/>
                                    <input type="hidden" id="filename" value="" />
                                </div>
                                <div>
                                    <input type="button" value="Import Data" name="importdata" id="importdata" class="btn btn-small btn-primary btn-primary-override form-control" style="width: 125px;">                                    
                                </div>
                            </div>
                            <div class="text-info" style="padding: 10px 10px 0; display: none;" id="file-success">
                                <strong>
                                    Your file was imported. Here's a short summary:<br />
                                    <ul></ul>
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>