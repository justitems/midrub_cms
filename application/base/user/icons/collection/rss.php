<?php

if ( !function_exists('md_user_icon_rss') ) {
    
    /**
     * The function md_user_icon_rss gets the rss's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_rss($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-rss-line' . $class . '"></i>';

    }
    
}

/* End of file rss.php */