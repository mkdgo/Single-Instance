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



<h3>{_controller_title}</h3>

<h4>Edit</h4>

<br/>



{form_open}



{id}

<table class="table">

    <tr>

        <td>

            {key_label}

            {key}

        </td>

    </tr>

    <tr>

        <td>

            {keywords_label}

            {keywords}

        </td>

    </tr>

    <tr>

        <td>

            {description_label}

            {description}

        </td>

    </tr>

    <tr>

        <td>

            {title_label}

            {title_arr}

            {title_field} <img src="{flag}" alt="" /> 

            {validation}

            <div class="clear"> </div>

            {/title_arr}

        </td>

    </tr>

    <tr>

        <td>

            {content_label}

            {content_arr}

            <img src="{flag}" alt="" /><br />

            {content_field}  <br /><br />

            <!-- {validation} -->

            <div class="clear"> </div><br />

            {/content_arr}



        </td>

    </tr>

    <tr>

        <td>

            {pictures}

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

