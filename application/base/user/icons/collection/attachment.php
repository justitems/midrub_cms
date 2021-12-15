<?php

if ( !function_exists('md_user_icon_attachment') ) {
    
    /**
     * The function md_user_icon_attachment gets the attachment's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_attachment($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-attachment-2' . $class . '"></i>';

    }
    
}

/* End of file attachment.php */