<h3>Категории</h3>

<h4>Редакция</h4>

<br/>



<form method="post" action="/admin/page_categories/save/{id}">



	<table class="table">

		<tr>

			<td>

				<label>Име</label>

				{validation_title}

				<input class="span6" placeholder="Име" type="text" name="title" value="{title}" />

				<br/>

			</td>

		</tr>

		<tr>

			<td>

				<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Запази</button>

			</td>

		</tr>

	</table>

</form>