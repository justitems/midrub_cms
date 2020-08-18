<ul class="nav nav-pills nav-stacked labels-info">
    <li <?php echo (!$this->input->get('section', true))?' class="active"':''; ?>>
        <a href="<?php echo site_url('admin/user') ?>?p=settings&section=header">
            <i class="fab fa-css3"></i>
            <?php echo $this->lang->line('user_settings_header'); ?>
        </a>
    </li>
    <li <?php echo ($this->input->get('section', true) === 'footer')?' class="active"':''; ?>>
        <a href="<?php echo site_url('admin/user') ?>?p=settings&section=footer">
            <i class="fab fa-js"></i>
            <?php echo $this->lang->line('user_settings_footer'); ?>
        </a>
    </li>
</ul>