<?php

if ( !function_exists('md_user_icon_folder_chart_2') ) {
    
    /**
     * The function md_user_icon_folder_chart_2 gets the folder_chart_2's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_folder_chart_2($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-folder-chart-2-line' . $class . '"></i>';

    }
    
}

/* End of file folder_chart_2.php */