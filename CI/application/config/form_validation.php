<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



$config = array(

    'user_validation' => array(

        array(

            'field' => 'email',

            'label' => 'Email',

            'rules' => 'required|valid_email|unique_email_check'

        ),

       array(

            'field' => 'nickname',

            'label' => 'Nickname',

            'rules' => 'required|alpha_dash|xss_clean|unique_nickname_check'

        ),

        array(

            'field' => 'name',

            'label' => 'Name',

            'rules' => 'required'

        ),

        array(

            'field' => 'last_name',

            'label' => 'Last Name',

            'rules' => 'required'

        ),

        array(

            'field' => 'zip',

            'label' => 'ZIP',

            'rules' => 'min_length[5]|numeric|xss_clean'

        ),

        array(

            'field' => 'address',

            'label' => 'Address',

            'rules' => 'xss_clean'

        ),

        array(

            'field' => 'phone',

            'label' => 'Phone',

            'rules' => 'xss_clean|validate_phone_number'

        ),

        array(

            'field' => 'cell_phone',

            'label' => 'Cell phone',

            'rules' => 'xss_clean|validate_phone_number'

        ),

        array(

            'field' => 'website',

            'label' => 'Website',

            'rules' => 'xss_clean|validate_url'

        ),

        array(

            'field' => 'skype',

            'label' => 'Skype',

            'rules' => 'xss_clean'

        ),

        array(

            'field' => 'birthdate',

            'label' => 'Birthdate',

            'rules' => 'required|xss_clean|validate_date'

        ),

        array(

            'field' => 'personal_message',

            'label' => 'Personal message',

            'rules' => 'xss_clean'

        ),

       array(

            'field' => 'moderator',

            'label' => 'Profile moderator',

            'rules' => 'xss_clean'

        ),

        array(

            'field' => 'suggested',

            'label' => 'Profile suggested',

            'rules' => 'xss_clean'

        ),

        array(

            'field' => 'model',

            'label' => 'Model',

            'rules' => 'xss_clean'

        ),

        array(

            'field' => 'live_girl',

            'label' => 'Live girl',

            'rules' => 'xss_clean'

        ),

        array(

            'field' => 'email_visible',

            'label' => 'Email visible',

            'rules' => 'xss_clean'

        ),

        array(

            'field' => 'cellphone_visible',

            'label' => 'Cell phone visible',

            'rules' => 'xss_clean'

        ),

        array(

            'field' => 'password',

            'label' => 'Password',

            'rules' => 'required|min_length[4]|max_length[30]'

        )

    ),

     'chat_groups_validation' => array(

         array(

            'field' => 'message',

            'label' => 'Message',

            'rules' => 'required|max_length[255]|xss_clean' 

         ),

         array(

            'field' => 'title',

            'label' => 'Title',

            'rules' => 'required' 

         ),

         

         ),

    'album_validation' => array(

         array(

            'field' => 'album_name',

            'label' => 'Album name',

            'rules' => 'required|max_length[255]|xss_clean' 

         ),

         array(

            'field' => 'album_desc',

            'label' => 'Album Description',

            'rules' => 'required' 

         ),

         

         ),

);

