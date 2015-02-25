<script type="text/javascript" src="<?php echo base_url() ?>js/admin-users.js"></script>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h2>User Management</h2>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="active">Users :: Search</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>User Search</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="portlet-body texted-right">
                            <form class="form-inline" id="searchForm" name="searchForm">
                                <input type="hidden" name="page" id="page" value="1" />
                                <div class="form-group col-xs-12 col-sm-6 col-md-3">
                                    <label for="firstName" class="pulled-left">First Name:</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
                                </div>
                                <div class="form-group col-xs-12 col-sm-6 col-md-3">
                                    <label for="lastName" class="pulled-left">Last Name:</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
                                </div>
                                <div class="form-group col-xs-12 col-sm-6 col-md-3">
                                    <label for="emailAddress" class="pulled-left">Email Address:</label>
                                    <input type="text" class="form-control" id="emailAddress" name="emailAddress" placeholder="Email Address">
                                </div>
                                <div class="form-group col-xs-12 col-sm-6 col-md-3">
                                    <label for="userType" class="pulled-left">User Type:</label>
                                    <select class="form-control" id="userType" name="userType">
                                        <option value="all">All</option>
                                        <option value="student">Students</option>
                                        <option value="teacher">Teachers</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <input type="button" class="btn btn-default form-control" id="clear" name="clear" value="Clear">
                                </div>
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <input type="button" class="btn btn-primary btn-primary-override form-control" id="search" name="search" value="Search">
                                </div>
                            </form>

                            <div class="portlet portlet-default margin-top-20px" id="user-results" style="display: none;">
                                <div class="portlet-heading">
                                    <div class="portlet-title">
                                        <h4>Your search returned the following users:</h4>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 4%;">#</th>
                                                    <th style="width: 22%;">First Name</th>
                                                    <th style="width: 22%;">Last Name</th>
                                                    <th style="width: 22%;">Email Address</th>
                                                    <th style="width: 22%;">User Type</th>
                                                    <th>Options</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav>
                                        <div class="pull-left pagination results-label"></div>
                                        <div>
                                            <ul class="pagination results-pagination"></ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>                                

                            <div class="portlet portlet-default margin-top-20px" id="no-users-found" style="display: none;">
                                <div class="portlet-heading">
                                    <div class="portlet-title">
                                        <h4>Your search did not return any users.</h4>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirm deletion</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you would like to delete <span class="delete-user-type"></span> <span class="delete-user-first-name"></span> <span class="delete-user-last-name"></span>?</p>
                <p><em>Please note that this functionality presumes an import failed or was partially completed. Thus only the user record and class assignments will be deleted.</em></p>
            </div>
            <input type="hidden" id="delete-user-id" value="0" />
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deleteUser();">Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserSuccess" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <span class="delete-user-type"></span> <span class="delete-user-first-name"></span> <span class="delete-user-last-name"></span> deleted successfully.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserFailed" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Could not delete <span class="delete-user-type"></span> <span class="delete-user-first-name"></span> <span class="delete-user-last-name"></span>.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>