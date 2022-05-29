<?php

if ( !function_exists('md_user_icon_manage') ) {
    
    /**
     * The function md_user_icon_manage gets the manage's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_manage($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-magic-line' . $class . '"></i>';

    }
    
}

/* End of file manage.php */