<?php

if ( !function_exists('md_admin_icon_member_money') ) {
    
    /**
     * The function md_admin_icon_member_money gets the member_money's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_member_money($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:person-money-24-regular"></i>';

    }
    
}

/* End of file member_money.php */