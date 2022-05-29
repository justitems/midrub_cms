<?php

if ( !function_exists('md_user_icon_received') ) {
    
    /**
     * The function md_user_icon_received gets the alternate received's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_received($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-folder-received-line' . $class . '"></i>';

    }
    
}

/* End of file received.php */