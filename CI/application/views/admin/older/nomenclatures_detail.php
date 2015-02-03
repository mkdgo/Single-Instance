<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">

	tinyMCE.init({

		// General options

		mode: "textareas",

		editor_selector: "mceEditor",

		theme: "advanced",

		plugins: "preview,contextmenu,wordcount,table",

		// Theme options

		theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,forecolor,backcolor,|,formatselect,fontsizeselect,|,link,unlink,anchor,image,|,undo,redo,|,preview,code",

		theme_advanced_buttons2: "tablecontrols",

		theme_advanced_buttons3: "",

		theme_advanced_buttons4: "",

		theme_advanced_toolbar_location: "top",

		theme_advanced_toolbar_align: "left",

		theme_advanced_statusbar_location: "bottom",

		theme_advanced_resizing: true

	});

</script>



<h3>{_nomenclature_title}</h3>

<h4>Edit</h4>

<br/>



{form_open}



{id}

<table class="table">

	<tr>

		<td>

			{name_label}

			{name_arr}

			{name_field} <img src="{flag}" alt="" /> 

			{validation}

			<div class="clear"> </div>

			{/name_arr}

		</td>

	</tr>	

<tr>

		<td>

			{option_label}

			{option}

		</td>

	</tr>

	<tr>

		<td>

			{form_submit}

		</td>

	</tr>







</table>

{form_close}

