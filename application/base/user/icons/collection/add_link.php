<?php

if ( !function_exists('md_user_icon_add_link') ) {
    
    /**
     * The function md_user_icon_add_link gets the add_link's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_add_link($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'add_link'
        . '</i>';

    }
    
}

/* End of file add_link.php */