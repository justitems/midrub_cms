<?php

if ( !function_exists('md_user_icon_stack') ) {
    
    /**
     * The function md_user_icon_stack gets the stack's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_stack($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-stack-line' . $class . '"></i>';

    }
    
}

/* End of file stack.php */