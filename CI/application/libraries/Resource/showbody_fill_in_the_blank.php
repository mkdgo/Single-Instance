<style type="text/css">
/*    .form-group { display: inline-block; float: left;}*/
</style>
<div id="fill_in_the_blank" class="form-group grey resource_type no-margin" style="padding-top:21px;margin-left: 0; margin-right: 0;">
    <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; ">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="" style="text-align: center;">[IMG]</div>
        </div>
    </div>

    <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; margin-bottom: 30px;">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <label for="" class="scaled"></label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="" style="text-align: left;"><label for="resource_link" class="scaled">[TEXT]</label></div>
        </div>
    </div>

    <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0; margin-bottom: 30px;">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="" class="scaled" style="float: right;">Q:</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="" style="text-align: left; margin-left: 20px;"><label for="resource_link" class="scaled">[QUESTION]</label></div>
        </div>
    </div>

    <div class="form-group grey no-margin row" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <label for="" class="scaled" style="float: right;">A:</label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <div class="" style="text-align: left; margin-left: 20px;"><label for="resource_link" class="scaled" style="line-height: 2.5;">[ANSWERS]</label></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function fillChart(res_id,jdata) {

        cols = jdata.cols;
        rows = jdata.rows;
        var daily_data = new google.visualization.DataTable();

console.log( cols );
console.log( rows );
        $.each(cols, function(i,col) {
            daily_data.addColumn(col.type, col.value);
        })
        $.each(rows, function(i,row) {
            daily_data.addRows([ row ]);
        });
        var daily_options = {
            title: 'Today',
            legend: { position: 'bottom' },
            bars: 'horizontal'
        };
        var multiple_chart = new google.visualization.BarChart(document.getElementById('chart_'+res_id));
        multiple_chart.draw(daily_data, daily_options);
    }


</script>
