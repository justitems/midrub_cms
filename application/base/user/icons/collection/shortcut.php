<?php

if ( !function_exists('md_user_icon_shortcut') ) {
    
    /**
     * The function md_user_icon_shortcut gets the chat line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_shortcut($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'shortcut'
        . '</i>';

    }
    
}

/* End of file shortcut.php */