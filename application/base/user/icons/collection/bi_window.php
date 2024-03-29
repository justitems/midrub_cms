<?php

if ( !function_exists('md_user_icon_bi_window') ) {
    
    /**
     * The function md_user_icon_bi_window gets the bootstrap's window icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_window($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-window' . $class . '" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
            . '<path fill-rule="evenodd" d="M14 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>'
            . '<path fill-rule="evenodd" d="M15 6H1V5h14v1z"/>'
            . '<path d="M3 3.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm1.5 0a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm1.5 0a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>'
        . '</svg>';

    }
    
}

/* End of file bi_window.php */