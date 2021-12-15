<?php

if ( !function_exists('md_user_icon_fa_unlink') ) {
    
    /**
     * The function md_user_icon_fa_unlink gets the fa_unlink's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_fa_unlink($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="fas fa-unlink' . $class . '"></i>';

    }
    
}

/* End of file fa_unlink.php */