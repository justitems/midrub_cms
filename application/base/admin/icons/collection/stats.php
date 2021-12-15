<?php

if ( !function_exists('md_admin_icon_stats') ) {
    
    /**
     * The function md_admin_icon_stats gets the stats's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_stats($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:arrow-trending-lines-20-regular"></i>';

    }
    
}

/* End of file stats.php */