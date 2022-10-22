<?php

if ( !function_exists('md_user_icon_comment') ) {
    
    /**
     * The function md_user_icon_comment gets the comment icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_comment($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-chat-3-fill' . $class . '"></i>';

    }
    
}

/* End of file comment.php */