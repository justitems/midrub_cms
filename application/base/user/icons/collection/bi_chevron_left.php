<?php

if ( !function_exists('md_user_icon_bi_chevron_left') ) {
    
    /**
     * The function md_user_icon_bi_chevron_left gets the bootstrap's chevron left icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_chevron_left($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left' . $class . '" viewBox="0 0 16 16">'
            . '<path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>'
        . '</svg>';

    }
    
}

/* End of file bi_chevron_left.php */