<?php

if ( !function_exists('md_user_icon_send_message') ) {
    
    /**
     * The function md_user_icon_send_message sends a message
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_send_message($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-chat-upload-line' . $class . '"></i>';

    }
    
}

/* End of file send_message.php */