<?php

if ( !function_exists('md_user_icon_plus') ) {
    
    /**
     * The function md_user_icon_add gets the plus's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_plus($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-add-line' . $class . '"></i>';

    }
    
}

/* End of file plus.php */