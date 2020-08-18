<div class="row">
    <div class="col-lg-12">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="<?php echo site_url('admin/user?p=networks&directory=1'); ?>" class="btn-option new-network">
                                <i class="icon-doc"></i>
                                <?php echo $this->lang->line('user_new_network'); ?>
                            </a>
                        </div>
                        <div class="col-lg-6">
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
<?php

// Get networks
$networks = md_the_user_networks();

// Verify if networks exists
if ( $networks ) {
   ?>
   <div class="row">
      <div class="col-lg-12">
         <ul class="list-contents">
            <?php
            foreach ( $networks as $network ) {
            ?>
            <li class="contents-single">
               <div class="row">
                  <div class="col-lg-10 col-md-8 col-xs-8">
                     <?php echo str_replace('class', 'style="color:' . $network['color'] . ';" class', $network['icon']); ?> <a href="<?php echo site_url('admin/user?p=networks&network=' . $network['name']); ?>">
                        <?php
                           echo ucwords(str_replace(array('_', '-'), ' ', $network['name'])); 
                        ?>
                     </a>
                  </div>
                  <div class="col-lg-2 col-md-2 col-xs-2 text-right">
                     <span class="label label-primary">
                        <?php
                        if ( get_option($network['name']) ) {
                           echo $this->lang->line('user_network_enabled');
                        } else {
                           echo $this->lang->line('user_network_disabled');
                        }
                        ?>
                     </span>
                  </div>
               </div>
            </li>
            <?php
            }
            ?>
         </ul>
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
                           <?php
                           echo $this->lang->line('user_no_data_found_to_show');
                           ?>
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