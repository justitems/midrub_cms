<?php

if ( !function_exists('md_user_icon_wechat') ) {
    
    /**
     * The function md_user_icon_wechat gets the wechat's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_wechat($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-wechat-line' . $class . '"></i>';

    }
    
}

/* End of file wechat.php */