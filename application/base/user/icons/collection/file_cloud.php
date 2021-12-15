<?php

if ( !function_exists('md_user_icon_file_cloud') ) {
    
    /**
     * The function md_user_icon_file_cloud gets the file_cloud's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_file_cloud($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-file-cloud-line' . $class . '"></i>';

    }
    
}

/* End of file file_cloud.php */