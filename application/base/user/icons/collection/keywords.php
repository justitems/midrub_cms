<?php

if ( !function_exists('md_user_icon_keywords') ) {
    
    /**
     * The function md_user_icon_keywords gets the keywords icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_keywords($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'translate'
        . '</i>';

    }
    
}

/* End of file keywords.php */