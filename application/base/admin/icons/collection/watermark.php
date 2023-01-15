<?php

if ( !function_exists('md_admin_icon_watermark') ) {
    
    /**
     * The function md_admin_icon_watermark gets the watermark's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_watermark($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:image-alt-text-16-regular"></i>';

    }
    
}

/* End of file watermark.php */