<h3>{_controller_title}</h3>

<h4>Edit</h4>

<br/>

{form_open}

{id}

{temp_object_id}

<table class="table">

    <tr>

        <td>

            {message_label}

            {message}

            {message_error}

        </td>

    </tr>

    <tr>

        <td>

            {title_label}

            {title}

            {title_error}

        </td>

    </tr>

    <tr>

        <td>

            {pictures}

            <div class="alert alert-danger {picture_error_class}">{picture_error}</div>

        </td>

    </tr>

    <tr>

        <td>



            {temp_object_id}

            {form_submit}

        </td>

    </tr>

</table>

{form_close}

