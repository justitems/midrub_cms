<ul>
    <?php
    if ( md_the_admin_pages() ) {

        // Get admin_pages array
        $admin_pages = md_the_admin_pages();

        for ($c = 0; $c < count($admin_pages); $c++) {

            // Get the page value
            $page = array_values($admin_pages[$c]);

            // Get page slug
            $page_slug = array_keys($admin_pages[$c]);

            $active = '';

            if ( ($this->input->get('p', true) === $page_slug[0]) || ($c < 1 && !$this->input->get('p', true) ) ) {
                $active = ' class="active"';
            }

            // Display page
            echo '<li>
                <a href="' . site_url('admin/admin?p=' . $page_slug[0]) . '"' . $active . '>
                    ' . $page[0]['page_icon'] . '
                    ' . $page[0]['page_name'] . '
                </a>
            </li>';

        }
        
    }
    ?>
</ul>