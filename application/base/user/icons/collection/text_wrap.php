<?php

if ( !function_exists('md_user_icon_text_wrap') ) {
    
    /**
     * The function md_user_icon_text_wrap gets the text_wrap's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_text_wrap($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-text-wrap' . $class . '"></i>';

    }
    
}

/* End of file text_wrap.php */