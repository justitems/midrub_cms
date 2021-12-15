<?php

if ( !function_exists('md_user_icon_inbox_archive_line') ) {
    
    /**
     * The function md_user_icon_inbox_archive_line gets the ri-inbox-archive-line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_inbox_archive_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-inbox-archive-line' . $class . '"></i>';

    }
    
}

/* End of file inbox_archive_line.php */