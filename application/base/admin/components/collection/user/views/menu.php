<div class="row">
    <div class="col-12">
        <ul class="list-group">
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
                        $active = ' theme-sidebar-selected-item';
                    }

                    // Display page
                    echo '<li class="list-group-item' . $active . '">
                        <a href="' . site_url('admin/user?p=' . $page_slug[0]) . '">
                            ' . $page[0]['page_icon'] . '
                            ' . $page[0]['page_name'] . '
                        </a>
                    </li>';
                }
            }
            ?>
        </ul>
    </div>
</div>