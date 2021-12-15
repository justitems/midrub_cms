<?php

if ( !function_exists('md_user_icon_user_2_line') ) {
    
    /**
     * The function md_user_icon_user_2_line gets the user_2_line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_user_2_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-user-2-line' . $class . '"></i>';

    }
    
}

/* End of file user_2_line.php */