<?php

if ( !function_exists('md_user_icon_download') ) {
    
    /**
     * The function md_user_icon_download gets the download's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_download($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-download-2-fill' . $class . '"></i>';

    }
    
}

/* End of file download.php */