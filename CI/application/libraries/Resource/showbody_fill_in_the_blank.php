<div id="fill_in_the_blank" class="form-group-question resource_type" template="show">
    <div class="form-group-question row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="question-row-img">[IMG]</div>
        </div>
    </div>
    <div class="form-group-question row" style="[ISTEXT]">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="question-row"><label class="introtext">[TEXT]</label></div>
        </div>
    </div>
    <div class="form-group-question row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="question-row"><label class="question">[QUESTION]</label></div>
        </div>
    </div>
    <div class="form-group-question row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="question-row"><label style="line-height: 3;font-size: 19px !important;">[ANSWERS]</label></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function fillChart(res_id,jdata) {
        cols = jdata.cols;
        rows = jdata.rows;
        var daily_data = new google.visualization.DataTable();
        $.each(cols, function(i,col) {
            daily_data.addColumn(col.type, col.value);
        })
        $.each(rows, function(i,row) {
            daily_data.addRows([ row ]);
        });
        var daily_options = {
            pieHole: 0.5,
            pieSliceTextStyle: { color: 'black' },
            legend: 'none',
            chartArea: {width: '60%'},
	        width: '100%',
            height: 300,
            legend: 'none',
            hAxis: { 
                viewWindowMode : 'explicit',
                viewWindow: { min:0 }
            }
        };
        var multiple_chart = new google.visualization.PieChart(document.getElementById('chart_'+res_id));
        multiple_chart.draw(daily_data, daily_options);
    }
</script>
