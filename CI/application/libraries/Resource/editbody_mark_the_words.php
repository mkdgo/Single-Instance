<div id="mark_the_words" class="form-group-question resource_type" template="edit">
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
            <div class="question-row"><label class="answer-label" style="background-color: #f5f5f5;border-radius: 5px;color:black;display:block;padding: 30px 0;">[ANSWERS]</label></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function setAnswer(el, w, c) {
        var allowed = parseInt($('#q'+c+'_c').attr('rel'));
        var marked = parseInt($('#q'+c+'_c').attr('num'));
        if( el.attr('rel') == 0 ) {
            if( marked >= allowed ) {
               $('.modal-body').html('').append('<div class="alert-error" style=" margin: 10px 20px; line-height: 1.5;">You have made the maximum number of selections. Please deselect one of the words to make another selection.</div>');
               $('#popupError').modal('show');
                return false;
            }
            el.attr('rel', 1);
            el.css('background', '#53EEEB');
            $('#'+w).val( $('#'+w).attr('rel') );
            marked = marked + 1;
            $('#q'+c+'_c').attr('num',marked);
        } else {
            el.attr('rel', 0);
            el.css('background', '#f5f5f5');
            $('#'+w).val('');
            marked = marked - 1;
            $('#q'+c+'_c').attr('num',marked);
        }
    }
</script>
