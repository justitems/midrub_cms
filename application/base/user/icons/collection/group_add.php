<?php

if ( !function_exists('md_user_icon_group_add') ) {
    
    /**
     * The function md_user_icon_group_add gets the group add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_group_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'group_add'
        . '</i>';

    }
    
}

/* End of file group_add.php */