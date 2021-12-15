<?php

if ( !function_exists('md_user_icon_file_add_line') ) {
    
    /**
     * The function md_user_icon_file_add_line gets the file_add_line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_file_add_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-file-add-line' . $class . '"></i>';

    }
    
}

/* End of file file_add_line.php */