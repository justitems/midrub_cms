<?php

if ( !function_exists('md_admin_icon_print') ) {
    
    /**
     * The function md_admin_icon_print gets the print icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_print($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:print-16-regular"></i>';

    }
    
}

/* End of file print.php */