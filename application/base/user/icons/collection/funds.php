<?php

if ( !function_exists('md_user_icon_funds') ) {
    
    /**
     * The function md_user_icon_funds gets the funds's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_funds($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-funds-line' . $class . '"></i>';

    }
    
}

/* End of file funds.php */