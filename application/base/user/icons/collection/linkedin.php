<?php

if ( !function_exists('md_user_icon_linkedin') ) {
    
    /**
     * The function md_user_icon_linkedin gets the linkedin's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_linkedin($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-linkedin-fill' . $class . '"></i>';

    }
    
}

/* End of file linkedin.php */