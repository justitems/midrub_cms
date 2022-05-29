<?php

if ( !function_exists('md_user_icon_bi_infinity') ) {
    
    /**
     * The function md_user_icon_bi_infinity gets the bootstrap's infinity icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_bi_infinity($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';
        
        // Return icon
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-infinity' . $class . '" viewBox="0 0 16 16">'
            . '<path d="M5.68 5.792 7.345 7.75 5.681 9.708a2.75 2.75 0 1 1 0-3.916ZM8 6.978 6.416 5.113l-.014-.015a3.75 3.75 0 1 0 0 5.304l.014-.015L8 8.522l1.584 1.865.014.015a3.75 3.75 0 1 0 0-5.304l-.014.015L8 6.978Zm.656.772 1.663-1.958a2.75 2.75 0 1 1 0 3.916L8.656 7.75Z"/>'
        . '</svg>'; 

    }
    
}

/* End of file bi_infinity.php */