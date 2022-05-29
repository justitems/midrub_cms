<?php

if ( !function_exists('md_user_icon_media') ) {
    
    /**
     * The function md_user_icon_media gets the media's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_media($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'perm_media'
        . '</i>';

    }
    
}

/* End of file media.php */