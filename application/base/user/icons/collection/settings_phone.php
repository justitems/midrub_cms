<?php
if ( !function_exists('md_user_icon_settings_phone') ) {
    
    /**
     * The function md_user_icon_settings_phone gets the settings phone's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_settings_phone($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'settings_phone'
        . '</i>';

    }
    
}

/* End of file settings_phone.php */