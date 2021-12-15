<?php

if ( !function_exists('md_user_icon_keyboard_tab') ) {
    
    /**
     * The function md_user_icon_keyboard_tab gets the keyboard_tab's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_keyboard_tab($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'keyboard_tab'
        . '</i>';

    }
    
}

/* End of file keyboard_tab.php */