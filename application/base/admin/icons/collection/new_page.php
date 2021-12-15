<?php

if ( !function_exists('md_admin_icon_new_page') ) {
    
    /**
     * The function md_admin_icon_new_page gets the new_page's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_new_page($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:document-add-16-regular"></i>';

    }
    
}

/* End of file new_page.php */