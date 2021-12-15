<?php

if ( !function_exists('md_user_icon_mail_send') ) {
    
    /**
     * The function md_user_icon_mail_send gets the mail_send's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_mail_send($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-mail-send-line' . $class . '"></i>';

    }
    
}

/* End of file mail_send.php */