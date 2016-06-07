<div id="multiple_choice" class="form-group-question resource_type" template="edit">
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
    <div class="form-group-question no-margin row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="question-row"><label>[ANSWERS]</label></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function setAnswer(el, w, c) {
        var allowed = parseInt($('#qm'+c+'_c').attr('rel'));
        var marked = parseInt($('#qm'+c+'_c').attr('num'));
console.log( $(w) )

//        $('#'+w).val( $('#'+w).attr('rel') );
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
    }
</script>