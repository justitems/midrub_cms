<?php

if ( !function_exists('md_admin_icon_ios_arrow_left') ) {
    
    /**
     * The function md_admin_icon_ios_arrow_left gets the ios_arrow_left's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_ios_arrow_left($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:ios-arrow-left-24-filled"></i>';

    }
    
}

/* End of file ios_arrow_left.php */