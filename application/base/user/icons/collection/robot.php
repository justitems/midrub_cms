<?php

if ( !function_exists('md_user_icon_robot') ) {
    
    /**
     * The function md_user_icon_robot gets the robot's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_robot($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-robot-line' . $class . '"></i>';

    }
    
}

/* End of file robot.php */