<?php

if ( !function_exists('md_user_icon_arrow_up_line') ) {
    
    /**
     * The function md_user_icon_arrow_up_line gets the arrow up's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_arrow_up_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-arrow-up-line' . $class . '"></i>';

    }
    
}

/* End of file arrow_up_line.php */