<?php

if ( !function_exists('md_user_icon_folder_special') ) {
    
    /**
     * The function md_user_icon_folder_special gets the folder_special's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_folder_special($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'folder_special'
        . '</i>';

    }
    
}

/* End of file folder_special.php */