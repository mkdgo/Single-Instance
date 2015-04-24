<h3>Results</h3>
{if resources}
<table class='table3'>
    <th>Type</th>
    <th>Name</th>
    <th>Preview</th>
    <th>User</th>
    <!-- <th>Score</th> -->
    <?php if ($user_type == 'teacher'): ?>
        <?php if ($save_resource): ?><th style="padding-left: 30px;">Add</th><?php endif; ?>
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

            <?php if ($save_resource){ ?>
        <td class='resource_cell'><a href="/c1/save/{resource_id}/{save_resource}/" class="red_btn" >Add Resource</a></td>
        <td class="resource_cell delete-resource" data-id='{id}'><a class="delete" href="javascript:delRequest({id},'{title}','{resource_id}')"></a></td>
            <?php } else { ?>
        <td class="resource_cell delete-resource" data-id='{id}'><a class="delete2" href="javascript:delRequest({id},'{title}','{resource_id}')"></a></td>
        <?php } ?>

        <td><a class='edit' href="/c2/index/resource/{resource_id}/{id}"></a></td>
        <?php endif; ?>
    </tr>
    {/resources}
</table>
{/if}
{if !resources}<span class="resource_cell">No results found for this search</span>{/if}

<!-- </ul> -->
<script>

    function delRequest(id,title,resource_id) {
        $('#popupDel').modal('show');
        $('.modal-body ').html('');
        //get resources usage
        if(resource_id!=='' || resource_id!==undefined) {
            $.ajax({
                type: "POST",
                url: "/c1/get_resource_usage",
                dataType: "json",
                data: {resource_id: resource_id, query: $('#query_value_ajax').val()},
                success: (function (data) {
                    if(data!=false)	{
//console.log(data);
                        $('.modal-body ').append('<p>Please be aware that this Resource is being used in the following:</p>');
                        $.each(data.result, function(index,v) {
                            $.each(v, function(key, value) {
                                $('.modal-body ').append('<p style="text-align:left;padding-left: 100px;"><b>'+index+'</b>: '+value.title+', Year '+value.year+'</p>');
                            })
                        })
                    }
                    $('.modal-body').append('<p>Please confirm you would like to delete this Resource <span style="color:#e74c3c;text-decoration:underline;">'+title+'</span> ?</p>');
                })
            })
        }

        $('#popupDelBT').attr('rel', id);
    }

    $('#popupDelBT').click(function() {
//console.log('delete', $(this).data("id") );
        var id = $(this).attr('rel');
        $('#popupDel').modal('hide');
//console.log(id);
        if(id!=='' || id!==undefined) {
            $.ajax({
                type: "POST",
                url: "/c1/delete_document",
                dataType: "json",
                data: { id: id, query: $('#query_value_ajax').val() },
                success:(function( data ) {
//console.log(data);
                    window.location.reload();
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
            </div>
            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupDelBT" do="1" type="button" data-dismiss="modal" class="btn orange_btn del_resource">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->