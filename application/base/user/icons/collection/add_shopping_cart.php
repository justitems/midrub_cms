<?php

if ( !function_exists('md_user_icon_add_shopping_cart') ) {
    
    /**
     * The function md_user_icon_add_shopping_cart gets the add_shopping_cart's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_add_shopping_cart($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'add_shopping_cart'
        . '</i>';

    }
    
}

/* End of file add_shopping_cart.php */