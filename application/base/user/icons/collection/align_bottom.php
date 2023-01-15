<?php

if ( !function_exists('md_user_icon_align_bottom') ) {
    
    /**
     * The function md_user_icon_align_bottom gets the align_bottom's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_align_bottom($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-align-bottom' . $class . '"></i>';

    }
    
}

/* End of file align_bottom.php */