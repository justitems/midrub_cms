<?php

if ( !function_exists('md_user_icon_chat_forward') ) {
    
    /**
     * The function md_user_icon_chat_forward gets the chat_forward's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_chat_forward($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-chat-forward-line' . $class . '"></i>';

    }
    
}

/* End of file chat_forward.php */