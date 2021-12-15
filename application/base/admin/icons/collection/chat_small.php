<?php

if ( !function_exists('md_admin_icon_chat_small') ) {
    
    /**
     * The function md_admin_icon_chat_small gets the chat_small's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_chat_small($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:chat-bubbles-question-20-regular"></i>';

    }
    
}

/* End of file chat_small.php */