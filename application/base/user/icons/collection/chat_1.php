<?php

if ( !function_exists('md_user_icon_chat_1') ) {
    
    /**
     * The function md_user_icon_chat_1 gets the chat's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_chat_1($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-chat-1-line' . $class . '"></i>';

    }
    
}

/* End of file chat_1.php */