<?php

if ( !function_exists('md_user_icon_repeat') ) {
    
    /**
     * The function md_user_icon_repeat gets the arrow left's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_repeat($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-repeat-2-line' . $class . '"></i>';

    }
    
}

/* End of file repeat.php */