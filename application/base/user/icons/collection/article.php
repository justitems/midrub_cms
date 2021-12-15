<?php

if ( !function_exists('md_user_icon_article') ) {
    
    /**
     * The function md_user_icon_article gets the article's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_article($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-article-line' . $class . '"></i>';

    }
    
}

/* End of file article.php */