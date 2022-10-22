<?php

if ( !function_exists('md_user_icon_bi_arrow_left_short') ) {
    
    /**
     * The function md_user_icon_bi_arrow_left_short gets the bi_arrow_left_short's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_arrow_left_short($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short' . $class . '" viewBox="0 0 16 16">'
            . '<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>'
        . '</svg>';

    }
    
}

/* End of file bi_arrow_left_short.php */