<?php

if ( !function_exists('md_user_icon_minus') ) {
    
    /**
     * The function md_user_icon_add gets the minus icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_minus($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-subtract-line' . $class . '"></i>';

    }
    
}

/* End of file minus.php */