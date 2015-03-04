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