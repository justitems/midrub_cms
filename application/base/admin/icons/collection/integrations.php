<?php

if ( !function_exists('md_admin_icon_integrations') ) {
    
    /**
     * The function md_admin_icon_integrations gets the integrations's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_integrations($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:plug-connected-24-regular"></i>';

    }
    
}

/* End of file integrations.php */