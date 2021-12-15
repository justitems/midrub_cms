<div class="row mt-3">
    <div class="col-lg-12">
        <div class="theme-box-1">
            <nav class="navbar navbar-default theme-navbar-1">
                <div class="navbar-header ps-3 pe-3 pt-2 pb-2">
                    <div class="row">
                        <div class="col-12">
                            <a href="<?php echo site_url('admin/plugins?p=plugins&directory=1'); ?>" class="btn-option theme-button-2">
                                <?php echo md_the_admin_icon(array('icon' => 'plugins_add')); ?>
                                <?php echo $this->lang->line('plugins_new_plugin'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>            
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card mt-0 theme-list">
            <div class="card-body">
                <?php
                
                // Verify if plugins exists
                if (the_plugins_list()) {

                    foreach (the_plugins_list() as $plugin) {

                        // Set plugin's slug
                        $plugin_slug = !empty($plugin['plugin_slug'])?$plugin['plugin_slug']:'';

                        ?>
                        <div class="card card-plugin theme-box-1<?php echo md_the_option('plugin_' . $plugin_slug . '_enabled')?' theme-list-item-enabled':''; ?>" data-plugin="<?php echo $plugin_slug; ?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10 col-8">
                                        <div class="media d-flex justify-content-start">
                                            <img src="<?php echo !empty($plugin['plugin_cover'])?$plugin['plugin_cover']:''; ?>" alt="<?php echo !empty($plugin['plugin_name'])?$plugin['plugin_name']:''; ?>" onerror="this.src='<?php echo base_url('assets/img/no-image.png'); ?>';">
                                            <div class="media-body">
                                                <h2>
                                                    <?php echo !empty($plugin['plugin_name'])?$plugin['plugin_name']:''; ?>
                                                </h2>
                                                <?php echo !empty($plugin['plugin_description'])?$plugin['plugin_description']:''; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-2 text-center">
                                        <span class="label label-default theme-label">
                                            <?php echo !empty($plugin['version'])?'v' . $plugin['version']:''; ?>
                                        </span>
                                    </div>
                                    <div class="col-md-1 col-2">
                                        <div class="btn-group theme-dropdown-2">
                                            <button class="btn dropdown-toggle text-end" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php echo md_the_admin_icon(array('icon' => 'more')); ?>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <?php
                                                    if ( md_the_option('plugin_' . $plugin_slug . '_enabled') ) {
                                                        ?>
                                                        <a href="#" class="plugins-disable-plugin">
                                                            <?php echo md_the_admin_icon(array('icon' => 'disable')); ?>
                                                            <?php echo $this->lang->line('plugins_disable'); ?>
                                                        </a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a href="#" class="plugins-enable-plugin">
                                                            <?php echo md_the_admin_icon(array('icon' => 'enable')); ?>
                                                            <?php echo $this->lang->line('plugins_enable'); ?>
                                                        </a>
                                                        <?php
                                                    }
                                                    ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php

                }
                
            } else {

                // Display the missing plugins message
                echo '<p class="theme-box-1 theme-list-no-results-found">'
                    . $this->lang->line('plugins_no_data_found_to_show')
                . '</p>';

            }

            ?>
            </div>
        </div>
    </div>
</div>