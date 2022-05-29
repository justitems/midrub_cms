<?php

if ( !function_exists('md_user_icon_chat_seen') ) {
    
    /**
     * The function md_user_icon_chat_seen gets the chat_seen's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_chat_seen($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-chat-check-line' . $class . '"></i>';

    }
    
}

/* End of file chat_seen.php */