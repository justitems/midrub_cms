<?php

if ( !function_exists('md_admin_icon_new_plan') ) {
    
    /**
     * The function md_admin_icon_new_plan gets the new_plan's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_new_plan($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:receipt-add-24-regular"></i>';

    }
    
}

/* End of file new_plan.php */