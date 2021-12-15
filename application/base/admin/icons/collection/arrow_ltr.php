<?php

if ( !function_exists('md_admin_icon_arrow_ltr') ) {
    
    /**
     * The function md_admin_icon_arrow_ltr gets the arrow_ltr's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_arrow_ltr($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:ios-arrow-ltr-24-filled"></i>';

    }
    
}

/* End of file arrow_ltr.php */