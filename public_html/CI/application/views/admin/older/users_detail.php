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

            {label_user_types}

            {select_user_types}

        </td>

    </tr>

    <tr>

        <td>

            {label_profile_types}

            {select_profile_types}

        </td>

    </tr>

    <tr>

        <td>

            {label_sex}

            {select_sex}

        </td>

    </tr>

    <tr>

        <td>

            {label_cities}

            {select_cities}

        </td>

    </tr>

    <tr>

        <td>

            {label_regions}

            {select_regions}

        </td>

    </tr>

    <tr>

        <td>

            {label_states}

            {select_states}

        </td>

    </tr>

    <tr>

        <td>

            {label_zodiacal_sign}

            {select_zodiacal_sign}

        </td>

    </tr>

    <tr>

        <td>

            {email_label}

            {email}

            {email_error}

        </td>

    </tr>

    <tr>

    <tr>

        <td>

            {email_visible_label}

            {email_visible}

            {email_visible_error}

        </td>

    </tr>

    <tr>

        <td>

            {nickname_label}

            {nickname}

            {nickname_error}

        </td>

    </tr>

    <tr>

        <td>

            {password_alert}

            {password_label}

            {password}

            {password_error}

        </td>

    </tr>

    <tr>

        <td>

            {name_label}

            {name}

            {name_error}

        </td>

    </tr>

    <tr>

        <td>

            {last_name_label}

            {last_name}

            {last_name_error}

        </td>

    </tr>

    <tr>

        <td>

            {zip_label}

            {zip}

            {zip_error}

        </td>

    </tr>

    <tr>

        <td>

            {address_label}

            {address}

            {address_error}

        </td>

    </tr>

    <tr>

        <td>

            {phone_label}

            {phone}

            {phone_error}

        </td>

    </tr>

    <tr>

        <td>

            {cell_phone_label}

            {cell_phone}

            {cell_phone_error}

        </td>

    </tr>

    <tr>

        <td>

            {cellphone_visible_label}

            {cellphone_visible}

            {cellphone_visible_error}

        </td>

    </tr>

    <tr>

        <td>

            {website_label}

            {website}

            {website_error}

        </td>

    </tr>

    <tr>

        <td>

            {skype_label}

            {skype}

            {skype_error}

        </td>

    </tr>

    <tr>

        <td>

            {birthdate_label}

            {birthdate}

            {birthdate_error}

        </td>

    </tr>

    <tr>

        <td>

            {personal_message_label}

            {personal_message}

            {personal_message_error}

        </td>

    </tr>

    <tr>

        <td>

            {moderator_label}

            {moderator}

            {moderator_error}

        </td>

    </tr>

    <tr>

        <td>

            {suggested_label}

            {suggested}

            {suggested_error}

        </td>

    </tr>

    <tr>

        <td>

            {model_label}

            {model}

            {model_error}

        </td>

    </tr>

    <tr>

        <td>

            {live_girl_label}

            {live_girl}

            {live_girl_error}

        </td>

    </tr>

    <tr>

        <td>

            {registred_label}

            {ip_label}

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

