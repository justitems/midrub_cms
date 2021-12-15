<?php

if ( !function_exists('md_user_icon_space_dashboard') ) {
    
    /**
     * The function md_user_icon_space_dashboard gets the space_dashboard's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_space_dashboard($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'space_dashboard'
        . '</i>';

    }
    
}

/* End of file space_dashboard.php */