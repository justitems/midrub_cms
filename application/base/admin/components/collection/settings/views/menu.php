<div class="row">
    <div class="col-12">
        <ul class="list-group">
            <li class="list-group-item<?php echo (!$this->input->get('p', true))?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/settings') ?>">
                    <?php echo md_the_admin_icon(array('icon' => 'general')); ?>
                    <?php echo $this->lang->line('general'); ?>
                </a>
            </li>                                   
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <ul class="list-group">
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'storage' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/settings') ?>?p=storage">
                    <?php echo md_the_admin_icon(array('icon' => 'storage')); ?>
                    <?php echo $this->lang->line('settings_storage'); ?>
                </a>
            </li>
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'smtp' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/settings') ?>?p=smtp">
                    <?php echo md_the_admin_icon(array('icon' => 'smtp')); ?>
                    <?php echo $this->lang->line('smtp'); ?>
                </a>
            </li>                                                              
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <ul class="list-group">
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'affiliates-reports' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/settings') ?>?p=affiliates-reports">
                    <?php echo md_the_admin_icon(array('icon' => 'affiliates')); ?>
                    <?php echo $this->lang->line('settings_affiliates_reports'); ?>
                </a>
            </li> 
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'affiliates-settings' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/settings') ?>?p=affiliates-settings">
                    <?php echo md_the_admin_icon(array('icon' => 'affiliates')); ?>
                    <?php echo $this->lang->line('settings_affiliates_settings'); ?>
                </a>
            </li>                                                            
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <ul class="list-group">
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'api-permissions' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/settings') ?>?p=api-permissions">
                    <?php echo md_the_admin_icon(array('icon' => 'api')); ?>
                    <?php echo $this->lang->line('settings_api_permissions'); ?>
                </a>
            </li> 
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'api-applications' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/settings') ?>?p=api-applications">
                    <?php echo md_the_admin_icon(array('icon' => 'api')); ?>
                    <?php echo $this->lang->line('settings_api_settings'); ?>
                </a>
            </li>                                                            
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <ul class="list-group">
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'gateways' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/settings') ?>?p=gateways">
                    <?php echo md_the_admin_icon(array('icon' => 'payments')); ?>
                    <?php echo $this->lang->line('gateways'); ?>
                </a>
            </li>
            <li class="list-group-item<?php echo ( $this->input->get('p', true) === 'coupon-codes' )?' theme-sidebar-selected-item':''; ?>">
                <a href="<?php echo site_url('admin/settings') ?>?p=coupon-codes">
                    <?php echo md_the_admin_icon(array('icon' => 'coupons')); ?>
                    <?php echo $this->lang->line('coupon_codes'); ?>
                </a>
            </li>                                                                      
        </ul>
    </div>
</div>