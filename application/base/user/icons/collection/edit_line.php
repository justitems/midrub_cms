<?php

if ( !function_exists('md_user_icon_edit_line') ) {
    
    /**
     * The function md_user_icon_edit_line gets the ri-edit-2-line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_edit_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-edit-2-line' . $class . '"></i>';

    }
    
}

/* End of file edit_line.php */