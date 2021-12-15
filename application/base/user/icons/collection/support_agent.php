<?php

if ( !function_exists('md_user_icon_support_agent') ) {
    
    /**
     * The function md_user_icon_support_agent gets the support_agent's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_support_agent($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'support_agent'
        . '</i>';

    }
    
}

/* End of file support_agent.php */