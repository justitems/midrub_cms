<?php

if ( !function_exists('md_user_icon_node_tree') ) {
    
    /**
     * The function md_user_icon_node_tree gets the node tree's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_node_tree($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-node-tree' . $class . '"></i>';

    }
    
}

/* End of file node_tree.php */