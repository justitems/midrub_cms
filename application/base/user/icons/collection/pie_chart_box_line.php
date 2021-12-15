<?php

if ( !function_exists('md_user_icon_pie_chart_box_line') ) {
    
    /**
     * The function md_user_icon_pie_chart_box_line gets the ri-pie-chart-box-line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_pie_chart_box_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-pie-chart-box-line' . $class . '"></i>';

    }
    
}

/* End of file pie_chart_box_line.php */