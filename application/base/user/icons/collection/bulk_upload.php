<?php

if ( !function_exists('md_user_icon_bulk_upload') ) {
    
    /**
     * The function md_user_icon_bulk upload gets the bulk upload's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bulk_upload($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-folder-upload-line' . $class . '"></i>';

    }
    
}

/* End of file bulk_upload.php */