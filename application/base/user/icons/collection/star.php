<?php

if ( !function_exists('md_user_icon_star') ) {
    
    /**
     * The function md_user_icon_star gets the star's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_star($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-star-line' . $class . '"></i>';

    }
    
}

/* End of file star.php */