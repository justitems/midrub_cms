<?php

if ( !function_exists('md_user_icon_checkbox_multiple') ) {
    
    /**
     * The function md_user_icon_checkbox_multiple gets the checkbox_multiple's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_checkbox_multiple($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-checkbox-multiple-line' . $class . '"></i>';

    }
    
}

/* End of file checkbox_multiple.php */