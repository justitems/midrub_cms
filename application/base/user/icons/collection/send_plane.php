<?php

if ( !function_exists('md_user_icon_send_plane') ) {
    
    /**
     * The function md_user_icon_send_plane gets the grid fill's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_send_plane($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-send-plane-2-line' . $class . '"></i>';

    }
    
}

/* End of file send_plane.php */