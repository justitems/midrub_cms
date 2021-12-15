<?php

if ( !function_exists('md_admin_icon_members_small') ) {
    
    /**
     * The function md_admin_icon_members_small gets the members_small's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_members_small($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:people-20-regular"></i>';

    }
    
}

/* End of file members_small.php */