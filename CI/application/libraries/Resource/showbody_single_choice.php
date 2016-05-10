<style type="text/css">
/*    .form-group { display: inline-block; float: left;}*/
</style>
<div id="single_choice" class="form-group form-group-question resource_type no-margin" style="padding-top:21px;margin-left: 0; margin-right: 0;">
    <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; ">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="" style="text-align: center;">[IMG]</div>
        </div>
    </div>

    <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="introtext" style="text-align: center;"><label for="resource_link" class="scaled">[TEXT]</label></div>
        </div>
    </div>

    <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="question" style="text-align: center;"><label for="resource_link" class="scaled question">[QUESTION]</label></div>
        </div>
    </div>

    <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="" style="text-align: center;"><label for="resource_link" class="scaled">[ANSWERS]</label></div>
        </div>
    </div>

</div>
<script type="text/javascript">
    function singleChart(res_id,jdata) {

        cols = jdata.cols;
        rows = jdata.rows;
        var daily_data = new google.visualization.DataTable();

        $.each(cols, function(i,col) {
            daily_data.addColumn(col.type, col.value);
        })

        $.each(rows, function(i,row) {
            daily_data.addRows([ row ]);
        });
        /*
        var daily_options = {
            title: 'Today',
            legend: { position: 'bottom' },
            bars: 'horizontal'
        };*/
        var daily_options = {
            chartArea: {width: '60%'},
	    width: '100%',
            height: 300,
            legend: 'none',
            bar: {groupWidth: '95%'},
            yAxis: {
     		title: 'none'
            },
            vAxis: { 
              viewWindowMode:'explicit',
              viewWindow:{
                min:0
              }
            }
        };
        var single_chart = new google.visualization.BarChart(document.getElementById('chart_'+res_id));
        single_chart.draw(daily_data, daily_options);
    }

</script>
