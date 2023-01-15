<?php

if ( !function_exists('md_user_icon_bi_align_top') ) {
    
    /**
     * The function md_user_icon_bi_align_top gets the bi_align_top's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_align_top($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-align-top' . $class . '" viewBox="0 0 16 16">'
            . '<rect width="4" height="12" rx="1" transform="matrix(1 0 0 -1 6 15)" />'
            . '<path d="M1.5 2a.5.5 0 0 1 0-1v1zm13-1a.5.5 0 0 1 0 1V1zm-13 0h13v1h-13V1z" />'
        . '</svg>';

    }
    
}

/* End of file bi_align_top.php */