<?php

if ( !function_exists('md_user_icon_bi_tiktok') ) {
    
    /**
     * The function md_user_icon_bi_tiktok gets the bootstrap's tiktok icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_tiktok($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tiktok' . $class . '" viewBox="0 0 16 16">'
            . '<path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z"/>'
        . '</svg>';        

    }
    
}

/* End of file bi_tiktok.php */