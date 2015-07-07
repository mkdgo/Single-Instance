<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h2>ElasticSearch</h2>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="active">ElasticSearch</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Options</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="portlet-body">
                            <div class="row" style="border-bottom: 1px dashed #FF0000;">
                                <div class="col-xs-12 text-red text-center text-uppercase">
                                    <h3 style="font-weight: 700;">
                                        If you are not sure what this is please do not use any of the options here.
                                    </h3>
                                </div>
                            </div>
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/status">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input type="submit" class="btn btn-primary btn-primary-override form-control" value="GET SERVER STATUS">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_status')) { ?>
                                    <div class="form-group">
                                        <?php foreach ($this->session->flashdata('es_status') as $index => $status) { ?>
                                            <div class="col-md-6">
                                                <div class="portlet portlet-default">
                                                    <div class="portlet-heading">
                                                        <div class="portlet-title">
                                                            <h4><?= $index ?></h4>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="row">
                                                            <div class="col-xs-12">Total Number of Documents: <?= $status['doc_count'] ?></div>
                                                        </div>
                                                        <?php foreach ($status['shards'] as $name => $state) { ?>
                                                            <div class="row">
                                                                <div class="col-xs-12">Shard <?= $name ?>: <?= $state ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </form>
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/createindex">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input class="col-xs-4 input" style="line-height: 30px;" type="text" name="indexname" placeholder="Index Name">
                                        <input type="submit" class="col-xs-7 btn btn-primary btn-primary-override pull-right" value="CREATE INDEX">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_createindex')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_createindex'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/deleteindex">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input class="col-xs-4 input" style="line-height: 30px;" type="text" name="indexname" placeholder="Index Name">
                                        <input type="submit" class="col-xs-7 btn btn-primary btn-primary-override pull-right" value="DELETE INDEX">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_deleteindex')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_deleteindex'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/createtype">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input class="col-xs-4 input" style="line-height: 30px;" type="text" name="indexname" placeholder="Index Name">
                                        <input class="col-xs-4 input" style="line-height: 30px;" type="text" name="typename" placeholder="Type Name">
                                        <input type="submit" class="col-xs-4 btn btn-primary btn-primary-override pull-right" value="CREATE TYPE">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_createtype')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_createtype'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/deletetype">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input class="col-xs-4 input" style="line-height: 30px;" type="text" name="indexname" placeholder="Index Name">
                                        <input class="col-xs-4 input" style="line-height: 30px;" type="text" name="typename" placeholder="Type Name">
                                        <input type="submit" class="col-xs-4 btn btn-primary btn-primary-override pull-right" value="DELETE TYPE">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_deletetype')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_deletetype'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/createresourcetype">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input type="submit" class="btn btn-primary btn-primary-override form-control" value="CREATE RESOURCE TYPE IN DEFAULT INDEX (HARDCODED)">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_createresourcetype')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_createresourcetype'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/importresources">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input type="submit" class="btn btn-primary btn-primary-override form-control" value="IMPORT RESOURCES IN ELASTIC (HARDCODED)">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_importresources')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_importresources'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                            
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/createmoduletype">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input type="submit" class="btn btn-primary btn-primary-override form-control" value="CREATE MODULE TYPE IN DEFAULT INDEX (HARDCODED)">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_createmoduletype')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_createmoduletype'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/importmodules">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input type="submit" class="btn btn-primary btn-primary-override form-control" value="IMPORT MODULES IN ELASTIC (HARDCODED)">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_importmodules')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_importmodules'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                            
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/createlessontype">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input type="submit" class="btn btn-primary btn-primary-override form-control" value="CREATE LESSON TYPE IN DEFAULT INDEX (HARDCODED)">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_createlessontype')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_createlessontype'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/importlessons">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input type="submit" class="btn btn-primary btn-primary-override form-control" value="IMPORT LESSONS IN ELASTIC (HARDCODED)">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_importlessons')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_importlessons'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                            
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/createstudenttype">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input type="submit" class="btn btn-primary btn-primary-override form-control" value="CREATE STUDENT TYPE IN DEFAULT INDEX (HARDCODED)">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_createstudenttype')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_createstudenttype'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                            <form class="form-horizontal margin-top-20px" style="border-bottom: 1px dashed #34495e;" method="POST" action="elastic/importstudents">
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                                        <input type="submit" class="btn btn-primary btn-primary-override form-control" value="IMPORT STUDENTS IN ELASTIC (HARDCODED)">
                                    </div>
                                </div>
                                <?php if ($this->session->flashdata('es_importstudents')) { ?>
                                    <div class="col-xs-12 text-red text-center">
                                        STATUS: <?php echo $this->session->flashdata('es_importstudents'); ?>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>