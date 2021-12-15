<?php

if ( !function_exists('md_user_icon_sound_module') ) {
    
    /**
     * The function md_user_icon_sound_module gets the sound_module's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_sound_module($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-sound-module-line' . $class . '"></i>';

    }
    
}

/* End of file sound_module.php */