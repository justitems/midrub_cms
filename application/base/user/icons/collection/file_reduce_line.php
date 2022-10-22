<?php

if ( !function_exists('md_user_icon_file_reduce_line') ) {
    
    /**
     * The function md_user_icon_file_reduce_line gets the file_reduce_line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_file_reduce_line($params) {

        // Set reduceitional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-file-reduce-line' . $class . '"></i>';

    }
    
}

/* End of file file_reduce_line.php */