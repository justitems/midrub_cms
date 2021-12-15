<?php

if ( !function_exists('md_user_icon_folder_open') ) {
    
    /**
     * The function md_user_icon_folder_open gets the folder_open's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_folder_open($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-folder-open-line' . $class . '"></i>';

    }
    
}

/* End of file folder_open.php */