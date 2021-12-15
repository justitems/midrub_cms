<?php

if ( !function_exists('md_user_icon_insert_link') ) {
    
    /**
     * The function md_user_icon_insert_link gets the insert_link's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_insert_link($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'insert_link'
        . '</i>';

    }
    
}

/* End of file insert_link.php */