<?php

if ( !function_exists('md_user_icon_child') ) {
    
    /**
     * The function md_user_icon_child gets the child's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_child($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'child_care'
        . '</i>';

    }
    
}

/* End of file child.php */