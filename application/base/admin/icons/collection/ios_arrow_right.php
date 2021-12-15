<?php

if ( !function_exists('md_admin_icon_ios_arrow_right') ) {
    
    /**
     * The function md_admin_icon_ios_arrow_right gets the ios_arrow_right's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_ios_arrow_right($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:ios-arrow-right-24-filled"></i>';

    }
    
}

/* End of file ios_arrow_right.php */