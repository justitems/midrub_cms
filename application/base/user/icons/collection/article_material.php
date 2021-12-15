<?php

if ( !function_exists('md_user_icon_article_material') ) {
    
    /**
     * The function md_user_icon_article_material gets the article_material's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_article_material($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'article'
        . '</i>';

    }
    
}

/* End of file article_material.php */