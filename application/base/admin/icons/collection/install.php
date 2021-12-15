<?php

if ( !function_exists('md_admin_icon_install') ) {
    
    /**
     * The function md_admin_icon_install gets the install's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_install($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:arrow-routing-rectangle-multiple-20-regular"></i>';

    }
    
}

/* End of file install.php */