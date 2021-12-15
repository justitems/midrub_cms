<?php

if ( !function_exists('md_admin_icon_menu') ) {
    
    /**
     * The function md_admin_icon_menu gets the menu's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_menu($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:task-list-square-rtl-20-regular"></i>';

    }
    
}

/* End of file menu.php */