<?php

if ( !function_exists('md_admin_icon_app_add') ) {
    
    /**
     * The function md_admin_icon_app_add gets the app_add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_app_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:calendar-today-16-regular"></i>';

    }
    
}

/* End of file app_add.php */