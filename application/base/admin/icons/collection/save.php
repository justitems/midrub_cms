<?php

if ( !function_exists('md_admin_icon_save') ) {
    
    /**
     * The function md_admin_icon_save gets the save's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_save($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:save-16-regular"></i>';

    }
    
}

/* End of file save.php */