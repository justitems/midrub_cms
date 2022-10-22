<?php

if ( !function_exists('md_user_icon_bi_arrow_right_short') ) {
    
    /**
     * The function md_user_icon_bi_arrow_right_short gets the bi_arrow_right_short's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_arrow_right_short($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short' . $class . '" viewBox="0 0 16 16">'
            . '<path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>'
        . '</svg>';

    }
    
}

/* End of file bi_arrow_right_short.php */