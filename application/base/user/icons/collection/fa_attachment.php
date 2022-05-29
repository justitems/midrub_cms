<?php

if ( !function_exists('md_user_icon_fa_attachment') ) {
    
    /**
     * The function md_user_icon_fa_attachment gets the fa_attachment's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_fa_attachment($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="fas fa-paperclip' . $class . '"></i>';

    }
    
}

/* End of file fa_attachment.php */