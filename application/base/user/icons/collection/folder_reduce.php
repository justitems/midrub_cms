<?php

if ( !function_exists('md_user_icon_folder_reduce') ) {
    
    /**
     * The function md_user_icon_folder_reduce gets the folder_reduce's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_folder_reduce($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-folder-reduce-line' . $class . '"></i>';

    }
    
}

/* End of file folder_reduce.php */