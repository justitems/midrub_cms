<?php

if ( !function_exists('md_user_icon_terminal') ) {
    
    /**
     * The function md_user_icon_terminal gets the terminal's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_terminal($params) {

        // Set terminal class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-terminal-line' . $class . '"></i>';

    }
    
}

/* End of file terminal.php */