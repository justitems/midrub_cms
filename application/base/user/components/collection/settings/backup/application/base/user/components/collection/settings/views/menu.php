<ul class="nav nav-tabs">
    <?php
    if ( the_user_settings_pages() ) {

        // Get settings's pages
        $user_pages = the_user_settings_pages();

        // List all pages
        for ($c = 0; $c < count($user_pages); $c++) {

            // Get the page value
            $page = array_values($user_pages[$c]);

            // Get page slug
            $page_slug = array_keys($user_pages[$c]);

            // Active var
            $active = '';

            // Verify if is the current page
            if ( ($this->input->get('p', true) === $page_slug[0]) || ($c < 1 && !$this->input->get('p', true) ) ) {
                $active = ' active show';
            }

            // Display page's link
            echo '<li class="nav-item">'
                    . '<a href="' . site_url('user/settings?p=' . $page_slug[0]) . '" class="nav-link' . $active . '">'
                        . $page[0]['page_icon']
                        . $page[0]['page_name']
                    . '</a>'
                . '</li>';

        }
    }
    ?>
</ul>