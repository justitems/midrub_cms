<?php

// Get network
$network = md_the_user_network($this->input->get('network', true));

// Verify if networks exists
if ($network) {
   ?>
   <div class="row">
      <div class="col-lg-12">
         <div class="panel panel-default single-social">
            <div class="panel-heading">
               <div class="row">
                  <div class="col-lg-12">
                     <ul class="nav nav-tabs nav-justified">
                        <li class="active">
                           <a data-toggle="tab" href="#network-<?php echo $this->input->get('network', true); ?>">
                              <?php echo ucwords(str_replace(array('_', '-'), ' ', $this->input->get('network', true))); ?>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="panel-body">
               <div class="tab-content tab-all-editors">
                  <div id="network-<?php echo $this->input->get('network', true); ?>" class="tab-pane fade in active">
                     <?php
                     if ($network['api']) {

                        foreach ($network['api'] as $api) {

                           ?>
                           <div class="form-group">
                              <div class="row">
                                 <div class="col-lg-12">
                                    <label for="social-text-input">
                                       <?php
                                       echo ucwords(str_replace(array('_', '-'), ' ', $api));
                                       ?>
                                    </label>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-lg-12">
                                    <input type="text" class="form-control social-text-input" id="<?php echo $this->input->get('network', true); ?>_<?php echo $api; ?>" value="<?php echo (get_option($this->input->get('network', true) . '_' . $api)) ? get_option($this->input->get('network', true) . '_' . $api) : ''; ?>" placeholder="<?php echo $this->lang->line('user_enter_the'); ?> <?php echo str_replace(array('_', '-'), ' ', $api); ?>">
                                    <small class="form-text text-muted">
                                       <?php echo $this->lang->line('frontend_the_field_is_required'); ?>
                                    </small>
                                 </div>
                              </div>
                           </div>
                        <?php

                        }
                     }
                     ?>
                     <?php echo isset($network['extra_content'])?$network['extra_content']:''; ?>
                     <div class="form-group">
                        <div class="row">
                           <div class="col-lg-12">
                              <label for="menu-item-text-input">
                                 <?php echo $this->lang->line('user_redirect') . ':'; ?>
                              </label>
                           </div>
                           <div class="col-lg-12">
                              <?php echo site_url('user/callback/' . $this->input->get('network', true)); ?>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="row">
                           <div class="col-lg-10 col-xs-6">
                              <label for="menu-item-text-input">
                                 <?php echo $this->lang->line('user_network_enable') . ' ' . ucwords(str_replace(array('_', '-'), ' ', $this->input->get('network', true))); ?>
                              </label>
                           </div>
                           <div class="col-lg-2 col-xs-6">
                              <div class="checkbox-option pull-right">
                                 <input id="<?php echo $this->input->get('network', true); ?>" name="enable-network-<?php echo $this->input->get('network', true); ?>" class="social-option-checkbox" type="checkbox" <?php echo (get_option($this->input->get('network', true))) ? ' checked' : ''; ?>>
                                 <label for="<?php echo $this->input->get('network', true); ?>"></label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php
} else {
   ?>
   <div class="row">
      <div class="col-lg-12">
         <nav class="navbar navbar-default">
            <div class="container-fluid">
               <div class="navbar-header">
                  <div class="row">
                     <div class="col-lg-12">
                        <p>
                           <?php echo $this->lang->line('user_no_data_found_to_show'); ?>
                        </p>
                     </div>
                  </div>
               </div>
            </div>
         </nav>
      </div>
   </div>
<?php
}
?>

<?php echo form_open('admin/frontend', array('class' => 'save-settings', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
<?php echo form_close() ?>

<div class="settings-save-changes">
    <div class="col-xs-6">
        <p><?php echo $this->lang->line('user_settings_you_have_unsaved_changes'); ?></p>
    </div>
    <div class="col-xs-6 text-right">
        <button type="button" class="btn btn-default">
            <i class="far fa-save"></i>
            <?php echo $this->lang->line('user_settings_save_changes'); ?>
        </button>
    </div>
</div>