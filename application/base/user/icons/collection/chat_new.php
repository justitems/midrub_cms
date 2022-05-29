<?php

if ( !function_exists('md_user_icon_chat_new') ) {
    
    /**
     * The function md_user_icon_chat_new gets the chat_new's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_chat_new($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-chat-new-line' . $class . '"></i>';

    }
    
}

/* End of file chat_new.php */