<?php

if ( !function_exists('md_admin_icon_list') ) {
    
    /**
     * The function md_admin_icon_list gets the list's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_list($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:list-16-regular"></i>';

    }
    
}

/* End of file list.php */