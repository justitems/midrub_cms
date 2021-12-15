<?php

if ( !function_exists('md_user_icon_highlight') ) {
    
    /**
     * The function md_user_icon_highlight gets the highlight's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_highlight($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'highlight'
        . '</i>';

    }
    
}

/* End of file highlight.php */