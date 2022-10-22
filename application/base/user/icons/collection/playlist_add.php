<?php

if ( !function_exists('md_user_icon_playlist_add') ) {
    
    /**
     * The function md_user_icon_playlist_add gets the playlist_add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_playlist_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-play-list-add-fill' . $class . '"></i>';

    }
    
}

/* End of file playlist_add.php */