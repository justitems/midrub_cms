<?php

if ( !function_exists('md_admin_icon_sms') ) {
    
    /**
     * The function md_admin_icon_sms gets the sms's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_sms($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:mail-list-28-regular"></i>';

    }
    
}

/* End of file sms.php */