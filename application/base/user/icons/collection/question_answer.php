<?php

if ( !function_exists('md_user_icon_question_answer') ) {
    
    /**
     * The function md_user_icon_question_answer gets the question answer's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_question_answer($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'question_answer'
        . '</i>';

    }
    
}

/* End of file question_answer.php */