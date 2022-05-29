<?php

if ( !function_exists('md_user_icon_mail_add') ) {
    
    /**
     * The function md_user_icon_mail_add gets the mail_add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_mail_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-mail-add-line' . $class . '"></i>';

    }
    
}

/* End of file mail_add.php */