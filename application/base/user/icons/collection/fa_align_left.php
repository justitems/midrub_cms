<?php

if ( !function_exists('md_user_icon_fa_align_left') ) {
    
    /**
     * The function md_user_icon_fa_align_left gets the fa_align_left's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_fa_align_left($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="fas fa-align-left' . $class . '"></i>';

    }
    
}

/* End of file fa_align_left.php */