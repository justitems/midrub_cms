<?php

if ( !function_exists('md_user_icon_offline_bolt') ) {
    
    /**
     * The function md_user_icon_offline_bolt gets the offline_bolt's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_offline_bolt($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'offline_bolt'
        . '</i>';

    }
    
}

/* End of file offline_bolt.php */