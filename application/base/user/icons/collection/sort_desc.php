<?php

if ( !function_exists('md_user_icon_sort_desc') ) {
    
    /**
     * The function md_user_icon_sort_desc gets the sort_desc's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_sort_desc($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-sort-desc' . $class . '"></i>';

    }
    
}

/* End of file sort_desc.php */