<?php

if ( !function_exists('md_user_icon_swap_box') ) {
    
    /**
     * The function md_user_icon_swap_box gets the swap_box's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_swap_box($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-swap-box-line' . $class . '"></i>';

    }
    
}

/* End of file swap_box.php */