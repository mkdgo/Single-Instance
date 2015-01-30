<link rel="stylesheet" href="<?=base_url("/css/d2_teacher.css")?>" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script src="<?=base_url("/js/jquery.mjs.nestedSortable.js")?>"></script>
<script src="<?=base_url("/js/d2_teacher.js")?>"></script>
<style>
    .placeholder {
			outline: 1px dashed #4183C4;
                        background-color: #d0d0d3;
		}
		
		.mjs-nestedSortable-error {
			background: #fbe3e4;
			border-color: transparent;
		}
		
		#tree {
			width: 100%;
			margin: 0;
		}
		
		ol {
			max-width: 100%;
			padding-left: 0px;
		}
		
		ol.sortable,ol.sortable ol {
			list-style-type: none;
		}
		
		.sortable li div {
			
			cursor: move;
			
		}
		
		li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
			border-color: #999;
		}
		
		.disclose, .expandEditor {
			cursor: pointer;
			width: 20px;
			display: none;
		}
		
		.sortable li.mjs-nestedSortable-collapsed > ol {
			display: none;
		}
		
		.sortable li.mjs-nestedSortable-branch > div > .disclose {
			display: inline-block;
		}
		
		.sortable span.ui-icon {
			display: inline-block;
			margin: 0;
			padding: 0;
		}
		
		.menuDiv {
			background: none;
                        width: 100%;
		}
		
		.menuEdit {
			background: #FFF;
		}
		
		.itemTitle {
			vertical-align: middle;
			cursor: pointer;
		}
		
		.deleteMenu {
			float: right;
			cursor: pointer;
		}
		
</style>
<!--<div data-role="header" data-position="inline">
<a href="/d1" data-icon="arrow-l">back</a>
<div class="header_search hidden-xs">
<input type="search" id="search" style="" value=""/>
</div>
<h1>view curriculum</h1>
</div>-->
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
                                <td style="width: 65%;">
                                    <i style="margin-right:10px;" class="icon-move"><img class="disable_dd" src="/img/icon-arrows.png"></i>
                                    <a href="/d4_teacher/index/{subject_id}/{module_id}">{module_name}</a>
                                </td>
                                <td style="width: 35%;" class="ta-c" colspan="2" style="padding-right: 60px;">Slides Available?</td>
                                <td style="width: 40px;"><a class="remove" href="javascript: delRequest('/d2_teacher/deleteModule/{subject_id}/{module_id}', 1,'{module_name}');"><span class="glyphicon glyphicon-remove"></span></a></td>
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
                                        <td>
                                            <i style="margin-right:10px; padding-top: 3px;" class="icon-move"><img class="disable_dd" src="/img/icon-arrows.png"></i>
                                            <a href="/d5_teacher/index/{subject_id}/{module_id}/{lesson_id}">
                                                 <span style="font-style: normal;">Lesson : {lesson_title}</span>
                                                
                                            </a>
                                        </td>
                                        <td class="ta-c" style="width: 32%;">{lesson_interactive}</td>
                                        <td style="width:30px;backgroundx: black; padding-right: 20px; padding-left: 20px;"><a class="remove" href="javascript: delRequest('/d2_teacher/deleteLesson/{subject_id}/{lesson_id}', 2,'{lesson_title}');"><span class="glyphicon glyphicon-remove"></span></a></td>

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
<footer>
    <div class="container clearfix">
        <div class="left unvisible">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="/d4_teacher/index/{subject_id}" class="red_btn">ADD MODULE</a>
            <a href="/d3_teacher/index/{subject_id}" class="red_btn">VIEW {subject_title} CURRICULUM</a>
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