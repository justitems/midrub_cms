<?php

if ( !function_exists('md_user_icon_bi_plus') ) {
    
    /**
     * The function md_user_icon_bi_plus gets the bootstrap's plus circle icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_plus($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';
    
        // Return icon
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus' . $class . '" viewBox="0 0 16 16">'
            . '<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>'
        . '</svg>';        

    }
    
}

/* End of file bi_plus.php */