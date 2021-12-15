<?php

if ( !function_exists('md_admin_icon_browse') ) {
    
    /**
     * The function md_admin_icon_browse gets the browse's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_browse($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:slide-multiple-search-20-regular"></i>';

    }
    
}

/* End of file browse.php */