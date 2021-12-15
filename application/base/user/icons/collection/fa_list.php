<?php

if ( !function_exists('md_user_icon_fa_list') ) {
    
    /**
     * The function md_user_icon_fa_list gets the fa_list's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_fa_list($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="fas fa-list' . $class . '"></i>';

    }
    
}

/* End of file fa_list.php */