<?php

if ( !function_exists('md_user_icon_import') ) {
    
    /**
     * The function md_user_icon_import gets the import's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_import($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-upload-2-line' . $class . '"></i>';

    }
    
}

/* End of file import.php */