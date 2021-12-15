<?php

if ( !function_exists('md_user_icon_assignment_turned_in') ) {
    
    /**
     * The function md_user_icon_assignment_turned_in gets the assignment_turned_in's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_assignment_turned_in($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'assignment_turned_in'
        . '</i>';

    }
    
}

/* End of file assignment_turned_in.php */