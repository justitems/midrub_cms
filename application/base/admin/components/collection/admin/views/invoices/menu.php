<div class="theme-panel">
    <div class="theme-panel-body p-0">
        <ul class="profile-main-menu theme-panel-menu-list">
            <li <?php echo $this->input->get('template', true)?' class="theme-menu-item-active"':''; ?>>
                <a href="<?php echo site_url('admin/admin?p=invoices&template=1') ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'print_small')); ?>
                    <?php echo $this->lang->line('admin_template'); ?>
                </a>
            </li>
            <li <?php echo $this->input->get('faq', true)?' class="theme-menu-item-active"':''; ?>>
                <a href="<?php echo site_url('admin/admin?p=invoices&faq=1') ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'faq')); ?>
                    <?php echo $this->lang->line('admin_faq'); ?>
                </a>
            </li>
        </ul>
    </div>
</div>