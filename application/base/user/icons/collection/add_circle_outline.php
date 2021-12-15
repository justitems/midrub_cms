<?php

if ( !function_exists('md_user_icon_add_circle_outline') ) {
    
    /**
     * The function md_user_icon_add_circle_outline gets the add_circle_outline's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_add_circle_outline($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'add_circle_outline'
        . '</i>';

    }
    
}

/* End of file add_circle_outline.php */