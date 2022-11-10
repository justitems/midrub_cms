<?php

if ( !function_exists('md_user_icon_chart_line') ) {
    
    /**
     * The function md_user_icon_chart_line gets the chart_line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_chart_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-donut-chart-line' . $class . '"></i>';

    }
    
}

/* End of file chart_line.php */