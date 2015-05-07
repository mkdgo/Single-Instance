$(document).ready(function() {

    $('.add_task').on('click',function () {

        $('.hotspot_message').val('')

        $('#popupPubl').modal('show');
    })


    $('#popupPublBTN').on('click',function () {

        var str = $('.hotspot_message').val();
        var data = {str:str}
        $.ajax({
            type: "POST",
            url: "/widgets/fill_in_the_gaps/save",
            data: data,
            dataType:"json",
            success: function (data) {
                if (data.status == 'true') {
                    $('.preview p').append('<br />'+data.html);
                    //$('<button type="button" class="btn btn-default check_results">Check</button>').appendTo('.preview');
                    $('.check_results').fadeIn('400');
                    $('#popupPubl').modal('hide');
                    $('.reset_tasks').fadeIn(300);
                    $('.data_tasks').append('<br /> '+str);
                    $('.hotspot_message').val('');
                }
            }
        })

       // $('#popupPubl').modal('show');
    })


    $('.save_data').on('click',function () {
        var img = $('.back_pic').val();
        var title = $('#content_title').val();
        var text = $('#content_text').val();
        var cont_page = $('.cont_page').val();
        var data_info = $('.data_tasks').html();
        var data = {img:img,title:title,text:text,cont_page:cont_page,data_info:data_info}
        $.ajax({
            type: "POST",
            url: "/widgets/fill_in_the_gaps/save_data",
            data: data,
            dataType:"json",
            success: function (data) {
              window.location.reload();

            }
        })
    })

    $('.check_results').on('click',function(){
            var error = 0;
         $('.preview').find('.custom_input').each(function(){

             if($(this).val()!==decode($(this).attr('rel')))
             {
                 $(this).addClass('wrong');
                 error = error+1


             }
             else
             {
                 $(this).addClass('correct');


             }


             $(this).attr('disabled','disabled');

        })
        $('.check_results').fadeOut(100);
        if(error>0)
        {
            $('.show_solutions').fadeIn(100);
        }


    })

    $('.show_solutions').on('click',function() {
        $('.green').remove();
        $('.preview').find('.custom_input').each(function () {

            if($(this).val()!==decode($(this).attr('rel')))
            {
                var answer = decode($(this).attr('rel'));

              $('<span class="green">'+answer+'</span>').insertAfter($(this));
            }




        })
        $(this).fadeOut(200);
    })
    $('.reset_tasks').on('click',function() {
        $('.preview p').html('');
        $('.data_tasks').html('');
        $('.try_again').fadeOut(300);


    })




    binTable = [
        -1,-1,-1,-1, -1,-1,-1,-1, -1,-1,-1,-1, -1,-1,-1,-1,
        -1,-1,-1,-1, -1,-1,-1,-1, -1,-1,-1,-1, -1,-1,-1,-1,
        -1,-1,-1,-1, -1,-1,-1,-1, -1,-1,-1,62, -1,-1,-1,63,
        52,53,54,55, 56,57,58,59, 60,61,-1,-1, -1, 0,-1,-1,
        -1, 0, 1, 2,  3, 4, 5, 6,  7, 8, 9,10, 11,12,13,14,
        15,16,17,18, 19,20,21,22, 23,24,25,-1, -1,-1,-1,-1,
        -1,26,27,28, 29,30,31,32, 33,34,35,36, 37,38,39,40,
        41,42,43,44, 45,46,47,48, 49,50,51,-1, -1,-1,-1,-1
    ];
    padding = '=';
        chrTable = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' +
        '0123456789+/';

    function utf8Decode(bytes) {
        var chars = [], offset = 0, length = bytes.length, c, c2, c3;

        while (offset < length) {
            c = bytes[offset];
            c2 = bytes[offset + 1];
            c3 = bytes[offset + 2];

            if (128 > c) {
                chars.push(String.fromCharCode(c));
                offset += 1;
            } else if (191 < c && c < 224) {
                chars.push(String.fromCharCode(((c & 31) << 6) | (c2 & 63)));
                offset += 2;
            } else {
                chars.push(String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63)));
                offset += 3;
            }
        }

        return chars.join('');
    }
    function decode(data) {
        var value, code, idx = 0,
            bytes = [],
            leftbits = 0, // number of bits decoded, but yet to be appended
            leftdata = 0; // bits decoded, but yet to be appended

        // Convert one by one.
        for (idx = 0; idx < data.length; idx++) {
            code = data.charCodeAt(idx);
            value = binTable[code & 0x7F];

            if (-1 === value) {
                // Skip illegal characters and whitespace
                log("WARN: Illegal characters (code=" + code + ") in position " + idx);
            } else {
                // Collect data into leftdata, update bitcount
                leftdata = (leftdata << 6) | value;
                leftbits += 6;

                // If we have 8 or more bits, append 8 bits to the result
                if (leftbits >= 8) {
                    leftbits -= 8;
                    // Append if not padding.
                    if (padding !== data.charAt(idx)) {
                        bytes.push((leftdata >> leftbits) & 0xFF);
                    }
                    leftdata &= (1 << leftbits) - 1;
                }
            }
        }

        // If there are any bits left, the base64 string was corrupted
        if (leftbits) {
            log("ERROR: Corrupted base64 string");
            return null;
        }

        return utf8Decode(bytes);
    }

})
