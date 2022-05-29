<?php

if ( !function_exists('md_user_icon_inbox') ) {
    
    /**
     * The function md_user_icon_inbox gets the inbox's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_inbox($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-inbox-line' . $class . '"></i>';

    }
    
}

/* End of file inbox.php */