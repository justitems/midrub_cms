<?php

if ( !function_exists('md_admin_icon_person_photo') ) {
    
    /**
     * The function md_admin_icon_person_photo gets the person photo's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_person_photo($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:resize-image-24-regular"></i>';

    }
    
}