<?php

if ( !function_exists('md_user_icon_usage') ) {
    
    /**
     * The function md_user_icon_usage gets the usage's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_usage($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-file-shred-line' . $class . '"></i>';

    }
    
}

/* End of file usage.php */