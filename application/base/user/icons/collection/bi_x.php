<?php

if ( !function_exists('md_user_icon_bi_x') ) {
    
    /**
     * The function md_user_icon_bi_x gets the bootstrap's x icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_x($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x' . $class . '" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
            . '<path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z" />'
            . '<path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z" />'
        . '</svg> ';

    }
    
}

/* End of file bi_x.php */