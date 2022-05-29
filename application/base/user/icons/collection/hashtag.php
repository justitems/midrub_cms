<?php

if ( !function_exists('md_user_icon_hashtag') ) {
    
    /**
     * The function md_user_icon_hashtag gets the hashtag's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_hashtag($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-hashtag' . $class . '"></i>';

    }
    
}

/* End of file hashtag.php */