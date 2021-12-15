<?php

if ( !function_exists('md_admin_icon_sync') ) {
    
    /**
     * The function md_admin_icon_sync gets the sync's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_sync($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:arrow-sync-20-filled"></i>';

    }
    
}

/* End of file sync.php */