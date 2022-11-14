<?php

if ( !function_exists('md_admin_icon_image_edit') ) {
    
    /**
     * The function md_admin_icon_image_edit gets the image_edit's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_image_edit($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:image-edit-16-regular"></i>';

    }
    
}

/* End of file image_edit.php */