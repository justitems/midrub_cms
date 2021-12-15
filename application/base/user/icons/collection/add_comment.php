<?php

if ( !function_exists('md_user_icon_add_comment') ) {
    
    /**
     * The function md_user_icon_add_comment gets the add_comment's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_add_comment($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'add_comment'
        . '</i>';

    }
    
}

/* End of file add_comment.php */