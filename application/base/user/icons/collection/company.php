<?php

if ( !function_exists('md_user_icon_company') ) {
    
    /**
     * The function md_user_icon_company gets the company's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_company($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-building-4-line' . $class . '"></i>';

    }
    
}

/* End of file company.php */