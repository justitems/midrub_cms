<?php

if ( !function_exists('md_admin_icon_member_add') ) {
    
    /**
     * The function md_admin_icon_member_add gets the member_add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_member_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:people-add-20-regular"></i>';

    }
    
}

/* End of file member_add.php */