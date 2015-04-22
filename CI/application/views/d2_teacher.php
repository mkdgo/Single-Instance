<link rel="stylesheet" href="<?=base_url("/css/d2_teacher.css")?>" type="text/css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://raw.githubusercontent.com/furf/jquery-ui-touch-punch/master/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="<?=base_url("/js/jquery.mjs.nestedSortable.js")?>"></script>
<script type="text/javascript" src="<?=base_url("/js/d2_teacher.js")?>"></script>

<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <h2>{subject_title}</h2>
        <div class="{hide_modules}"> 
            <ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded menu">
                {modules}
                <li style="display: list-item;" class="root_level mjs-nestedSortable-branch mjs-nestedSortable-expanded" idn="{module_id}">
                    <div class="menuDiv">
                        <table style="margin-bottom:0px; margin-top:20px;" class="table2">
                            <thead>
                                <tr>
                                    <td style="width: 100%;float:left;height:72px;position:relative;cursor: default;">
                                        <div class="drag" style="width: 50px;height:70px;margin-top: -20px;padding-top:20px;margin-bottom:20px;text-align:center; margin-left:-14px;position:absolute;float: left">

                                        <i style="margin-right:10px;cursor: move;" class="icon-move"><img  src="/img/icon-arrows.png"></i>
                                        </div>
                                            <a href="/d4_teacher/index/{subject_id}/{module_id}" style="padding-left: 35px;">{module_name}</a>

                                    </td>
                                    <td style="width: 35%;cursor: default;" class="ta-c" colspan="2" style="padding-right: 60px;">Slides Available?</td>
                                    <td style="width: 40px;cursor: default;"><a class="remove" href="javascript: delRequest('/d2_teacher/deleteModule/{subject_id}/{module_id}', 1,'{module_name}');"><span class="glyphicon glyphicon-remove"></span></a></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <ol>
                        {lessons}
                        <li  style="display: list-item;" class="mjs-nestedSortable-leaf sub_level" idn="{lesson_id}">  
                            <div class="menuDiv">
                                <table style="margin-bottom:0px;" class="table2">
                                    <tbody>
                                        <tr>
                                            <td class="first" style="cursor: default;position: relative;">
                                                <div class="drag" style="width: 50px;height:70px;margin-top: -20px;padding-top:22px;margin-bottom:20px;text-align:center; margin-left:-20px;position:absolute;float: left">
                                                <i style="cursor: move;" ><img src="/img/icon-arrows.png"></i>
                                                </div>
                                                    <a href="/d5_teacher/index/{subject_id}/{module_id}/{lesson_id}">
                                                   <span style="font-style: normal;margin-left: 35px;">Lesson : {lesson_title}</span>
                                                </a>
                                            </td>
                                            <td class="ta-c" style="width: 35%;cursor: default">{lesson_interactive}</td>
                                            <td style="width:40px;backgroundx: black;cursor: default; padding-right: 20px; padding-left: 20px;"><a class="remove" href="javascript: delRequest('/d2_teacher/deleteLesson/{subject_id}/{lesson_id}', 2,'{lesson_title}');"><span class="glyphicon glyphicon-remove"></span></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </li>  
                        {/lessons}
                    </ol>
                    <div class="buttons clearfix">
                        <a class="btn b1 right" href="/d5_teacher/index/{subject_id}/{module_id}">ADD NEW LESSON<span class="icon i3"></span></a>
                    </div>
                    {/modules}
                </li>
            </ol>
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="/d4_teacher/index/{subject_id}" class="red_btn">ADD MODULE</a>
            <a href="/d3_teacher/index/{subject_id}/{year_id}" class="red_btn">VIEW Year {year_id} {subject_title} CURRICULUM</a>
        </div>
    </div>
</footer>

<div id="popupDel" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                 <p></p>
            </div>
            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupDelBT" do="1" type="button" onClick="doDel()" delrel=""  class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
