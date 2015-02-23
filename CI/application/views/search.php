<div class="gray_top_field">
    <a href="/c2"  style="margin:0 30px 0 20px;" class="add_resource_butt black_button">ADD RESOURCE</a>
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
                <div class=" gray_backg100 center filtertitle">	
                    <span style="margin-left: 0;" class="lesson_title">All Resources</span><br /><br/>
            	</div>
                <form id="form_search_ajax" action="javascript:void(0);">
                    <input type="search" id="query_value_ajax" name='query' placeholder="Search..." value="{query}"/>
                </form>
   				<div class='returned_results'>{results}</div>
            </div>
        </div>
	</div>
</div>

<script>
    $("#form_search_ajax").keyup(function(event){
        if(event.keyCode == 13){
            console.log('query ajax', $('#query_value_ajax').val());
            // event.preventDefault();
            $.ajax({
                type: "POST",
                url: "/search/formquery",
                data: { query: $('#query_value_ajax').val() }
            })
            .done(function( msg ) {
                $(".returned_results").html( msg );
                $("ul").listview();
            });
        }
    });
</script>