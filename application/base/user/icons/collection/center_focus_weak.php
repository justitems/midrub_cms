<?php

if ( !function_exists('md_user_icon_center_focus_weak') ) {
    
    /**
     * The function md_user_icon_center_focus_weak gets the center_focus_weak's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_center_focus_weak($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'center_focus_weak'
        . '</i>';

    }
    
}

/* End of file center_focus_weak.php */