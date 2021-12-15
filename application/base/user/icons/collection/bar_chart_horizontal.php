<?php

if ( !function_exists('md_user_icon_bar_chart_horizontal') ) {
    
    /**
     * The function md_user_icon_bar_chart_horizontal gets the bar_chart_horizontal's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bar_chart_horizontal($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-bar-chart-horizontal-line' . $class . '"></i>';

    }
    
}

/* End of file bar_chart_horizontal.php */