<?php

if ( !function_exists('md_user_icon_perm_phone_msg') ) {
    
    /**
     * The function md_user_icon_perm_phone_msg gets the perm_phone_msg's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_perm_phone_msg($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'perm_phone_msg'
        . '</i>';

    }
    
}

/* End of file perm_phone_msg.php */