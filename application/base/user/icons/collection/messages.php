<?php

if ( !function_exists('md_user_icon_messages') ) {
    
    /**
     * The function md_user_icon_messages gets the messages icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_messages($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-discuss-line' . $class . '"></i>';

    }
    
}

/* End of file messages.php */