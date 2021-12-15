<?php

if ( !function_exists('md_user_icon_team_line') ) {
    
    /**
     * The function md_user_icon_team_line gets the team_line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_team_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-team-line' . $class . '"></i>';

    }
    
}

/* End of file team_line.php */