<?php

if ( !function_exists('md_user_icon_align_left') ) {
    
    /**
     * The function md_user_icon_align_left gets the align_left's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_align_left($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-align-left' . $class . '"></i>';

    }
    
}

/* End of file align_left.php */