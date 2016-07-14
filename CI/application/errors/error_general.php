<?php
    $c1 = strlen( "/c1/resource/" );
    $s1 = strlen( "/c1/results/" );
    $c1_r = substr( $_SERVER["REDIRECT_QUERY_STRING"], 0, $c1 );
    $s1_r = substr( $_SERVER["REDIRECT_QUERY_STRING"], 0, $s1 );
    if( $c1_r == "/c1/resource/" ) {
        $msg = "We are sorry, but this resource cannot be retrieved. <br />Please click on the speech bubble on the menu bar to pass this issue on the our support team.";
    } elseif( $s1_r == "/s1/results/" ) {
        $msg = "We are sorry, but we are unable to find a record for your search. Please try again removing any ', \", &, ? characters. Thanks";
    } else {
        $msg = "An error has occurred. Please click on the speech bubble on the menu bar to pass this issue on the our support team.";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>EDIFACE - KRYSTAL - LOCAL</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/res/css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="/res/css/newcss.css" type="text/css"/>
        <link rel="stylesheet" href="/res/css/style.css" type="text/css"/>
    </head>
    <body>
        <header data-role="header" data-position="inline" id="staticheader">
            <div class="container">
                <div class="left">
                    <a onclick="window.history.back()" href="javascript:;" id="backbutton"><span class="glyphicon glyphicon-chevron-left"></span></a>
                    <a href="/" class="home"><span class="glyphicon glyphicon-home"></span></a>   
                    <form id="formsearch" action="javascript:void(0)" enctype="multipart/form-data" method="post">
                        <a href="#" class="search"><span class="glyphicon glyphicon-search"></span></a>
                        <div id="search-label"><label for="search-terms" id='search-label-target'>search</label></div>
                        <div class='span2' id="input"><input type="text" data-type="search" name="search-terms" id="search-terms" placeholder="Enter search..."></div>
                    </form>
                </div>
                <div class="right">
                    <a href="#" data-toggle="modal" data-target="#feedbackModal"><span class="glyphicon glyphicon-comment"></span></a>
                </div>
                <div class="logo">
                    <a href="/" ><img src="/img/logo_top.png" /></a>
                </div>
            </div>
        </header>

        <div id="feedbackModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header2">
                        <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                    <div class="feedback-modal-header">
                        <h4 class="modal-title">Ediface Feedback</h4>
                    </div>
                    <div class="feedback-modal-body">
                        <h5 class="no-error">Feedback Details</h5>
                        <h5 class="feedback-error text-error">Please provide feedback details.</h5>
                        <h5 class="ajax-error text-error">An error occurred while trying to submit your feedback.</h5>
                        <textarea id="feedback_details" placeholder="Please enter details about what you would like to see, what issues you encountered or any other suggesstions or feedback you may have..."></textarea>
                    </div>
                    <div class="feedback-modal-footer feedback-buttons">
                        <button type="button" class="btn red_btn" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn green_btn" id="submit_feedback">Submit</button>
                    </div>
                    <div class="feedback-modal-footer feedback-pending" style="display: none; padding-right: 10px;">
                        <h5 style="text-align: right;">Submitting your feedback, please wait...</h5>
                    </div>
                    <div class="feedback-modal-footer feedback-confirmation" style="display: none;">
                        <h5>Thank you. Your feedback has been submitted.</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="blue_gradient_bg">
            <div class="container" style="border:1px solid #990000;">
                <h1><?php echo $heading; ?></h1>
                <p><?php echo $msg; ?></p>
<!--                <p>An error has occurred. Please try to repeat the action or contact support.</p>-->
<!--                <p><?php echo $message; ?></p>-->
            </div>
        </div>

        <footer>
            <div class="container clearfix">
                <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
                <div class="right"></div>
            </div>
        </footer>

        <div id="dialog" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000; opacity:0.75; background-color: #000000; display: none; text-align: center; color: white; padding: 30% 10% 30% 10%; font-weight: normal; text-shadow:none; font-size: 30px; vertical-align: middle;">
            <h1 id="dialog_title"></h1>
        </div>

        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/error.js"></script>
        <script src="/js/classie.js"></script>
        <script src="/js/search.js"></script>
        <script>
            $("#formsearch").keyup(function(event){
                if(event.keyCode == 13){
                    window.location.href = ('/s1/results/' + $('#search-terms').val());
                }
            });
            
            $(document).ready(function() {
                $('#feedbackModal').on('show.bs.modal', function (e) {
                    $('.feedback-modal-body .no-error').hide();
                    $('.feedback-modal-body .ajax-error').hide();
                    $('.feedback-modal-body .feedback-error').hide();
                    $('.feedback-confirmation').hide();
                    $('.feedback-pending').hide();
                   
                    $('.feedback-buttons').show();
                });

                $('#feedback_details').keyup(function() {
                    var feedback = $('#feedback_details').val();
                    if ($.trim(feedback) === '') {
                        $('.feedback-modal-body .no-error').hide();
                        $('.feedback-modal-body .ajax-error').hide();
                        $('.feedback-modal-body .feedback-error').show();
                    } else {
                        $('.feedback-modal-body .feedback-error').hide();
                        $('.feedback-modal-body .ajax-error').hide();
                        $('.feedback-modal-body .no-error').show();
                    }
                });
            });

            $('#submit_feedback').click(function() {
                var breadcrumbs = '';
                var feedback = $('#feedback_details').val();
                
                if ($.trim(feedback) === '') {
                    $('.feedback-modal-body .no-error').hide();
                    $('.feedback-modal-body .ajax-error').hide();
                    $('.feedback-modal-body .feedback-error').show();
                    return;
                } else {
                    $('.feedback-modal-body .feedback-error').hide();
                    $('.feedback-modal-body .ajax-error').hide();
                    $('.feedback-modal-body .no-error').show();
                }
                
                $('ul.breadcrumb li').each(function(){
                    if (breadcrumbs !== '') {
                        breadcrumbs = breadcrumbs + ' > ';
                    }
                    breadcrumbs = breadcrumbs + $(this).text();
                });
                
                if (breadcrumbs === '') {
                    breadcrumbs = 'Home';
                }
                
                $('.feedback-buttons').hide();
                $('.feedback-pending').show();
                                
                $.ajax({
                    'url': '/ajax/feedback/save_feedback',
                    'type': 'POST',
                    'dataType': 'json',
                    'data': 'feedback=' + encodeURIComponent(feedback) + '&path=' + encodeURIComponent(breadcrumbs) + '&location=' + encodeURI(document.URL)
                }).done(function(data) {
                    if (data.status) {
                        $('.feedback-pending').hide();
                        $('.feedback-confirmation').show();
                        setTimeout(function() {
                            $('#feedback_details').val('');
                            $('#feedbackModal').modal('hide');
                        }, 3000);
                    } else {
                        $('.feedback-modal-body .feedback-error').hide();
                        $('.feedback-modal-body .no-error').hide();
                        $('.feedback-modal-body .ajax-error').show();
                    }
                }).fail(function() {
                    $('.feedback-modal-body .feedback-error').hide();
                    $('.feedback-modal-body .no-error').hide();
                    $('.feedback-modal-body .ajax-error').show();
                });
            });
        </script>

    </body>
</html>
