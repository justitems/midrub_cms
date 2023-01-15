<?php

if ( !function_exists('md_user_icon_bi_align_bottom') ) {
    
    /**
     * The function md_user_icon_bi_align_bottom gets the bi_align_bottom's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_align_bottom($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-align-bottom' . $class . '" viewBox="0 0 16 16">'
            . '<rect width="4" height="12" x="6" y="1" rx="1"/>'
            . '<path d="M1.5 14a.5.5 0 0 0 0 1v-1zm13 1a.5.5 0 0 0 0-1v1zm-13 0h13v-1h-13v1z"/>'
        . '</svg>';

    }
    
}

/* End of file bi_align_bottom.php */