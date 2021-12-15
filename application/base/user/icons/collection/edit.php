<?php

if ( !function_exists('md_user_icon_edit') ) {
    
    /**
     * The function md_user_icon_edit gets the edit's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_edit($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-edit-line' . $class . '"></i>';

    }
    
}

/* End of file edit.php */