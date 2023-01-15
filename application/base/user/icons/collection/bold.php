<?php

if ( !function_exists('md_user_icon_bold') ) {
    
    /**
     * The function md_user_icon_bold gets the bold's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bold($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-bold' . $class . '"></i>';

    }
    
}

/* End of file bold.php */