<?php

if ( !function_exists('md_user_icon_airplay') ) {
    
    /**
     * The function md_user_icon_airplay gets the airplay's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_airplay($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-airplay-line' . $class . '"></i>';

    }
    
}

/* End of file airplay.php */