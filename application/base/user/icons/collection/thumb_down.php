<?php

if ( !function_exists('md_user_icon_thumb_down') ) {
    
    /**
     * The function md_user_icon_thumb_down gets the thumb_down's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_thumb_down($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-thumb-down-line' . $class . '"></i>';

    }
    
}

/* End of file thumb_down.php */