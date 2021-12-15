<?php

if ( !function_exists('md_admin_icon_clock') ) {
    
    /**
     * The function md_admin_icon_clock gets the clock's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_clock($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:clock-48-regular"></i>';

    }
    
}

/* End of file clock.php */