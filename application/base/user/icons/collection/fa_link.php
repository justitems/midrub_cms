<?php

if ( !function_exists('md_user_icon_fa_link') ) {
    
    /**
     * The function md_user_icon_fa_link gets the fa_link's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_fa_link($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="fas fa-link' . $class . '"></i>';

    }
    
}

/* End of file fa_link.php */