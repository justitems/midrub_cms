<ul class="nav nav-pills nav-stacked labels-info">
    <?php
    if ( the_frontend_settings_pages() ) {

        // Get frontend settings pages
        $the_frontend_settings_pages = the_frontend_settings_pages();

        // List all frontend settings pages
        for ($s = 0; $s < count($the_frontend_settings_pages); $s++) {

            // Get the page value
            $page = array_values($the_frontend_settings_pages[$s]);

            // Get page slug
            $page_slug = array_keys($the_frontend_settings_pages[$s]);

            // Active var
            $active = '';

            // Verify if is the current page
            if ( $page_slug[0] === the_global_variable('frontend_settings_page') ) {
                $active = ' class="active"';
            }

            // Display page's link
            echo '<li' . $active . '>'
                    . '<a href="' . site_url('admin/frontend?p=settings&s=' . $page_slug[0] . '&group=frontend_page') . '">'
                        . $page[0]['page_icon']
                        . $page[0]['page_name']                        
                    . '</a>'
                . '</li>';

        }
    }
    ?>
</ul>