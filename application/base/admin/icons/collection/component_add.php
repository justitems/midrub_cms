<?php

if ( !function_exists('md_admin_icon_component_add') ) {
    
    /**
     * The function md_admin_icon_component_add gets the component_add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_component_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:mail-inbox-add-28-regular"></i>';

    }
    
}

/* End of file component_add.php */