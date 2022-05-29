<?php

if ( !function_exists('md_user_icon_eye') ) {
    
    /**
     * The function md_user_icon_eye gets the eye's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_eye($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-eye-line' . $class . '"></i>';

    }
    
}

/* End of file eye.php */