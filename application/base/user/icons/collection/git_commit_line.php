<?php

if ( !function_exists('md_user_icon_git_commit_line') ) {
    
    /**
     * The function md_user_icon_git_commit_line gets the ri-git-commit-line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_git_commit_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-git-commit-line' . $class . '"></i>';

    }
    
}

/* End of file git_commit_line.php */