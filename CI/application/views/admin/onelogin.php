 <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="javascript:;">
                       Welcome Admin
                    </a>
                     
                </li>
                <li>
                    <a href="<?php echo base_url('admin/dashboard')?>">Dashboard</a>
                </li>
               
                <li>
                    <a href="<?php echo base_url('admin/imports')?>">Imports</a>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/subjects')?>">Subjects</a>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/onelogin')?>">Onelogin</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
<a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="icon-home">< Menu ></i></a>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Onelogin</h2>
                    </div>
                </div>

                <div class="row">
                    <form class="form-horizontal" action="<?php echo base_url('admin/onelogin/create_user')?>" method="POST">
                        <?php echo validation_errors(); ?>

                        <div class="form-group">
                            <label for="subject" class="col-sm-2 control-label">First name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="first_name" placeholder="First name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject" class="col-sm-2 control-label">Surname</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="surname" placeholder="Surname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                        </div>





                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" name="submit" value="true">Save</button>
                            </div>
                        </div>






                    </form>




                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->