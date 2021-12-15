<?php

if ( !function_exists('md_user_icon_file_copy') ) {
    
    /**
     * The function md_user_icon_file_copy gets the file_copy's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_file_copy($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-file-copy-line' . $class . '"></i>';

    }
    
}

/* End of file file_copy.php */