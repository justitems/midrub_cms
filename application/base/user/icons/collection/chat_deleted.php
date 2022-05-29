<?php

if ( !function_exists('md_user_icon_chat_deleted') ) {
    
    /**
     * The function md_user_icon_chat_deleted gets the chat_deleted's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_chat_deleted($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-chat-delete-line' . $class . '"></i>';

    }
    
}

/* End of file chat_deleted.php */