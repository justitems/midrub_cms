<section class="admin-page" data-csrf-name="<?php echo $this->security->get_csrf_token_name(); ?>" data-csrf-hash="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="container-fluid">
        <div class="dashboard-page">
            <div class="row">
                <?php

                // Get enabled widgets
                $all_widgets = administrator_dashboard_the_widgets();
                
                // Verify if widgets exists
                if ( $all_widgets['widgets'] ) {

                    // List all widgets
                    foreach ( $all_widgets['widgets'] as $widget ) {

                        $col = 12;

                        switch ( $widget['width'] ) {

                            case 2:

                                $col = 6;

                                break;

                            case 3:

                                $col = 4;

                                break;

                            case 4:

                                $col = 3;

                                break;                        

                        }

                        ?>
                        <div class="col-lg-<?php echo $col; ?>">
                            <div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <?php echo $widget['widget_icon']; ?>
                                                <?php echo $widget['widget_name']; ?>
                                            </div>
                                            <div class="col-lg-4 text-right">
                                                <div class="btn-group">
                                                    <button class="btn btn-default btn-sm dropdown-toggle dashboard-widget-status" data-target="<?php echo $widget['widget_slug']; ?>" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon-options-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dashboard-change-widget-status">
                                                        <li>
                                                            <a href="#" data-type="1">
                                                                <?php echo $this->lang->line('dashboard_enabled'); ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-type="0">
                                                                <?php echo $this->lang->line('dashboard_disabled'); ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php echo $widget['content'](); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php

                    }

                }

                ?>
            </div>
        </div>
        <button type="button" class="btn-primary dashboard-manage-widgets" data-toggle="modal"
            data-target="#dashboard-manage-widgets">
            <i class="icon-settings"></i>
        </button>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="dashboard-manage-widgets" tabindex="-1" role="dialog"
    aria-labelledby="dashboard-manage-widgets">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#manage" aria-controls="manage" role="tab" data-toggle="tab">
                            <?php echo $this->lang->line('dashboard_manage'); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="manage">
                        <ul class="dashboard-manage-widgets-list">
                            <?php
                            if ( $widgets ) {

                                foreach ( $widgets as $widget ) {

                                    ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <?php echo $widget['widget_name']; ?>
                                            </div>
                                            <div class="col-lg-4 text-right">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default dropdown-toggle dashboard-widget-status" data-target="<?php echo $widget['widget_slug']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <?php
                                                        if ( !empty($all_widgets['enabled'][$widget['widget_slug']]) ) {

                                                            echo $this->lang->line('dashboard_disabled');

                                                        } else {

                                                            echo $this->lang->line('dashboard_enabled');

                                                        }
                                                        ?><span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dashboard-change-widget-status">
                                                        <li>
                                                            <a href="#" data-type="1">
                                                                <?php echo $this->lang->line('dashboard_enabled'); ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-type="0">
                                                                <?php echo $this->lang->line('dashboard_disabled'); ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php

                                }

                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loader -->
<div class="page-loading">
    <div class="loading-animation-area">
        <div class="loading-center-absolute">
            <div class="object object_four"></div>
            <div class="object object_three"></div>
            <div class="object object_two"></div>
            <div class="object object_one"></div>
        </div>
    </div>
</div>