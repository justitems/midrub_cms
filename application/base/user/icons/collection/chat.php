<?php

if ( !function_exists('md_user_icon_chat') ) {
    
    /**
     * The function md_user_icon_chat gets the chat's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_chat($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-message-2-line' . $class . '"></i>';

    }
    
}

/* End of file chat.php */