<?php

if ( !function_exists('md_user_icon_alternate_email') ) {
    
    /**
     * The function md_user_icon_alternate_email gets the alternate email's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_alternate_email($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'alternate_email'
        . '</i>';

    }
    
}

/* End of file alternate_email.php */