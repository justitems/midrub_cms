<?php

if ( !function_exists('md_user_icon_checkbox_blank') ) {
    
    /**
     * The function md_user_icon_checkbox_blank gets the grid fill's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_checkbox_blank($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class=""ri-checkbox-blank-circle-line' . $class . '"></i>';

    }
    
}

/* End of file checkbox_blank.php */