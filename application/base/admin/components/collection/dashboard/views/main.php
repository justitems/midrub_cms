<section class="section dashboard-page">
    <div class="container-fluid pt-3">
        <div class="row theme-row-equal">
            <div class="col-md-6 col-12">
                <div class="card dashboard-events-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>
                            <i class="iconify" data-icon="fluent:set-top-stack-20-regular"></i>
                            <?php echo $this->lang->line('dashboard_events'); ?>
                        </h3>
                        <div role="group" class="btn-group theme-input-group-1 dashboard-events-navigation-btns" aria-label="Events navigation" data-time="<?php echo date('Y-m-d'); ?>">
                            <div class="btn-group theme-dropdown-1 mx-3">
                                <button type="button" class="btn btn-light dropdown-toggle dashboard-events-list-btn" aria-expanded="false" data-bs-toggle="dropdown" data-view="0">
                                    <?php echo md_the_admin_icon(array('icon' => 'list', 'class' => 'd-inline-block theme-events-view-icon')); ?>
                                    <span class="d-inline-block">
                                        <?php echo $this->lang->line('dashboard_week'); ?>
                                    </span>
                                    <?php echo md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'd-inline-block theme-dropdown-arrow-icon')); ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" class="dropdown-item" data-view="0">
                                            <?php echo $this->lang->line('dashboard_week'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item" data-view="1">
                                            <?php echo $this->lang->line('dashboard_month'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-light dashboard-events-time dashboard-events-old-btn" data-time="<?php echo dashboard_get_old_events_time(); ?>">
                                <?php echo md_the_admin_icon(array('icon' => 'ios_arrow_left')); ?>
                            </button>
                            <button type="button" class="btn btn-light dashboard-events-time dashboard-events-new-btn" data-time="<?php echo dashboard_get_new_events_time(); ?>">
                                <?php echo md_the_admin_icon(array('icon' => 'ios_arrow_right')); ?>
                            </button>                                                                
                        </div>
                    </div>
                    <div class="card-body"></div>
                </div>
            </div>
            <div class="col-md-6 col-12 dashboard-widgets-list">
                <?php

                // Get the widgets
                $the_widgets = md_the_admin_dashboard_widgets();

                // Verify if the widgets exists
                if ( $the_widgets ) {

                    // List all widgets
                    foreach ( $the_widgets as $the_widget ) {

                        ?>
                        <div class="dashboard-widget" data-widget="<?php echo $the_widget['widget_slug']; ?>" data-content="<?php echo $this->lang->line('dashboard_drop_widget_here'); ?>">
                            <div class="card card-widget theme-card-box theme-box-1" data-widget="<?php echo $the_widget['widget_slug']; ?>">
                                <div class="card-header ps-3 pe-3 pt-2 pb-2">
                                    <h3>
                                        <?php echo $the_widget['widget_icon']; ?>
                                        <?php echo $the_widget['widget_name']; ?>                                    
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <?php echo $the_widget['widget_data'](); ?>
                                </div>
                            </div>
                        </div>
                        <?php

                    }

                }

                ?>                                             
            </div>
        </div>
    </div>
</section>

<script language="javascript">

    // Words container
    let words = {
        joined_members: '<?php echo $this->lang->line('dashboard_last_joined_members'); ?>',
        no_joined_members: '<?php echo $this->lang->line('dashboard_no_joined_members'); ?>'
    }
    
</script>