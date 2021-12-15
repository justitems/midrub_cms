<?php

if ( !function_exists('md_user_icon_percent_line') ) {
    
    /**
     * The function md_user_icon_percent_line gets the percent_line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_percent_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-percent-line' . $class . '"></i>';

    }
    
}

/* End of file percent_line.php */