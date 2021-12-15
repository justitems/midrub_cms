<div class="row mt-3">
    <div class="col-lg-12">
        <div class="theme-box-1">
            <nav class="navbar navbar-default theme-navbar-1">
                <div class="navbar-header ps-3 pe-3 pt-2 pb-2">
                    <div class="row">
                        <div class="col-12">
                           <a href="<?php echo site_url('admin/admin?p=themes&directory=1'); ?>" class="btn-option new-theme theme-button-2">
                                <?php echo md_the_admin_icon(array('icon' => 'new_theme')); ?>
                                <?php echo $this->lang->line('admin_new_theme'); ?>
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
 
                // Verify if themes exists
                if (the_admin_themes()) {

                    foreach (the_admin_themes() as $theme) {

                        ?>
                        <div class="card card-theme theme-box-1<?php echo (md_the_option('themes_enabled_admin_theme') === $theme['slug'])?' theme-list-item-enabled':''; ?>" data-theme="<?php echo $theme['slug']; ?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10 col-8">
                                        <div class="media d-flex justify-content-start">
                                            <img src="<?php echo $theme['screenshot']; ?>">
                                            <div class="media-body">
                                                <h2>
                                                    <?php echo $theme['name']; ?>
                                                </h2>
                                                <p>
                                                    <?php echo $theme['description']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-2 text-center">
                                        <span class="label label-default theme-label">
                                            v<?php echo $theme['version']; ?>
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
                                                    if ( md_the_option('themes_enabled_admin_theme') !== $theme['slug'] ) {
                                                        ?>
                                                        <a href="#" class="admin-enable-theme">
                                                            <?php echo md_the_admin_icon(array('icon' => 'enable')); ?>
                                                            <?php echo $this->lang->line('admin_enable'); ?>
                                                        </a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a href="#" class="admin-disable-theme">
                                                            <?php echo md_the_admin_icon(array('icon' => 'disable')); ?>
                                                            <?php echo $this->lang->line('admin_disable'); ?>
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

                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="theme-box-1 theme-list-no-results-found">
                            <?php echo $this->lang->line('admin_no_data_found_to_show'); ?>
                        </p>         
                    </div>
                </div>
                <?php

            }
            ?>
            </div>
        </div>
    </div>
</div>