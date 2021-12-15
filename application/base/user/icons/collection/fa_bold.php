<?php

if ( !function_exists('md_user_icon_fa_bold') ) {
    
    /**
     * The function md_user_icon_fa_bold gets the fa_bold's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_fa_bold($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="fas fa-bold' . $class . '"></i>';

    }
    
}

/* End of file fa_bold.php */