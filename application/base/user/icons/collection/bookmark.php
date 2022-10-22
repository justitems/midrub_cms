<?php

if ( !function_exists('md_user_icon_bookmark') ) {
    
    /**
     * The function md_user_icon_bookmark gets the bookmark's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bookmark($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-bookmark-line' . $class . '"></i>';

    }
    
}

/* End of file bookmark.php */