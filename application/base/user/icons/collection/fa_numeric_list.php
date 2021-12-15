<?php

if ( !function_exists('md_user_icon_fa_numeric_list') ) {
    
    /**
     * The function md_user_icon_fa_numeric_list gets the fa_numeric_list's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_fa_numeric_list($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="fas fa-list-ol' . $class . '"></i>';

    }
    
}

/* End of file fa_numeric_list.php */