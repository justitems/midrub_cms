<?php

if ( !function_exists('md_user_icon_fa_align_justify') ) {
    
    /**
     * The function md_user_icon_fa_align_justify gets the fa_align_justify's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_fa_align_justify($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="fas fa-align-justify' . $class . '"></i>';

    }
    
}

/* End of file fa_align_justify.php */