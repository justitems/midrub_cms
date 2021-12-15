<?php

if ( !function_exists('md_user_icon_delete_bin') ) {
    
    /**
     * The function md_user_icon_delete_bin gets the delete_bin's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_delete_bin($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-delete-bin-line' . $class . '"></i>';

    }
    
}

/* End of file delete_bin.php */