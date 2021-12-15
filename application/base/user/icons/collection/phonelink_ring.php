<?php

if ( !function_exists('md_user_icon_phonelink_ring') ) {
    
    /**
     * The function md_user_icon_phonelink_ring gets the phonelink_ring's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_phonelink_ring($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'phonelink_ring'
        . '</i>';

    }
    
}

/* End of file phonelink_ring.php */