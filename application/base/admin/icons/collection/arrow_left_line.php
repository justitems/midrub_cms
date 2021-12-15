<?php

if ( !function_exists('md_admin_icon_arrow_left_line') ) {
    
    /**
     * The function md_admin_icon_arrow_left_line gets the arrow_left_line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_arrow_left_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:arrow-left-12-regular"></i>';

    }
    
}

/* End of file arrow_left_line.php */