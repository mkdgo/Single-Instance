<div id="multiple_choice" class="form-group-question resource_type" template="show">
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
    function multipleChart(res_id,jdata) {
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
                viewWindowMode: 'explicit',
                viewWindow: { min:0 }
            }
        };
        var multiple_chart = new google.visualization.BarChart(document.getElementById('chart_'+res_id));
        multiple_chart.draw(daily_data, daily_options);
    }

    function setCheck( el, c ) {
console.log( c );
//console.log( el );

/*
if ($(this).is(':checked'))
console.log( $(this).val() );
   else
alert(el);*/




//        var allowed = parseInt($('#qm'+c+'_c').attr('rel'));
//        var marked = parseInt($('#qm'+c+'_c').attr('num'));
//console.log( el );
//console.log( c );
/*
if( marked >= allowed ) {
               $('.modal-body').html('').append('<div class="alert-error" style=" margin: 10px 20px; line-height: 1.5;">You have made the maximum number of selections. Please deselect one of the checkboxes to make another selection.</div>');
               $('#popupError').modal('show');
               $('#'+el).attr('checked', false);
                return false;
            } else {
                
            }
//*/
//        $('#'+w).val( $('#'+w).attr('rel') );
/*
        if( el.attr('checked') == false ) {
            if( marked >= allowed ) {
               $('.modal-body').html('').append('<div class="alert-error" style=" margin: 10px 20px; line-height: 1.5;">You have made the maximum number of selections. Please deselect one of the checkboxes to make another selection.</div>');
               $('#popupError').modal('show');
                return false;
            }
            el.attr('checked', true);
//            el.css('background', '#53EEEB');
            marked = marked + 1;
            $('#q'+c+'_c').attr('num',marked);
        } else {
            el.attr('checked', false);
//            el.css('background', '#f5f5f5');
            marked = marked - 1;
            $('#qm'+c+'_c').attr('num',marked);
        }
//*/
    }
</script>
