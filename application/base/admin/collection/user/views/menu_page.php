<div class="menu-page">
    <div class="row">
        <div class="col-lg-12">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="row">
                            <div class="col-lg-6 col-xs-6">
                                <div class="dropdown">
                                    <button class="btn btn-secondary menu-dropdown-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <?php
                                        echo $this->lang->line('user_select_menu');
                                        ?>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdown-items">
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="list-group menu-dropdown-list-ul">
                                                    <?php
                                                    if (md_the_user_menu_list()) {

                                                        foreach (md_the_user_menu_list() as $menu) {

                                                            // Get slug
                                                            $slug = array_keys($menu);

                                                            echo '<li class="list-group-item">'
                                                                . '<a href="#" data-slug="' . $slug[0] . '">'
                                                                    . $menu[$slug[0]]['name']
                                                                . '</a>'
                                                            . '</li>';
                                                        }
                                                    } else {

                                                        echo '<li class="list-group-item no-results-found">'
                                                            . $this->lang->line('user_no_menu_found')
                                                            . '</li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-6">
                                <button type="submit" class="btn btn-success new-menu-item">
                                    <?php
                                    echo $this->lang->line('user_new_menu_item');
                                    ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 show-menu-items">
            
        </div>
    </div>
</div>

<div class="theme-menu-save-changes">
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