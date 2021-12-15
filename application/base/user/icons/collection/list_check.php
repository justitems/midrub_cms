<?php

if ( !function_exists('md_user_icon_list_check') ) {
    
    /**
     * The function md_user_icon_list_check gets the list check's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_list_check($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-list-check-2' . $class . '"></i>';

    }
    
}

/* End of file list_check.php */