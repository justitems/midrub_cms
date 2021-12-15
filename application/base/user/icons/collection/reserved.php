<?php

if ( !function_exists('md_user_icon_reserved') ) {
    
    /**
     * The function md_user_icon_reserved gets the reserved's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_reserved($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-reserved-line' . $class . '"></i>';

    }
    
}

/* End of file reserved.php */