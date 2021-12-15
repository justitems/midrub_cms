<?php

if ( !function_exists('md_user_icon_collections') ) {
    
    /**
     * The function md_user_icon_collections gets the collections's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_collections($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'collections'
        . '</i>';

    }
    
}

/* End of file collections.php */