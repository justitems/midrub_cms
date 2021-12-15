<?php

if ( !function_exists('md_user_icon_checked') ) {
    
    /**
     * The function md_user_icon_checked gets the checked's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_checked($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-check-line' . $class . '"></i>';

    }
    
}

/* End of file checked.php */