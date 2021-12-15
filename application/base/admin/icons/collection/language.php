<?php

if ( !function_exists('md_admin_icon_language') ) {
    
    /**
     * The function md_admin_icon_language gets the language's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_language($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:translate-20-regular"></i>';

    }
    
}

/* End of file language.php */