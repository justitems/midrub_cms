<?php

if ( !function_exists('md_user_icon_read_more') ) {
    
    /**
     * The function md_user_icon_read_more gets the alternate email's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_read_more($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'read_more'
        . '</i>';

    }
    
}

/* End of file read_more.php */