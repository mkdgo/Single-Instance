function publishModal() {

$('#message').modal('hide');
          if($('.publish_btn').hasClass('active'))
{
    $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to unpublish the Curriculum');
}
else
    {
        $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to publish the Curriculum');
    }

$( $('#popupPubl').find('h4')[0] ).text('');
$('#popupPubl').modal('show');


    
}
  
         function doPubl()
         {
             $.post('/d3_teacher/saveajax', {"data": $( "#saveform" ).serializeArray() }, function(r, textStatus) {
         
        $('#publish').val(r);
        if( r ) {
            
            $('.publish_btn').addClass('active');
            $('.publish_btn span').text('PUBLISHED');
            
           
        } else {
            $('.publish_btn').removeClass('active');
            $('.publish_btn span').text('PUBLISH');
        }
         $('#popupPubl').modal('hide');
                                    $($($('#message').find("div")[0]).find("div")[0]).hide();
                                    if(r==1)
                                        {
                                    showFooterMessage({mess: 'Successfully Published', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
                                    }
                                    else
                                        {
                                          showFooterMessage({mess: 'Successfully Unpublished', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
                                     
                                        }
                                   
                           
                       
    }, "json");
         }
