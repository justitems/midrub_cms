<?php

if ( !function_exists('md_admin_icon_close') ) {
    
    /**
     * The function md_admin_icon_close gets the close's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_close($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:pane-close-16-regular"></i>';

    }
    
}

/* End of file close.php */