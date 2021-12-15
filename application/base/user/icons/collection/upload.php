<?php

if ( !function_exists('md_user_icon_upload') ) {
    
    /**
     * The function md_user_icon_upload gets the upload's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_upload($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-folder-upload-line' . $class . '"></i>';

    }
    
}

/* End of file upload.php */