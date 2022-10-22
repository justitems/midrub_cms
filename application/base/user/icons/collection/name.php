<?php

if ( !function_exists('md_user_icon_name') ) {
    
    /**
     * The function md_user_icon_name gets the name's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_name($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-qr-scan-line' . $class . '"></i>';

    }
    
}

/* End of file name.php */