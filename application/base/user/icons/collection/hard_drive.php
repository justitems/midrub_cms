<?php

if ( !function_exists('md_user_icon_hard_drive') ) {
    
    /**
     * The function md_user_icon_hard_drive gets the hard_drive's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_hard_drive($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-hard-drive-2-line' . $class . '"></i>';

    }
    
}

/* End of file hard_drive.php */