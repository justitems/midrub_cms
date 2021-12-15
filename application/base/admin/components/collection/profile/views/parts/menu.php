<div class="theme-panel">
    <div class="theme-panel-body">
        <ul class="profile-main-menu theme-panel-menu-list">
            <li <?php echo !$this->input->get('p', true)?' class="theme-menu-item-active"':''; ?>>
                <a href="<?php echo site_url('admin/profile'); ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'my_profile')); ?>
                    <?php echo $this->lang->line('profile_my_profile'); ?>
                </a>
            </li>
            <li <?php echo ($this->input->get('p', true) === 'preferences')?' class="theme-menu-item-active"':''; ?>>
                <a href="<?php echo site_url('admin/profile?p=preferences'); ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'my_settings')); ?>
                    <?php echo $this->lang->line('profile_my_preferences'); ?>
                </a>
            </li>            
            <li <?php echo ($this->input->get('p', true) === 'security')?' class="theme-menu-item-active"':''; ?>>
                <a href="<?php echo site_url('admin/profile?p=security'); ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'my_security')); ?>
                    <?php echo $this->lang->line('profile_security'); ?>
                </a>
            </li>
        </ul>
    </div>
</div>