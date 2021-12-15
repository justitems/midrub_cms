<?php

if ( !function_exists('md_admin_icon_enable') ) {
    
    /**
     * The function md_admin_icon_enable gets the enable's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_enable($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:calendar-checkmark-20-regular"></i>';

    }
    
}

/* End of file enable.php */