<?php

if ( !function_exists('md_user_icon_add') ) {
    
    /**
     * The function md_user_icon_add gets the add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-add-fill' . $class . '"></i>';

    }
    
}

/* End of file add.php */