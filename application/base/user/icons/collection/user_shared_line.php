<?php

if ( !function_exists('md_user_icon_user_shared_line') ) {
    
    /**
     * The function md_user_icon_user_shared_line gets the user_shared_line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_user_shared_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-user-shared-line' . $class . '"></i>';

    }
    
}

/* End of file user_shared_line.php */