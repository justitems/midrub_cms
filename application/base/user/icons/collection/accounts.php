<?php

if ( !function_exists('md_user_icon_accounts') ) {
    
    /**
     * The function md_user_icon_accounts gets the accounts icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_accounts($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-group-2-line' . $class . '"></i>';

    }
    
}

/* End of file accounts.php */