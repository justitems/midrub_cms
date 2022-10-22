<?php

if ( !function_exists('md_user_icon_send_plane_line') ) {
    
    /**
     * The function md_user_icon_send_plane_line gets the send plane's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_send_plane_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-send-plane-line' . $class . '"></i>';

    }
    
}

/* End of file send_plane_line.php */