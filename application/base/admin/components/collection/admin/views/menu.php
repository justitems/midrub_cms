<div class="row">
    <div class="col-12">
        <ul class="list-group">
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
                    $active = ' theme-sidebar-selected-item';
                }

                // Display page
                echo '<li class="list-group-item' . $active . '">
                    <a href="' . site_url('admin/admin?p=' . $page_slug[0]) . '">
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
<div class="row">
    <div class="col-12">
        <ul class="list-group">
            <li class="list-group-item">
                <a href="<?php echo site_url('admin/support'); ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'support')); ?>
                    <?php echo $this->lang->line('admin_support'); ?>
                </a>
            </li>
            <li class="list-group-item">
                <a href="<?php echo site_url('admin/updates'); ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'update')); ?>
                    <?php echo $this->lang->line('admin_updates'); ?>
                </a>
            </li>
        </ul>
    </div>
</div>