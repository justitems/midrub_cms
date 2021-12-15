<?php

if ( !function_exists('md_admin_icon_components') ) {
    
    /**
     * The function md_admin_icon_components gets the components's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_components($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:mail-inbox-20-regular"></i>';

    }
    
}

/* End of file components.php */