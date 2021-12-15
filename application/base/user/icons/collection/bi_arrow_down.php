<?php

if ( !function_exists('md_user_icon_bi_arrow_down') ) {
    
    /**
     * The function md_user_icon_bi_arrow_down gets the bootstrap's arrow down icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_arrow_down($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down-square' . $class . '" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
            . '<path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>'
            . '<path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"></path>'
        . '</svg>';

    }
    
}

/* End of file bi_arrow_down.php */