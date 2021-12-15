<?php

if ( !function_exists('md_user_icon_code') ) {
    
    /**
     * The function md_user_icon_code gets the code's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_code($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'code'
        . '</i>';

    }
    
}

/* End of file code.php */