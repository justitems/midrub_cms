<?php

if ( !function_exists('md_admin_icon_css') ) {
    
    /**
     * The function md_admin_icon_css gets the css icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_css($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:document-css-24-regular"></i>';

    }
    
}

/* End of file css.php */