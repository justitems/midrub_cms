<?php

if ( !function_exists('md_user_icon_select') ) {
    
    /**
     * The function md_user_icon_select gets the select's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_select($params) {

        // Set selectitional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'library_add_check'
        . '</i>';        

    }
    
}

/* End of file select.php */