<?php

if ( !function_exists('md_user_icon_upload_cloud') ) {
    
    /**
     * The function md_user_icon_upload_cloud gets the upload cloud's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_upload_cloud($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-upload-cloud-2-line' . $class . '"></i>';

    }
    
}

/* End of file upload_cloud.php */