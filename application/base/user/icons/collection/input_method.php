<?php

if ( !function_exists('md_user_icon_input_method') ) {
    
    /**
     * The function md_user_icon_input_method gets the input_method's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_input_method($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-input-method-line' . $class . '"></i>';

    }
    
}

/* End of file input_method.php */