<?php

if ( !function_exists('md_user_icon_chat_history') ) {
    
    /**
     * The function md_user_icon_chat_history gets the chat_history's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_chat_history($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-chat-history-line' . $class . '"></i>';

    }
    
}

/* End of file chat_history.php */