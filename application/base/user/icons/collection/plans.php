<?php

if ( !function_exists('md_user_icon_plans') ) {
    
    /**
     * The function md_user_icon_plans gets the plans's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_plans($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-shopping-bag-2-line' . $class . '"></i>';

    }
    
}

/* End of file plans.php */