<ul>
    <?php
    if ( md_the_user_pages() ) {

        // Get user_pages array
        $user_pages = md_the_user_pages();

        for ($c = 0; $c < count($user_pages); $c++) {

            // Get the page value
            $page = array_values($user_pages[$c]);

            // Get page slug
            $page_slug = array_keys($user_pages[$c]);

            $active = '';

            if ( ($this->input->get('p', true) === $page_slug[0]) || ($c < 1 && !$this->input->get('p', true) ) ) {
                $active = ' class="active"';
            }

            // Display page
            echo '<li>
                <a href="' . site_url('admin/user?p=' . $page_slug[0]) . '"' . $active . '>
                    ' . $page[0]['page_icon'] . '
                    ' . $page[0]['page_name'] . '
                </a>
            </li>';
        }
    }
    ?>
</ul>