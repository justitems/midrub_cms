<?php

if ( !function_exists('md_user_icon_newspaper') ) {
    
    /**
     * The function md_user_icon_newspaper gets the newspaper's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_newspaper($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-newspaper-line' . $class . '"></i>';

    }
    
}

/* End of file newspaper.php */