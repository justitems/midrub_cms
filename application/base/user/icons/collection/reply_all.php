<?php

if ( !function_exists('md_user_icon_reply_all') ) {
    
    /**
     * The function md_user_icon_reply_all gets the reply_all's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_reply_all($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'reply_all'
        . '</i>';

    }
    
}

/* End of file reply_all.php */