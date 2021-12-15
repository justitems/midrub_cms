<?php

if ( !function_exists('md_user_icon_user_add') ) {
    
    /**
     * The function md_user_icon_user gets the user_add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_user_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-user-add-line' . $class . '"></i>';

    }
    
}

/* End of file user_add.php */