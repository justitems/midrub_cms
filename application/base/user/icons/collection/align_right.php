<?php

if ( !function_exists('md_user_icon_align_right') ) {
    
    /**
     * The function md_user_icon_align_right gets the align_right's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_align_right($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-align-right' . $class . '"></i>';

    }
    
}

/* End of file align_right.php */