<h3>{_controller_title}</h3>



<a class="btn btn-success" href="/admin/{_controller_name}/detail">Add</a>



<h4>{_message}{message_filter}</h4>

<table class="table {hide_table}">

    <thead>

        <tr>

            <th class="span1">ID <a class="a_sort" id="id_sort" href="#"><i class="icon-{filter_icon-id}"></i></a></th>

            <th class="span1">Actions</th>

            <th class="span2">Key <a class="a_sort" id="nickname_sort" href="#"><i class="icon-{filter_icon-nickname}"></i></a></th>

            <th class="span2">Name<a class="a_sort" id="last_name_sort" href="#"><i class="icon-{filter_icon-last_name}"></i></a></th>

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

            <td><span class="label label-info">{key}</span></td>

            <td>{title}</td>



        </tr>

        {/objects}

    </tbody>

</table>

