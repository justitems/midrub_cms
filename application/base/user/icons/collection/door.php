<?php

if ( !function_exists('md_user_icon_door') ) {
    
    /**
     * The function md_user_icon_door gets the door's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_door($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-door-lock-box-line' . $class . '"></i>';

    }
    
}

/* End of file door.php */