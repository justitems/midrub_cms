<ul class="nav nav-pills nav-stacked labels-info">
    <li>
        <h4>
            <?php echo $this->lang->line('settings'); ?>
        </h4>
    </li>
    <li <?php settings_menu_item_active(); ?>>
        <a href="<?php echo site_url('admin/settings') ?>">
            <i class="fas fa-cog"></i>
            <?php echo $this->lang->line('general'); ?>
        </a>
    </li>  
    <li <?php settings_menu_item_active('advanced' ); ?>>
        <a href="<?php echo site_url('admin/settings?p=advanced') ?>">
            <i class="fas fa-cogs"></i>
            <?php echo $this->lang->line('advanced'); ?>
        </a>
    </li> 
    <li <?php settings_menu_item_active('users'); ?>>
        <a href="<?php echo site_url('admin/settings?p=users') ?>">
            <i class="fas fa-users"></i>
            <?php echo $this->lang->line('users'); ?>
        </a>
    </li> 
    <li <?php settings_menu_item_active('smtp'); ?>>
        <a href="<?php echo site_url('admin/settings?p=smtp') ?>">
            <i class="far fa-paper-plane"></i>
            <?php echo $this->lang->line('smtp'); ?>
        </a>
    </li> 
</ul>
<ul class="nav nav-pills nav-stacked labels-info">
    <li>
        <h4>
            <?php echo $this->lang->line('customizations'); ?>
        </h4>
    </li>
    <li>
        <a href="<?php echo site_url('admin/appearance') ?>">
            <i class="fa fa-paint-brush"></i>
            <?php echo $this->lang->line('appearance'); ?>
        </a>
    </li>
</ul>
<ul class="nav nav-pills nav-stacked labels-info">
    <li>
        <h4>
            <?php echo $this->lang->line('payments'); ?>
        </h4>
    </li>
    <li <?php settings_menu_item_active('gateways' ); ?>>
        <a href="<?php echo site_url('admin/settings?p=gateways') ?>">
            <i class="fas fa-money-check-alt"></i>
            <?php echo $this->lang->line('gateways'); ?>
        </a>
    </li>  
    <li>
        <a href="<?php echo site_url('admin/coupon-codes') ?>">
            <i class="fas fa-credit-card"></i>
            <?php echo $this->lang->line('coupon_codes'); ?>
        </a>
    </li>  
</ul>
<ul class="nav nav-pills nav-stacked labels-info">
    <li>
        <h4>
            <?php echo $this->lang->line('affiliates'); ?>
        </h4>
    </li>
    <li <?php settings_menu_item_active('affiliates-reports'); ?>>
        <a href="<?php echo site_url('admin/settings?p=affiliates-reports') ?>">
            <i class="fas fa-file-invoice"></i>
            <?php echo $this->lang->line('reports'); ?>
        </a>
    </li>
    <li <?php settings_menu_item_active('affiliates-settings'); ?>>
        <a href="<?php echo site_url('admin/settings?p=affiliates-settings') ?>">
            <i class="fas fa-wrench"></i>
            <?php echo $this->lang->line('settings'); ?>
        </a>
    </li>    
</ul>
<ul class="nav nav-pills nav-stacked labels-info">
    <li>
        <h4>
            <?php echo $this->lang->line('api'); ?>
        </h4>
    </li>
    <li <?php settings_menu_item_active('api-permissions'); ?>>
        <a href="<?php echo site_url('admin/settings?p=api-permissions') ?>">
            <i class="fas fa-user-edit"></i>
            <?php echo $this->lang->line('permissions'); ?>
        </a>
    </li>
    <li <?php settings_menu_item_active('api-applications'); ?>>
        <a href="<?php echo site_url('admin/settings?p=api-applications') ?>">
            <i class="fab fa-microsoft"></i>
            <?php echo $this->lang->line('settings_apps'); ?>
        </a>
    </li>    
</ul>