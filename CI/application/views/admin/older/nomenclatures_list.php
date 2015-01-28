<h3>{_nomenclature_title}</h3>



<a class="btn btn-success" href="/admin/{_controller_name}/detail/{_table_name}">Add</a>



<br/>

<br/>



<h4>{_message}</h4>



<table class="table">

	<thead>

		<tr>

			<th class="span1">ID</th>

			<th class="span1">Actions</th>

			<th class="span1">Name</th>



		</tr>

	</thead>

	<tbody>

		{objects}

		<tr>

			<td>{id}</td>

			<td>

				<a href="/admin/{_controller_name}/detail/{_table_name}/{id}"><i class="icon-edit"></i></a>

				<a class="delete" href="/admin/{_controller_name}/delete/{_table_name}/{id}"><i class="icon-remove"></i></a>

			</td>

			<td>{name}</td>	

		</tr>

		{/objects}

	</tbody>

</table>