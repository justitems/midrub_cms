<?php

if ( !function_exists('md_user_icon_dollar') ) {
    
    /**
     * The function md_user_icon_dollar gets the dollar's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_dollar($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-money-dollar-circle-line' . $class . '"></i>';

    }
    
}

/* End of file dollar.php */