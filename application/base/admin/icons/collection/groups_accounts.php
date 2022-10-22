<?php

if ( !function_exists('md_admin_icon_groups_accounts') ) {
    
    /**
     * The function md_admin_icon_groups_accounts gets the groups_accounts's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_groups_accounts($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:folder-people-20-regular"></i>';

    }
    
}

/* End of file groups_accounts.php */