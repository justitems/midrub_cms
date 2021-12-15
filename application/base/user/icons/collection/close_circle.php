<?php

if ( !function_exists('md_user_icon_close_circle') ) {
    
    /**
     * The function md_user_icon_close_circle gets the close_circle's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_close_circle($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-close-circle-line' . $class . '"></i>';

    }
    
}

/* End of file close_circle.php */