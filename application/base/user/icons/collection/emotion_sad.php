<?php

if ( !function_exists('md_user_icon_emotion_sad') ) {
    
    /**
     * The function md_user_icon_emotion_sad gets the emotion_sad's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_emotion_sad($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-emotion-sad-line' . $class . '"></i>';

    }
    
}

/* End of file emotion_sad.php */