var files=0;
var FL;
var file_label_holder = '<div style="width: 100%; float: left; clear: both;"><span class="fl_name" style="padding-top:5px; float: left;"></span><a style="display: none; float: right; margin-top: 5px;" class="remove" href=""><span class="glyphicon glyphicon-remove" ></span></a></div>';
function saveAssigment(action)
{
    if(validate()!=true)
        {
            return false;
        }
        else
            {
    if(action=='save')pv=0; else pv=1;
    $('#publish').val(pv);
  $('.hidden_submit').click();
   // document.getElementById('save_assignment').submit();
            }
}

function deleteFile(assignment_id, resource_id)
{
    
    $('#del_resource_id').val(resource_id);
    $('#del_assignment_id').val(assignment_id);
    
    document.getElementById('del_file').submit();
}

function addSubm()
{
    $('#userfile_'+files).trigger('click');
}

function init()
{
    FL = $('#userfile_0').clone();
    $('#userfile_0').after(file_label_holder);
    
    if(flashmessage_pastmark==1)
    {
        $( $('#popupMessage').find('p')[0] ).text('You are unable to attach a new file.  Your original submission has been marked.');
        $('#popupMessage').modal('show');
    }
}


function FLCH()
{
    FLTXT = $('#userfile_'+files).next();
    LBL = FLTXT.find('.fl_name');
    LBL.text( $('#userfile_'+files).prop('value') );
    FLTXT.css('border-bottom','solid 1px #ccc');
    FLTXT.css('height','40px');
    FLTXT.find('a').css('display', 'block');
    FLTXT.find('a').attr('href', 'javascript: delFlUpload('+files+');');
    
    
    NFL = FL.clone();
    files++;
    NFL.attr("id", "userfile_"+files);
    $("#filesubmissions").append(NFL);
    NFL.after(file_label_holder);
}


function delFlUpload(f)
{
    $('#userfile_'+f).next().remove();
    $('#userfile_'+f).remove();
   
}
$(document).ready(function() {
    init();
});
