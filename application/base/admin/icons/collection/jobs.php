<?php

if ( !function_exists('md_admin_icon_jobs') ) {
    
    /**
     * The function md_admin_icon_jobs gets the jobs icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_jobs($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:folder-person-20-regular"></i>';

    }
    
}

/* End of file jobs.php */