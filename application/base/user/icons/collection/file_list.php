<?php

if ( !function_exists('md_user_icon_file_list') ) {
    
    /**
     * The function md_user_icon_file_list gets the file_list's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_file_list($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-file-list-line' . $class . '"></i>';

    }
    
}

/* End of file file_list.php */