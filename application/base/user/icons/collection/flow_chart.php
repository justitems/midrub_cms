<?php

if ( !function_exists('md_user_icon_flow_chart') ) {
    
    /**
     * The function md_user_icon_flow_chart gets the flow_chart's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_flow_chart($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-flow-chart' . $class . '"></i>';

    }
    
}

/* End of file flow_chart.php */