<?php

if ( !function_exists('md_user_icon_bookmark_add') ) {
    
    /**
     * The function md_user_icon_bookmark_add gets the bookmark add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bookmark_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'bookmark_add'
        . '</i>';

    }
    
}

/* End of file bookmark_add.php */