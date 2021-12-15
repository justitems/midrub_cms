<?php

if ( !function_exists('md_admin_icon_new_theme') ) {
    
    /**
     * The function md_admin_icon_new_theme gets the new_theme's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_new_theme($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:tv-16-regular"></i>';

    }
    
}

/* End of file new_theme.php */