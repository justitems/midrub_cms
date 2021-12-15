<?php

if ( !function_exists('md_user_icon_upload_2') ) {
    
    /**
     * The function md_user_icon_upload_2 gets the upload_2's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_upload_2($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-upload-2-fill' . $class . '"></i>';

    }
    
}

/* End of file upload_2.php */