<ul class="nav nav-pills nav-stacked labels-info">
    <li <?php echo (!$this->input->get('p', true))?'class="active"':''; ?>>
        <a href="<?php echo site_url('admin/update') ?>">
            <i class="fas fa-network-wired"></i>
            <?php echo $this->lang->line('update_system'); ?>
        </a>
    </li>
    <li <?php echo ( $this->input->get('p', true) === 'apps' )?'class="active"':''; ?>>
        <a href="<?php echo site_url('admin/update') ?>?p=apps">
            <i class="icon-layers"></i>
            <?php echo $this->lang->line('update_apps'); ?>
        </a>
    </li> 
    <li <?php echo ( $this->input->get('p', true) === 'user_components' )?'class="active"':''; ?>>
        <a href="<?php echo site_url('admin/update') ?>?p=user_components">
            <i class="fas fa-swatchbook"></i>
            <?php echo $this->lang->line('update_user_components'); ?>
        </a>
    </li>  
    <li <?php echo ( $this->input->get('p', true) === 'frontend_themes' )?'class="active"':''; ?>>
        <a href="<?php echo site_url('admin/update') ?>?p=frontend_themes">
            <i class="icon-grid"></i>
            <?php echo $this->lang->line('update_frontend_themes'); ?>
        </a>
    </li>            
</ul>