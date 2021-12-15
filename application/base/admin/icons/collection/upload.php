<?php

if ( !function_exists('md_admin_icon_upload') ) {
    
    /**
     * The function md_admin_icon_upload gets the upload's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_upload($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:folder-arrow-right-20-regular"></i>';

    }
    
}

/* End of file upload.php */