<div class="theme-panel">
    <div class="theme-panel-body p-0">
        <ul class="profile-main-menu theme-panel-menu-list">
        <?php
        if ( md_the_frontend_settings_pages() ) {

            // Get frontend settings pages
            $the_frontend_settings_pages = md_the_frontend_settings_pages();

            // List all frontend settings pages
            for ($s = 0; $s < count($the_frontend_settings_pages); $s++) {

                // Get the page value
                $page = array_values($the_frontend_settings_pages[$s]);

                // Get page slug
                $page_slug = array_keys($the_frontend_settings_pages[$s]);

                // Active var
                $active = '';

                // Verify if is the current page
                if ( $page_slug[0] === md_the_data('frontend_settings_page') ) {
                    $active = ' class="theme-menu-item-active"';
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
    </div>
</div>