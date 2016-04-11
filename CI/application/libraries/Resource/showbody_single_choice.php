<style type="text/css">
/*    .form-group { display: inline-block; float: left;}*/
</style>
<div id="single_choice" class="form-group grey resource_type no-margin" style="padding-top:21px;margin-left: 0; margin-right: 0;">
    <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; ">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="" style="text-align: center;">[IMG]</div>
        </div>
    </div>

    <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; margin-bottom: 30px;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="resource_link" class="scaled"></label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="" style="text-align: left;"><label for="resource_link" class="scaled">[TEXT]</label></div>
        </div>
    </div>

    <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; margin-bottom: 30px;">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="resource_link" class="scaled" style="float: right;">Q:</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="" style="text-align: left; margin-left: 20px;"><label for="resource_link" class="scaled">[QUESTION]</label></div>
        </div>
    </div>

    <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="resource_link" class="scaled" style="float: right;">A:</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="" style="text-align: left; margin-left: 20px;"><label for="resource_link" class="scaled">[ANSWERS]</label></div>
        </div>
    </div>

</div>
<script type="text/javascript">
    function nrpChart() {
        var nrp_data = google.visualization.arrayToDataTable([
            ['true', 'false', { role: 'annotation', color: '#000' } ],
            <?php echo  $this->nrp; ?>
        ]);
        
        var nrp_options = {
//            chart: {
                title: 'Single Options',
    //            curveType: 'function',
                legend: { position: 'right' },
//            },
//            isStacked: true,
            isStacked: 'percent',
        };
        var nc_chart = new google.visualization.ColumnChart(document.getElementById('nrp_chart'));
        nc_chart.draw(nrp_data, nrp_options);
    }

</script>
