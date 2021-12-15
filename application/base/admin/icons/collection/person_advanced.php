<?php

if ( !function_exists('md_admin_icon_person_advanced') ) {
    
    /**
     * The function md_admin_icon_person_advanced gets the person advanced's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_person_advanced($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:book-contacts-28-regular"></i>';

    }
    
}

/* End of file person_advanced.php */