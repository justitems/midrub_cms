<?php

if ( !function_exists('md_admin_icon_cron_job') ) {
    
    /**
     * The function md_admin_icon_cron_job gets the cron_job's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_cron_job($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:clock-arrow-download-20-regular"></i>';

    }
    
}

/* End of file cron_job.php */