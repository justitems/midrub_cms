<?php

if ( !function_exists('md_user_icon_spellcheck') ) {
    
    /**
     * The function md_user_icon_spellcheck gets the spellcheck icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_spellcheck($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'spellcheck'
        . '</i>';

    }
    
}

/* End of file spellcheck.php */