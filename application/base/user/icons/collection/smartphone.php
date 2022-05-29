<?php

if ( !function_exists('md_user_icon_smartphone') ) {
    
    /**
     * The function md_user_icon_smartphone gets the smartphone's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_smartphone($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-smartphone-line' . $class . '"></i>';

    }
    
}

/* End of file smartphone.php */