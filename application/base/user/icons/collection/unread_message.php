<?php

if ( !function_exists('md_user_icon_unread_message') ) {
    
    /**
     * The function md_user_icon_unread_message gets the unread_message's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_unread_message($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-mail-unread-line' . $class . '"></i>';

    }
    
}

/* End of file unread_message.php */