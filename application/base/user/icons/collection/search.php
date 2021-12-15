<?php

if ( !function_exists('md_user_icon_search') ) {
    
    /**
     * The function md_user_icon_search gets the search's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_search($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-search-line' . $class . '"></i>';

    }
    
}

/* End of file search.php */