<div id="single_choice" class="form-group-question resource_type" template="show">
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
            <div class="question-row"><label style="line-height: 3;/*margin: 50px;*/">[ANSWERS]</label></div>
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
        var daily_options = {
            chartArea: {width: '60%'},
	        width: '100%',
            height: 300,
            legend: 'none',
            bar: {groupWidth: '95%'},
            hAxis: { 
                viewWindowMode:'explicit',
                viewWindow: { min:0 }
            }
        };
        var single_chart = new google.visualization.BarChart(document.getElementById('chart_'+res_id));
        single_chart.draw(daily_data, daily_options);
    }
</script>
