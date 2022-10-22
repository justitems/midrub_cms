<?php

if ( !function_exists('md_user_icon_planification') ) {
    
    /**
     * The function md_user_icon_planification gets the planification's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_planification($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-calendar-2-line' . $class . '"></i>';

    }
    
}

/* End of file planification.php */