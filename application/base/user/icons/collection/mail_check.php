<?php

if ( !function_exists('md_user_icon_mail_check') ) {
    
    /**
     * The function md_user_icon_mail_check gets the mail_check's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_mail_check($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-mail-check-line' . $class . '"></i>';

    }
    
}

/* End of file mail_check.php */