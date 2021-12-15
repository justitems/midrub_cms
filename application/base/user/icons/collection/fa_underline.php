<?php

if ( !function_exists('md_user_icon_fa_underline') ) {
    
    /**
     * The function md_user_icon_fa_underline gets the fa_underline's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_fa_underline($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="fas fa-underline' . $class . '"></i>';

    }
    
}

/* End of file fa_underline.php */