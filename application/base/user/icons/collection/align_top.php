<?php

if ( !function_exists('md_user_icon_align_top') ) {
    
    /**
     * The function md_user_icon_align_top gets the align_top's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_align_top($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-align-top' . $class . '"></i>';

    }
    
}

/* End of file align_top.php */