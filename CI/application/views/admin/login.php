
    <div class="container">
        <img class="admin_logo" src="<?php echo base_url()?>img/logo_login.png" />
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                       
                        <?php echo validation_errors()?>
                        <?php echo isset($login_errors)?$login_errors:''?>
                        <form role="form" action="<?php echo base_url('admin/login')?>" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" value="<?php echo set_value('email')?>" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                
                                <input type="hidden" name="csfr" value="true"/>
                                
                                <button type="submit" class="btn btn-lg btn-success btn-block" name="submit" value="true">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
