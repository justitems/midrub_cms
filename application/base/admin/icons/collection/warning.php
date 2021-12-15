<?php

if ( !function_exists('md_admin_icon_warning') ) {
    
    /**
     * The function md_admin_icon_warning gets the warning's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_warning($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:warning-20-regular"></i>';

    }
    
}

/* End of file warning.php */