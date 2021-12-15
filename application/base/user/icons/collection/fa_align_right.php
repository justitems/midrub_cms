<?php

if ( !function_exists('md_user_icon_fa_align_right') ) {
    
    /**
     * The function md_user_icon_fa_align_right gets the fa_align_right's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_fa_align_right($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="fas fa-align-right' . $class . '"></i>';

    }
    
}

/* End of file fa_align_right.php */