<?php

if ( !function_exists('md_admin_icon_add_circle') ) {
    
    /**
     * The function md_admin_icon_add_circle gets the add_circle's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_add_circle($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:add-circle-28-regular"></i>';

    }
    
}

/* End of file add_circle.php */