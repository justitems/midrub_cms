<?php

if ( !function_exists('md_user_icon_bi_hdd_stack') ) {
    
    /**
     * The function md_user_icon_bi_hdd_stack gets the bi_hdd_stack's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_hdd_stack($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-hdd-stack' . $class . '" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
            . '<path fill-rule="evenodd" d="M14 10H2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1zM2 9a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1a2 2 0 0 0-2-2H2z" />'
            . '<path d="M5 11.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm-2 0a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />'
            . '<path fill-rule="evenodd" d="M14 3H2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM2 2a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z" />'
            . '<path d="M5 4.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm-2 0a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />'
        . '</svg>';

    }
    
}

/* End of file bi_hdd_stack.php */