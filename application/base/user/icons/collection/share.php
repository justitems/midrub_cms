<?php

if ( !function_exists('md_user_icon_share') ) {
    
    /**
     * The function md_user_icon_share gets the chat line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_share($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-share-forward-line' . $class . '"></i>';

    }
    
}

/* End of file share.php */