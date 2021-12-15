<?php

if ( !function_exists('md_user_icon_tools') ) {
    
    /**
     * The function md_user_icon_tools gets the tools icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_tools($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-tools-line' . $class . '"></i>';

    }
    
}

/* End of file tools.php */