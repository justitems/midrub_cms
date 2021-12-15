<?php

if ( !function_exists('md_user_icon_forum') ) {
    
    /**
     * The function md_user_icon_forum gets the forum's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_forum($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">forum</i>';

    }
    
}

/* End of file forum.php */