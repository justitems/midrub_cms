<?php

if ( !function_exists('md_admin_icon_quick_guide') ) {
    
    /**
     * The function md_admin_icon_quick_guide gets the quick_guide icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_quick_guide($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:book-question-mark-20-regular"></i>';

    }
    
}

/* End of file quick_guide.php */