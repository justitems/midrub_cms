<section class="notifications-page">
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <h1 class="notifications-title">
                <?php
                echo $this->lang->line('notifications');
                ?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-2 offset-xl-2">
            <div class="notifications-menu-group">
                <?php
                get_the_file(MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS . 'views/menu.php');
                ?>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="notification-single">
                <div class="tab-content">
                    <div class="tab-pane container fade active show" id="advanced">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-12">
                                        <i class="icon-general"></i>
                                        <?php echo $notification[0]['notification_title']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-12">
                                        <?php echo $notification[0]['notification_body']; ?>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>