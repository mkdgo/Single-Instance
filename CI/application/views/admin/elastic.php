<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h2>ElasticSearch Query Tool</h2>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="active">ElasticSearch :: Query Tool</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Enter search query</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="portlet-body">
                            <form class="form-horizontal" id="elasticSearchForm" name="elasticSearchForm" method="POST">
                                <div class="form-group">
                                    <label for="search" class="col-xs-12 col-sm-2 control-label">Your query:</label>
                                    <div class="col-xs-12 col-sm-10">
                                        <div class="radio">
                                            <label>
                                                <textarea id="search" name="search" cols="100" rows="15" style="border: 1px solid black;"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 control-label">&nbsp;</label>
                                    <div class="col-xs-12 col-sm-2 col-sm-offset-6">
                                        <input type="submit" class="btn btn-primary btn-primary-override form-control" id="save" name="save" value="Test Query">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"><strong>Your query:</strong></div>
            <div class="col-lg-12">
                <pre>{query}</pre>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12"><strong>Your result(RAW):</strong></div>
            <div class="col-lg-12"><strong><pre>{rawResult}</pre></strong></div>
            <div class="col-lg-12"><strong>Your result:</strong></div>
            <div class="col-lg-12">
                Total Results: {totalResults} <br />
                Max Score: {maxScore} <br /><br />
                Results: <br />
                <?php if (isset($results)) { ?>
                    <?php foreach($results as $result){ ?>
                    <pre><?php print_r($result); ?></pre>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>