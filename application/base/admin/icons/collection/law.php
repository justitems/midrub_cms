<?php

if ( !function_exists('md_admin_icon_law') ) {
    
    /**
     * The function md_admin_icon_law gets the law's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_law($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:certificate-20-regular"></i>';

    }
    
}

/* End of file law.php */