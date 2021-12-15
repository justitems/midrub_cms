<?php

if ( !function_exists('md_user_icon_product') ) {
    
    /**
     * The function md_user_icon_product gets the product's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_product($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-inbox-unarchive-line' . $class . '"></i>';

    }
    
}

/* End of file product.php */