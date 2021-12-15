<?php

if ( !function_exists('md_user_icon_drag_indicator') ) {
    
    /**
     * The function md_user_icon_drag_indicator gets the drag_indicator's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_drag_indicator($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'drag_indicator'
        . '</i>';

    }
    
}

/* End of file drag_indicator.php */