<?php

if ( !function_exists('md_user_icon_arrow_left_circle') ) {
    
    /**
     * The function md_user_icon_arrow_left_circle gets the arrow left's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_arrow_left_circle($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-arrow-left-circle-line' . $class . '"></i>';

    }
    
}

/* End of file arrow_left_circle.php */