<?php

if ( !function_exists('md_user_icon_align_center') ) {
    
    /**
     * The function md_user_icon_align_center gets the align_center's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_align_center($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-align-center' . $class . '"></i>';

    }
    
}

/* End of file align_center.php */