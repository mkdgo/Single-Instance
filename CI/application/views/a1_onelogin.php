<!DOCTYPE html><html>    
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
    <meta charset="utf-8">        

    <link rel="apple-touch-icon" href="<?=base_url("/css/touch-icon-iphone.png")?>" /> 
    <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url("/css/touch-icon-ipad.png")?>" /> 
    <link rel="apple-touch-icon" sizes="120x120" href="<?=base_url("/css/touch-icon-iphone.png")?>" />
    <link rel="apple-touch-icon" sizes="152x152" href="<?=base_url("/css/touch-icon-ipad.png")?>" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>View lesson</title>				

    <meta name="viewport" content="width=device-width, initial-scale=1.0">        
    <!-- Bootstrap -->
    <link href="<?=base_url("/css/bootstrap.css")?>" rel="stylesheet" media="screen">        
    <link rel="stylesheet" href="<?=base_url("/css/jquery.mobile.structure-1.3.2.min.css")?>" type="text/css"/>        
    <!--<link rel="stylesheet" href="<?=base_url("/css/jquery.mobile.theme-1.3.2.min.css")?>" type="text/css"/>
    <!-- REMOVE IN FINAL VERSION, CONFLICTS WITH COLORBOX! -->        
    <link rel="stylesheet" href="<?=base_url("/css/newcss.css")?>" type="text/css"/>				
    <link rel="stylesheet" href="<?=base_url("/css/colorbox.css")?>" type="text/css"/>   		
    <link rel="stylesheet" href="<?=base_url("/css/style.css")?>" type="text/css"/>    

    <script src="<?=base_url("/js/jquery.js")?>"></script> 
    <script src="<?=base_url("/js/main.js")?>"></script>        
    <script src="<?=base_url("/js/js_visuals.js")?>"></script>

    <script type="text/javascript">	

        user_id = '{user_id}';					
        user_type = '{user_type}';
        profile_missing_data = "{profile_missing_data}";
        $(window).load(function(){
        });

        $(window).resize(function(){

        });	

        function setSizes() {
            var mt = parseFloat($(window).height())/2;
            var mt =mt - parseFloat($('#login_form_wrap').height() )/2;
            // console.log(mt+ ' '+($(window).height())
            $('#login_form_wrap').css('margin-top',mt+'px');
        }
    </script>				    
</head>
<body>

<div class="rred_gradient_bg" >
    <div  class="container">
        <div class="form-group">
            <div  class="col-lg-3 col-md-3 col-sm-3 hidden-xs"></div>
            <div style="" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                <div style="margin-top:100px;" class="align_center login_top_text">LOGIN WITH YOUR <span class="black">ONELOGIN ACCOUNT</span>
                    <div class="down_arrow_white">&nbsp;</div>
                </div>
                <div  class="log_submit">
                    <input type="button"  onClick="document.location='/a1/index/sso'" value="SIGN IN" />
                    <h4>{login_error}</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs"></div>
        </div>
    </div>
</div>