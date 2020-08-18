<ul>
    <?php
    if ( md_the_support_pages() ) {

        // Get support_pages array
        $support_pages = md_the_support_pages();

        for ($c = 0; $c < count($support_pages); $c++) {

            // Get the page value
            $page = array_values($support_pages[$c]);

            // Get page slug
            $page_slug = array_keys($support_pages[$c]);

            $active = '';

            if ( ($this->input->get('p', true) === $page_slug[0]) || ($c < 1 && !$this->input->get('p', true) ) ) {
                $active = ' class="active"';
            }

            // Display page
            echo '<li>
                <a href="' . site_url('admin/support?p=' . $page_slug[0]) . '"' . $active . '>
                    ' . $page[0]['page_icon'] . '
                    ' . $page[0]['page_name'] . '
                </a>
            </li>';
        }
    }
    ?>
</ul>
<ul>