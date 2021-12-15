<div class="theme-panel">
    <div class="theme-panel-body p-0">
        <ul class="profile-main-menu theme-panel-menu-list">
            <li <?php echo (!$this->input->get('section', true) || ($this->input->get('section', true) === 'general'))?' class="theme-menu-item-active"':''; ?>>
                <a href="<?php echo site_url('admin/user?p=settings&section=general'); ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'general')); ?>
                    <?php echo $this->lang->line('user_general'); ?>
                </a>
            </li>           
            <li <?php echo ($this->input->get('section', true) === 'header')?' class="theme-menu-item-active"':''; ?>>
                <a href="<?php echo site_url('admin/user?p=settings&section=header'); ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'css')); ?>
                    <?php echo $this->lang->line('user_settings_header'); ?>
                </a>
            </li>
            <li <?php echo ($this->input->get('section', true) === 'footer')?' class="theme-menu-item-active"':''; ?>>
                <a href="<?php echo site_url('admin/user?p=settings&section=footer'); ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'js')); ?>
                    <?php echo $this->lang->line('user_settings_footer'); ?>
                </a>
            </li>
        </ul>
    </div>
</div>