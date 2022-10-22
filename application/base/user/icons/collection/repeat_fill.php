<?php

if ( !function_exists('md_user_icon_repeat_fill') ) {
    
    /**
     * The function md_user_icon_repeat_fill gets the repeat_fill's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_repeat_fill($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-repeat-fill' . $class . '"></i>';

    }
    
}

/* End of file repeat_fill.php */