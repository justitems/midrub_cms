<?php

if ( !function_exists('md_user_icon_download_cloud') ) {
    
    /**
     * The function md_user_icon_download_cloud gets the download_cloud's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_download_cloud($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-download-cloud-2-line' . $class . '"></i>';

    }
    
}

/* End of file download_cloud.php */