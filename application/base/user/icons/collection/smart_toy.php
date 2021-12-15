<?php

if ( !function_exists('md_user_icon_smart_toy') ) {
    
    /**
     * The function md_user_icon_smart_toy gets the alternate email's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_smart_toy($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'smart_toy'
        . '</i>';

    }
    
}

/* End of file smart_toy.php */