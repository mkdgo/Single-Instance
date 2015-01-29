<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />



        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.js"></script>

        <link rel="stylesheet" href="/js/bootstrap/css/bootstrap.css" type="text/css" />



        <link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed&subset=latin,cyrillic' rel='stylesheet' type='text/css'>



            <script type="text/javascript" src="/js/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>

            <link rel="stylesheet" href="/js/jquery-ui-1.9.2.custom/css/blitzer/jquery-ui-1.9.2.custom.css" type="text/css" />



            <link rel="stylesheet" type="text/css" media="all" href="/css/style.css" charset="utf-8" />





            <title></title>





    </head>







    <script type="text/javascript">

<!--



        $(function() {



            $('.action_tooltip').tooltip();



            $('.thumb_label').click(function() {

                if ($('a', $(this)).attr('id') != '') {

                    $('#replace_pic_id').val($('a', $(this)).attr('id').replace('pic_', ''));

                }

            });



            if ($.browser.mozilla) {

                $('.thumb_label').click(function() {

                    $('#file').click();

                });

            }



            $('#file').change(function() {

                $('#upload').submit();

            });



       /*     var content_width = 0;

            var content_height = $('div#test').outerHeight(true);



            $('ul.pictures_list li').each(function() {

                content_width += $(this).outerWidth(true);

            });





            console.log($('div#test').outerHeight(true));

            //  console.log($('ul.pictures_list li').outerWidth(true));

            window.parent.$('iframe.pic_iframe').css({

                height: content_height + 'px',

                width: content_width + 'px'

            }); */

        });

        //-->

    </script>



    <body class="ajax_pictures">

        <ul class="pictures_list">

            {pictures}

            <li>

                <span class="{overlay_class}">

                    <a title="Main" class="action_tooltip" id="{id}" href="/tech/pictures/main/{object_id}/{id}/{object_type}/{num_pics}">

                        <i class="icon icon-ok"></i>

                    </a>

                    &nbsp;

                    <a title="Delete" class="action_tooltip" href="/tech/pictures/delete/{object_id}/{id}/{object_type}/">

                        <i class="icon icon-remove"></i>

                    </a>

                </span>



                <label class="thumb_label" for="file">

                    <a title="Upload img" id="{pic_id}" class="thumb" href="#">

                        <img class="{main_picture}" src="{src}" />

                    </a>

                </label>

            </li>



            {/pictures}

        </ul>

        <div class="clear">&nbsp;</div>

        <form name="upload" id="upload"  method="post" enctype="multipart/form-data" action="/tech/pictures/upload/{object_id}/{object_type}/{num_pics}">

            <input name="path" id="file" type="file" />

            <input type="hidden" name="object_id" value="{object_id}" />

            <input type="hidden" name="object_type" value="{object_type}" />

            <input type="hidden" name="num_pics" value="{num_pics}" />

            <input type="hidden" name="pic_type" value="{pic_type}" />

            <input type="hidden" name="replace_pic_id" id="replace_pic_id" />

        </form>

    </body>

</html>























