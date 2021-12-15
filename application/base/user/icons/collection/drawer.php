<?php

if ( !function_exists('md_user_icon_drawer') ) {
    
    /**
     * The function md_user_icon_drawer gets the drawer's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_drawer($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-archive-drawer-line' . $class . '"></i>';

    }
    
}

/* End of file drawer.php */