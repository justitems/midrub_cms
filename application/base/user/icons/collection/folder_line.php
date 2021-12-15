<?php

if ( !function_exists('md_user_icon_folder_line') ) {
    
    /**
     * The function md_user_icon_folder_line gets the folder_line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_folder_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-folder-line' . $class . '"></i>';

    }
    
}

/* End of file folder_line.php */