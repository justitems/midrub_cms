<?php

if ( !function_exists('md_admin_icon_send') ) {
    
    /**
     * The function md_admin_icon_send gets the send's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_send($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:send-20-regular"></i>';

    }
    
}

/* End of file send.php */