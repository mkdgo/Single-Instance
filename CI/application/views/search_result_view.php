<div class="gray_top_field">
    <a href="{add}"  style="margin:0 30px 0 20px;" class="add_resource_butt black_button">ADD RESOURCE</a>
    <div class="clear"></div>
</div>
<div class="blue_gradient_bg">
            <br/><br/><br/>
            <div class="container">
            <div style="margin-bottom:20px;padding-right:20px;;" class="center gray_backg100">
                <span style="margin-left: 0;" class="lesson_title">Resource Library</span><br/>
                <div style="margin-left: 20px;;" class="resource_changer">Show: 
                    <a id="my_resources_button" class="lesson_link" onclick="change_res(1)" href="javascript:;">Only my resources</a>
                    <a id="all_resources_button" class="hidden lesson_link" onclick="change_res(2)" href="javascript:;">All resources</a>
                </div>
            </div>
                
                <div>
                    <div id="all_resources">
                        <div  class=" gray_backg100 center filtertitle">	
               			<span style="margin-left: 0;" class="lesson_title">All Resources</span><br /><br/>
                    	</div>
               				<ul  class="height_480px" data-icon="false" data-role="listview" data-filter="true" data-autodividers="true" data-inset="true">
                          	{resources}
								<li>
									<span style="margin-top:5px;font-size:20px;padding: 0 0 0  20px;" class="lesson_button"  >
									
                                                                        <a href="c2/index/resource/{resource_id}"><span class="hidden">{resource_name}</span><div class="yesdot">EDIT</div></a>
									{preview}
                                                                        
                                                                        </span>
								</li>
                          	{/resources}
                        	</ul>
                    </div>
                    
                    <div id="my_resources" class="hidden">
                        <div class="gray_backg100 center filtertitle hide_my_resources">
                        <span style="margin-left: 0;" class="lesson_title">My Resources</span><br/><br/>
                        </div>
                            <ul data-role="listview" data-autodividers="true" data-icon="false" data-filter="true" class="height_487px" data-inset="true">
							{my_resources}
								<li>
									<span style="margin-top:5px;font-size:20px;padding: 0 0 0  20px;" class=" lesson_button"  >
									<a href="c2/index/resource/{resource_id}"><span class="hidden">{resource_name}</span><div class="yesdot">EDIT</div></a>
									{preview}
                                                                        </span>
								</li>
                          	{/my_resources}
                            </ul>
                    </div>
                     
                </div>
            </div>
        </div>