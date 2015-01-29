<h3>Results</h3>
{if resources}
	<table class='table3'>
		<th>Type</th>
		<th>Name</th>
		<th>Preview</th>
		<th>User</th>
		<!-- <th>Score</th> -->
		<?php if ($user_type == 'teacher'): ?>
			<?php if ($save_resource): ?><th>Add</th><?php endif; ?>
			<th>Delete</th>
		<th>Edit</th><?php endif; ?>
			{resources}
		    <tr>
		    <td class="resource_cell resource_icon"><span class="icon {type}"></span></span></td>
		    <td class="resource_cell name-resource">{title}</td>
		    <td class='resource_cell preview-resource'>{preview}</td>
		    <td class="resource_cell name-resource">{user}</td>
		        
		        <!-- <td class="resource_cell name-resource">{score}</td> http://ediface.dev/c1/save/232/lesson/175/1/68-->
		        <?php if ($user_type == 'teacher'): ?>
		        	<?php if ($save_resource): ?><td class='resource_cell'><a href="/c1/save/{resource_id}/{save_resource}/" class="red_btn" >Add Resource</a></td><?php endif; ?>
		        	<td class="resource_cell delete-resource" data-id='{id}'><a href="javascript:delRequest({id},'{title}')">Delete</a></td>
		        <td>
		            <a class='edit' href="/c2/index/resource/{resource_id}/{id}"></a>
		        </td><?php endif; ?>
		    </tr>
			{/resources}
	</table>
{/if}
{if !resources}<span class="resource_cell">No Results Found</span>{/if}

<!-- </ul> -->
<script>


function delRequest(id,title)
{
    
$('#popupDel').modal('show');
$('.modal-body p').html('').append('Please confirm you would like to delete this Resource <span style="color:#e74c3c;text-decoration:underline;">'+title+'</span> ?');

    $('#popupDelBT').attr('rel', id);
   
   
}


	$('#popupDelBT').click(function() {
		//console.log('delete', $(this).data("id") );

    var id = $(this).attr('rel');
    $('#popupDel').modal('hide');
    //console.log(id);
    
		if(id!=='' || id!==undefined)
                    {
			$.ajax({
	          type: "POST",
	          url: "/c1/delete_document",
                  dataType: "json",
	          data: { id: id, query: $('#query_value_ajax').val() },
	          success:(function( data ) {
                  console.log(data);
                  window.location.reload();
	           // $(".returned_results").html('');
	            // $("ul").listview();
                    $('#popupDel').modal('hide');
	          })
                  
                   })
                  
                    }
	});

</script>

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
                <button id="popupDelBT" do="1" type="button" data-dismiss="modal" class="btn orange_btn del_resource">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->