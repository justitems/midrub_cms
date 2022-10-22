<?php

if ( !function_exists('md_user_icon_play_list') ) {
    
    /**
     * The function md_user_icon_play_list gets the play_list's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_play_list($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-play-list-2-fill' . $class . '"></i>';

    }
    
}

/* End of file play_list.php */