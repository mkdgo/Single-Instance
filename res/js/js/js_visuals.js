$(document).ready(function(){
    $('.not_so_cool_input').focus(function(){
        $(this).css('border','2px solid #cb9897')
    })  
    $('.not_so_cool_input').blur(function(){
        $(this).css('border','2px solid #ccc')
    })  
    $('.not_so_cool_textarea').focus(function(){
        $(this).css('border','2px solid #cb9897')
    })  
    $('.not_so_cool_textarea').blur(function(){
        $(this).css('border','2px solid #ccc')
    })  
    
    
})