<h3>Results</h3>
<?php if( $resources ): ?>
<table class='table3'>
    <tr>
        <th>Type</th>
        <th>Name</th>
        <th>Description</th>
        <th>User</th>
        <!-- <th>Score</th> -->
        <?php if( $user_type == 'teacher' ): ?>
            <?php if( $save_resource ): ?><th style="padding-left: 30px;">Add</th><?php endif; ?>
        <th>Delete</th>
        <th>Edit</th>
        <?php endif; ?>
    </tr>
    <?php foreach( $resources as $res ): ?>
    <tr>
        <td class="resource_cell resource_icon">
            <?php if( in_array( $res['type'], array('single_choice','multiple_choice','fill_in_the_blank','mark_the_words') ) ): ?>
            <span class="glyphicon glyphicon-question-sign" style="font-size: 15px; color: #db4646;"></span>
            <?php else: ?>
            <span class="icon <?php echo $res['type'] ?>"></span>
            <?php endif ?>
        </td>
        <td class="resource_cell name-resource"><?php echo $res['preview'] ?></td>
        <td class='resource_cell preview-resource' title="<?php echo $res['description'] ?>"><?php if( strlen( $res['description'] ) > 40 ) { echo substr( $res['description'],0,40 ).'...'; } else { echo $res['description']; } ?></td>
        <td class="resource_cell name-user"><?php if( strlen( $res['user'] ) > 20 ) { echo substr( $res['user'],0,20 ).'...'; } else { echo $res['user']; } ?></td>
        <?php if( $user_type == 'teacher' ): ?>
            <?php if( $save_resource ): ?>
                <?php if( $res['exist_resource'] ): ?>
        <td class='resource_cell'><a style=" cursor: pointer; margin-left: 10px;" onclick="unlinkResource(this)" rel="/<?php echo $res['resource_id'] ?>/<?php echo $save_resource ?>" class="publish_btn active" >LINKED</a></td>
                <?php else: ?>
        <td class='resource_cell'><a style=" cursor: pointer;" onclick="linkResource(this)" rel="/<?php echo $res['resource_id'] ?>/<?php echo $save_resource ?>" class="red_btn active" ><span style="display: inline-block;">Add Resource</span></a></td>
                <?php endif ?>
        <td class="resource_cell delete-resource" data-id='<?php echo $res['id'] ?>'><a class="delete" href="javascript:delRequest(<?php echo $res['id'] ?>,'<?php echo $res['resource_id'] ?>')"></a></td>
            <?php else: ?>
        <td class="resource_cell delete-resource" data-id='<?php echo $res['id'] ?>'><a class="delete2" href="javascript:delRequest(<?php echo $res['id'] ?>,'<?php echo $res['resource_id'] ?>')"></a></td>
            <?php endif ?>
<?php if(DEMO == 1 ): ?>
        <td><a class='edit' href="/c2n/index/<?php echo $res['resource_id'] ?>/<?php echo $edit_resource ?>"></a></td>
<?php else: ?>
        <td><a class='edit' href="/c2/index/<?php echo $res['resource_id'] ?>/<?php echo $edit_resource ?>"></a></td>
<?php endif ?>
<!--        <td><a class='edit' href="/c2/index/resource/<?php echo $res['resource_id'] ?>/<?php echo $res['id'] ?>"></a></td>-->
        <?php endif ?>
    </tr>
    <?php endforeach ?>
</table>
<?php else: ?>
<span class="resource_cell">No results found for this search</span>
<?php endif; ?>

<!-- </ul> -->
<script>

//    function delRequest(id,title,resource_id) {
    function delRequest(id,resource_id) {
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
                    if( data != false ) {
                        $('.modal-body ').append('<p>Please be aware that this Resource is being used in the following:</p>');
                        $.each(data.result, function(index,v) {
                            $.each(v, function(key, value) {
                                $('.modal-body ').append('<p style="text-align:left;padding-left: 100px;"><b>'+index+'</b>: '+value.title+', Year '+value.year+'</p>');
                            })
                        })
                    }
                    var title = $("td[data-id='"+id+"']").parent().find('.name-resource a').attr('title');
                    $('.modal-body').append('<p>Please confirm you would like to delete this Resource <span style="color:#e74c3c;text-decoration:underline;">'+title+'</span> ?</p>');
                })
            })
        }
        $('#popupDelBT').attr('rel', id);
    }

    function linkResource(res) {
        var elm = $(res);
        var url = '/c1/linkResource'+elm.attr('rel');
        if(res !== '' || res !== undefined ) {
            $.ajax({
                type: "GET",
                url: url,
                success: (function (data) {
                    if( data.status == 1 ) {
                        elm.removeClass('red_btn').addClass('publish_btn').html('LINKED').attr('onclick','unlinkResource(this)').css('cursor','pointer').css('margin-left','10px');
                    } else {
                        elm.removeClass('publish_btn').addClass('red_btn').html('ADD RESOURCE').attr('onclick','linkResource(this)').css('cursor','pointer');
                    }
                })
            },'jsonp')
        }
    }

    function unlinkResource(res) {
        var elm = $(res);
        var url = '/c1/unlinkResource'+elm.attr('rel');
        if(res !== '' || res !== undefined ) {
            $.ajax({
                type: "GET",
                url: url,
                success: (function (data) {
                    if( data.status == 1 ) {
                        elm.removeClass('publish_btn').addClass('red_btn').html('ADD RESOURCE').attr('onclick','linkResource(this)');
                    } else {
                        elm.removeClass('red_btn').addClass('publish_btn').html('LINKED').attr('onclick','unlinkResource(this)');
                    }
                })
            },'jsonp')
        }
    }

    $('#popupDelBT').click(function() {
        var id = $(this).attr('rel');
//console.log(id)
        $("td[data-id='"+id+"']").parent().fadeOut(300);
        $('#popupDel').modal('hide');

        if( id!=='' || id !== undefined ) {
            $.ajax({
                type: "POST",
                url: "/c1/delete_document",
                dataType: "json",
                data: { id: id, query: $('#query_value_ajax').val() },
                success:(function( data ) {
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