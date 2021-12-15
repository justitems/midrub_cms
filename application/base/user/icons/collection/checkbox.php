<?php

if ( !function_exists('md_user_icon_checkbox') ) {
    
    /**
     * The function md_user_icon_checkbox gets the checkbox's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_checkbox($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-checkbox-circle-line' . $class . '"></i>';

    }
    
}

/* End of file checkbox.php */