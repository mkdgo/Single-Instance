<h3>Категории</h3>



<a class="btn btn-success" href="/admin/page_categories/detail">Добави</a>



<br/><br/>



<table class="table">

	<thead>

		<tr>

			<th class="span1">ID</th>

			<th class="span1">Редакция</th>

			<th>Име</th>

		</tr>

	</thead>

	<tbody>

	{objects}

		<tr>

			<td>{id}</td>

			<td>

				<a href="/admin/page_categories/detail/{id}"><i class="icon-edit"></i></a>

				<a class="delete" href="/admin/page_categories/delete/{id}"><i class="icon-remove"></i></a>

			</td>

			<td>{page_category_title}</td>

		</tr>

	{/objects}

	</tbody>

</table>

