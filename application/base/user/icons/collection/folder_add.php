<?php

if ( !function_exists('md_user_icon_folder_add') ) {
    
    /**
     * The function md_user_icon_folder_add gets the folder_add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_folder_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-folder-add-line' . $class . '"></i>';

    }
    
}

/* End of file folder_add.php */