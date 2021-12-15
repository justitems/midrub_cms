<?php

if ( !function_exists('md_admin_icon_sign_out') ) {
    
    /**
     * The function md_admin_icon_sign_out gets the sign_out's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_sign_out($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:sign-out-20-regular"></i>';

    }
    
}

/* End of file sign_out.php */