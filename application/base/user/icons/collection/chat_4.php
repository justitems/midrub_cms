<?php

if ( !function_exists('md_user_icon_chat_4') ) {
    
    /**
     * The function md_user_icon_chat_4 gets the chat_4 icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_chat_4($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-chat-4-fill' . $class . '"></i>';

    }
    
}

/* End of file chat_4.php */