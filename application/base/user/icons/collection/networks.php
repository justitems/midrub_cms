<?php

if ( !function_exists('md_user_icon_networks') ) {
    
    /**
     * The function md_user_icon_networks gets the networks's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_networks($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-share-line' . $class . '"></i>';

    }
    
}

/* End of file networks.php */