<?php

if ( !function_exists('md_admin_icon_print_small') ) {
    
    /**
     * The function md_admin_icon_print_small gets the print_small icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_print_small($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:print-48-regular"></i>';

    }
    
}

/* End of file print_small.php */