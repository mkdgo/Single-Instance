<style type="text/css">
/*    .form-group { display: inline-block; float: left;}*/
</style>
<div id="mark_the_words" class="form-group form-group-question resource_type no-margin" style="padding-top:21px;margin-left: 0; margin-right: 0;">
    <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; ">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="" style="text-align: center;">[IMG]</div>
        </div>
    </div>

    <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; margin-bottom: 30px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="introtext" style="text-align: center;"><label for="resource_link" class="scaled">[TEXT]</label></div>
        </div>
    </div>

    <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0; margin-bottom: 30px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="question" style="text-align: center;"><label for="resource_link" class="scaled question">[QUESTION]</label></div>
        </div>
    </div>

    <div class="form-group form-group-question no-margin row" style="margin-left: 0; margin-right: 0;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="" style="text-align: center;"><label for="resource_link" class="scaled" style="line-height: 3;">[ANSWERS]</label></div>
        </div>
    </div>

</div>
<script type="text/javascript">
    function setAnswer(el, w, c) {
        var allowed = parseInt($('#q'+c+'_c').attr('rel'));
        var marked = parseInt($('#q'+c+'_c').attr('num'));
        $('#'+w).val( $('#'+w).attr('rel') );
        if( el.attr('rel') == 0 ) {
        if( marked >= allowed ) {
           $('.modal-body').html('').append('<div class="alert-error" style=" margin: 10px 20px; line-height: 1.5;">You have made the maximum number of selections. Please deselect one of the words to make another selection.</div>');
//           $('.modal-body').html('<p style="display: inline-block; line-height: 1.5; margin: 20px; background: #fff; text-align: left; padding: 20px;">You have made the maximum number of selections. Please deselect one of the words to make another selection.</p>');
           $('#popupError').modal('show');
            return false;
        }
            el.attr('rel', 1);
            el.css('background', '#ff0');
            marked = marked + 1;
            $('#q'+c+'_c').attr('num',marked);
        } else {
            el.attr('rel', 0);
            el.css('background', '#f5f5f5');
            marked = marked - 1;
            $('#q'+c+'_c').attr('num',marked);
        }
    }

    function markChart(res_id,jdata) {

        cols = jdata.cols;
        rows = jdata.rows;
        var daily_data = new google.visualization.DataTable();

//console.log( cols );
//console.log( rows );
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
