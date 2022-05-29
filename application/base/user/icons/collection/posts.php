<?php

if ( !function_exists('md_user_icon_posts') ) {
    
    /**
     * The function md_user_icon_posts gets the posts's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_posts($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'backup_table'
        . '</i>';

    }
    
}

/* End of file posts.php */