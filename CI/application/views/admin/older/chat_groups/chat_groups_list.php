<h3>{_controller_title}</h3>

<a class="btn btn-success" href="/admin/{_controller_name}/detail">Add</a>

<br/>

<br/>

<h4>{_message}</h4>



<table class="table">

    <thead>

        <tr>

            <th class="span1">ID </th>

            <th class="span1">Actions</th>

            <th class="span2">Title</th>

            <th class="span2">Message</th>

            <th class="span2">Time</th>

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

            <td>{title}</td>

            <td>{message}</td>

            <td>{time}</td>



        </tr>

        {/objects}

    </tbody>

</table>