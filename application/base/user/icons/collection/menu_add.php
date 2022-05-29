<?php

if ( !function_exists('md_user_icon_menu_add') ) {
    
    /**
     * The function md_user_icon_menu_add gets the menu_add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_menu_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-menu-add-fill' . $class . '"></i>';

    }
    
}

/* End of file menu_add.php */