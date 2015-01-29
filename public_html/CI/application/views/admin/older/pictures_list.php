<h3>{_controller_title}</h3>

<!--<form method="get" class="form-search" id="filter_form">

    <input type="text" class="span1" placeholder="ID" name="filter[id]" value="{filter_id}">


    <input type="text" class="span2" placeholder="Nickname" name="filter[nickname]" value="{filter_nickname}">


    <input type="text" class="span3" placeholder="Email" name="filter[email]" value="{filter_email}">


    <input type="text" class="span2" placeholder="Last name" name="filter[last_name]" value="{filter_last_name}">


    <input type="hidden" id="sort" name="sort">


    <input type="submit"  value="Search" class="btn btn-info">

</form>-->

<br /><br />

<!--<h4>{_message}{message_filter}</h4>-->

<table class="table {hide_table}">


    <thead>


        <tr>

            <th class="span1">ID <a class="a_sort" id="id_sort" href="#"><i class="icon-{filter_icon-id}"></i></a></th>


            <th class="span1">Actions</th>


            <th class="span2">Picture <a class="a_sort" id="nickname_sort" href="#"><i class="icon-{filter_icon-nickname}"></i></a></th>

            <th class="span2">Status</th>
            
            <th class="span2">Hot</th>
            
            <th class="span2">User</th>
            
        </tr>


    </thead>


    <tbody>


        {objects}


        <tr>


            <td>
                <div class="pic_id">{id}</div>
                <div class="pic_type hidden">{type}</div>
            </td>


            <td>


                <a href="#" class="approve"><i class="icon-thumbs-up"></i></a>


                <a href="#" class="depricate"><i class="icon-thumbs-down"></i></a>


            </td>

            <td>
                <img src="{name}" /><br />
                {created}
            </td>
            
            <td class="status">{approved}</td>
            
            <td><i class="icon-fire"></i></td>
            
            <td>{nickname}</td>

        </tr>


        {/objects}


    </tbody>


</table>

<script type="text/javascript">
    $('a.approve').live('click',function(e) {
        var $pic_id = $(this).parent().parent().find('div.pic_id').text();
        var $current = $(this).parent().parent().find('td.status');
        $.ajax({
            type: "POST",
            url: "/admin/friend_profilies_photos/approve",
            data: {'pic_id' : $pic_id,'approve': 1},
            success : function(html) {
                $current.html(html);
            }
        });
    });
    
    $('a.depricate').live('click',function(e) {
        var $pic_id = $(this).parent().parent().find('div.pic_id').text();
        var $current = $(this).parent().parent().find('td.status');
        $.ajax({
            type: "POST",
            url: "/admin/friend_profilies_photos/approve",
            data: {'pic_id' : $pic_id,'approve': 0},
            success : function(html) {
                $current.html(html);
            }
        });
    });
</script>