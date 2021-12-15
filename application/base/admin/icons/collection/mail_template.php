<?php

if ( !function_exists('md_admin_icon_mail_template') ) {
    
    /**
     * The function md_admin_icon_mail_template gets the mail_template's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_mail_template($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:mail-template-20-regular"></i>';

    }
    
}

/* End of file mail_template.php */