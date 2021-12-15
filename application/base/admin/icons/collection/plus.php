<?php

if ( !function_exists('md_admin_icon_plus') ) {
    
    /**
     * The function md_admin_icon_plus gets the plus's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_plus($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:add-square-multiple-20-regular"></i>';

    }
    
}

/* End of file plus.php */