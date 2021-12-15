<?php

if ( !function_exists('md_user_icon_thumb_up') ) {
    
    /**
     * The function md_user_icon_thumb_up gets the thumb_up's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_thumb_up($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-thumb-up-line' . $class . '"></i>';

    }
    
}

/* End of file thumb_up.php */