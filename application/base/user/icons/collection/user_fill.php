<?php

if ( !function_exists('md_user_icon_user_fill') ) {
    
    /**
     * The function md_user_icon_user_fill gets the user fill's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_user_fill($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-user-fill' . $class . '"></i>';

    }
    
}

/* End of file user_fill.php */