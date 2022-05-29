<?php

if ( !function_exists('md_user_icon_account') ) {
    
    /**
     * The function md_user_icon_account gets the account icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_account($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-account-circle-line' . $class . '"></i>';

    }
    
}

/* End of file account.php */