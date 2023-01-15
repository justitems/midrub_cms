<?php

if ( !function_exists('md_user_icon_drag_move_fill') ) {
    
    /**
     * The function md_user_icon_drag_move_fill gets the drag_move_fill's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_drag_move_fill($params) {

        // Set drag_move_fillitional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-drag-move-fill' . $class . '"></i>';

    }
    
}

/* End of file drag_move_fill.php */