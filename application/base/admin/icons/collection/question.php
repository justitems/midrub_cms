<?php

if ( !function_exists('md_admin_icon_question') ) {
    
    /**
     * The function md_admin_icon_question gets the question icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_question($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:chat-bubbles-question-20-regular"></i>';

    }
    
}

/* End of file question.php */