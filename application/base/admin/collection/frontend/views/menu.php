<ul>
    <?php
    if (md_the_contents_categories()) {

        // Get contents category array
        $contents_category = md_the_contents_categories();

        for ($c = 0; $c < count(md_the_contents_categories()); $c++) {

            // Get the category value
            $category = array_values($contents_category[$c]);

            // Get category slug
            $category_slug = array_keys($contents_category[$c]);

            $active = '';

            if ($this->input->get('group', true)) {

                if (($this->input->get('group', true) === 'contents_category') && ($this->input->get('p', true) === $category_slug[0])) {
                    $active = ' class="active"';
                }
            } else {

                // Verify if contents categories exists
                if ( $this->input->get('category', true) ) {

                    if ( $category_slug[0] === $this->input->get('category', true) ) {
                        $active = ' class="active"';
                    }

                } else {

                    if ($c < 1) {
                        $active = ' class="active"';
                    }

                }

            }

            // Display category
            echo '<li>
                <a href="' . site_url('admin/frontend?p=' . $category_slug[0]) . '&group=contents_category"' . $active . '>
                    ' . $category[0]['category_icon'] . '
                    ' . $category[0]['category_name'] . '
                </a>
            </li>';
        }
    }
    ?>
</ul>
<ul>
    <?php
    if (md_the_frontend_pages()) {

        // Get frontent_pages array
        $frontend_pages = md_the_frontend_pages();

        for ($c = 0; $c < count($frontend_pages); $c++) {

            // Get the page value
            $page = array_values($frontend_pages[$c]);

            // Get page slug
            $page_slug = array_keys($frontend_pages[$c]);

            $active = '';

            if ($this->input->get('group', true)) {

                if (($this->input->get('group', true) === 'frontend_page') && ($this->input->get('p', true) === $page_slug[0])) {
                    $active = ' class="active"';
                }
            } else {

                if ($c < 1 && !md_the_contents_categories()) {
                    $active = ' class="active"';
                }
            }

            // Display page
            echo '<li>
                <a href="' . site_url('admin/frontend?p=' . $page_slug[0]) . '&group=frontend_page"' . $active . '>
                    ' . $page[0]['page_icon'] . '
                    ' . $page[0]['page_name'] . '
                </a>
            </li>';
        }
    }
    ?>
</ul>