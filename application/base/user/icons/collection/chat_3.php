<?php

if ( !function_exists('md_user_icon_chat_3') ) {
    
    /**
     * The function md_user_icon_chat_3 gets the chat_3 icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_chat_3($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-chat-3-line' . $class . '"></i>';

    }
    
}

/* End of file chat_3.php */