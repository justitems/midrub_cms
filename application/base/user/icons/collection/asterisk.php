<?php

if ( !function_exists('md_user_icon_asterisk') ) {
    
    /**
     * The function md_user_icon_asterisk gets the asterisk's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_asterisk($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-asterisk' . $class . '"></i>';

    }
    
}

/* End of file asterisk.php */