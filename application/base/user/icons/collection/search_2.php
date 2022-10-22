<?php

if ( !function_exists('md_user_icon_search_2') ) {
    
    /**
     * The function md_user_icon_search_2 gets the search's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_search_2($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-search-2-line' . $class . '"></i>';

    }
    
}

/* End of file search_2.php */