<?php

if ( !function_exists('md_user_icon_chat_favorites') ) {
    
    /**
     * The function md_user_icon_chat_favorites gets the chat_favorites's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_chat_favorites($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-chat-heart-line' . $class . '"></i>';

    }
    
}

/* End of file chat_favorites.php */