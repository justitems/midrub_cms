<?php

if ( !function_exists('md_user_icon_comments') ) {
    
    /**
     * The function md_user_icon_comments gets the comments icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_comments($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-message-3-line' . $class . '"></i>';

    }
    
}

/* End of file comments.php */