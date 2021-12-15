<?php

if ( !function_exists('md_admin_icon_faq') ) {
    
    /**
     * The function md_admin_icon_faq gets the faq's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_faq($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:question-circle-20-regular"></i>';

    }
    
}

/* End of file faq.php */