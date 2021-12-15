<div class="row">
    <div class="col-12">
        <ul class="list-group">
            <li class="list-group-item<?php echo (!$this->input->get('p', true))?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/updates') ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'system')); ?>
                    <?php echo $this->lang->line('updates_system'); ?>
                </a>
            </li>
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'apps' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/updates') ?>?p=apps">
                    <?php echo md_the_admin_icon(array('icon' => 'apps')); ?>
                    <?php echo $this->lang->line('updates_apps'); ?>
                </a>
            </li>
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'user_components' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/updates') ?>?p=user_components">
                    <?php echo md_the_admin_icon(array('icon' => 'components')); ?>
                    <?php echo $this->lang->line('updates_user_components'); ?>
                </a>
            </li> 
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'frontend_themes' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/updates') ?>?p=frontend_themes">
                    <?php echo md_the_admin_icon(array('icon' => 'grid')); ?>
                    <?php echo $this->lang->line('updates_frontend_themes'); ?>
                </a>
            </li>
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'plugins' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/updates') ?>?p=plugins">
                    <?php echo md_the_admin_icon(array('icon' => 'plugins_small')); ?>
                    <?php echo $this->lang->line('updates_plugins'); ?>
                </a>
            </li>                                              
        </ul>
    </div>
</div>