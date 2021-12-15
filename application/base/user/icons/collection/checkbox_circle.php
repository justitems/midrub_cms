<?php

if ( !function_exists('md_user_icon_checkbox_circle') ) {
    
    /**
     * The function md_user_icon_checkbox_circle gets the grid fill's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_checkbox_circle($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-checkbox-circle-line' . $class . '"></i>';

    }
    
}

/* End of file checkbox_circle.php */