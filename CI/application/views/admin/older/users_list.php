<h3>{_controller_title}</h3>



<form method="get" class="form-search" id="filter_form">



    <input type="text" class="span1" placeholder="ID" name="filter[id]" value="{filter_id}">

    <input type="text" class="span2" placeholder="Nickname" name="filter[nickname]" value="{filter_nickname}">

    <input type="text" class="span3" placeholder="Email" name="filter[email]" value="{filter_email}">

    <input type="text" class="span2" placeholder="Last name" name="filter[last_name]" value="{filter_last_name}">

    <input type="hidden" id="sort" name="sort">

    <input type="submit"  value="Search" class="btn btn-info">

</form>



<a class="btn btn-success" href="/admin/{_controller_name}/detail">Add</a>



<br/>

<br/>



<h4>{_message}{message_filter}</h4>



<table class="table {hide_table}">

    <thead>

        <tr>

            <th class="span1">ID <a class="a_sort" id="id_sort" href="#"><i class="icon-{filter_icon-id}"></i></a></th>

            <th class="span1">Actions</th>

            <th class="span2">Nickname <a class="a_sort" id="nickname_sort" href="#"><i class="icon-{filter_icon-nickname}"></i></a></th>

            <th class="span2">Last name <a class="a_sort" id="last_name_sort" href="#"><i class="icon-{filter_icon-last_name}"></i></a></th>

            <th class="span2">User type <a class="a_sort" id="user_type_id_sort" href="#"><i class="icon-{filter_icon-user_type_id}"></i></a></th>

            <th class="span2">Ip <a class="a_sort" id="ip_sort" href="#"><i class="icon-{filter_icon-ip}"></i></a></th>

            <th class="span2">Email <a class="a_sort" id="email_sort" href="#"><i class="icon-{filter_icon-email}"></i></a></th>





        </tr>

    </thead>

    <tbody>

        {objects}

        <tr>

            <td>{id}</td>

            <td>

                <a href="/admin/{_controller_name}/detail/{id}"><i class="icon-edit"></i></a>

                <a class="delete" href="/admin/{_controller_name}/delete/{id}"><i class="icon-remove"></i></a>

            </td>

            <td>{nickname}</td>

            <td>{last_name}</td>

            <td>{user_type}</td>

            <td>{ip}</td>

            <td><span class="label label-info">{email}</span></td>

        </tr>

        {/objects}

    </tbody>

</table>

