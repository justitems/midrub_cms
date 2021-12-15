<div class="frontend-menu-page pb-3">
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="theme-box-1">
                <nav class="navbar navbar-default theme-navbar-1">
                    <div class="navbar-header ps-3 pe-3 pt-1 pb-1">
                        <div class="row">
                            <div class="col-6">
                                <div class="dropdown theme-dropdown-1">
                                    <button type="button" class="btn btn-secondary d-flex justify-content-between align-items-start frontend-menu-dropdown-btn" aria-expanded="false" data-bs-toggle="dropdown">
                                        <span>
                                            <?php echo $this->lang->line('frontend_select_menu'); ?>
                                        </span>
                                        <?php echo md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon')); ?>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdown-items">
                                        <div>
                                            <ul class="list-group theme-dropdown-items-list">
                                                <?php
                                                if (md_the_frontend_menu_list()) {

                                                    foreach (md_the_frontend_menu_list() as $menu) {

                                                        // Get slug
                                                        $slug = array_keys($menu);

                                                        // Display item
                                                        echo '<li class="list-group-item">'
                                                            . '<a href="#" data-slug="' . $slug[0] . '">'
                                                                . $menu[$slug[0]]['name']
                                                            . '</a>'
                                                        . '</li>';
                                                    }
                                                } else {

                                                    // Display the no menu message
                                                    echo '<li class="list-group-item no-results-found">'
                                                        . $this->lang->line('frontend_no_menu_found')
                                                    . '</li>';
                                                }
                                                ?>                                                    
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <button type="submit" class="float-end theme-button-2 frontend-new-menu-item">
                                    <?php echo md_the_admin_icon(array('icon' => 'new_page')); ?>
                                    <?php echo $this->lang->line('frontend_new_menu_item'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </nav>            
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 show-menu-items">
            
        </div>
    </div>
</div>

<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/modals/new_item.php'); ?>