<?php

if ( !function_exists('md_user_icon_folder_transfer') ) {
    
    /**
     * The function md_user_icon_folder_transfer gets the folder_transfer's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_folder_transfer($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-folder-transfer-line' . $class . '"></i>';

    }
    
}

/* End of file folder_transfer.php */