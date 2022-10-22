<?php

if ( !function_exists('md_user_icon_play') ) {
    
    /**
     * The function md_user_icon_play gets the play's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_play($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-play-circle-line' . $class . '"></i>';

    }
    
}

/* End of file play.php */