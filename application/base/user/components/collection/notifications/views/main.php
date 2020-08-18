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
            <div class="notifications-list">
                <div class="tab-content">
                    <div class="tab-pane container fade active show" id="advanced">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-8">
                                        <?php echo $page_header; ?>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" class="back-button btn-disabled">
                                            <i class="arrow-left"></i>
                                        </button>
                                        <button type="button" class="next-button<?php echo ($total < 11) ? ' btn-disabled' : '" data-page="2'; ?>">
                                            <i class="arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="notifications-list-show">
                                            <?php
                                            if ($notifications) {

                                                // List all notifications
                                                foreach ($notifications as $notification) {

                                                    $unread = '';

                                                    // Verify if the notification is unread
                                                    if ( $notification['user_id'] !== $this->user_id ) {
                                                        $unread = ' class="unread-notification"';
                                                    }

                                                    ?>
                                                    <li data-notification="<?php echo $notification['notification_id']; ?>"<?php echo $unread; ?>>
                                                        <div class="row">
                                                            <div class="col-11">
                                                                <a href="<?php echo site_url('user/notifications?p=notifications&notification=' . $notification['notification_id']) ?>" class="show-notification">
                                                                    <i class="icon-star"></i>
                                                                    <?php echo $notification['notification_title']; ?>
                                                                </a>
                                                            </div>
                                                            <div class="col-1">
                                                                <div class="btn-group">
                                                                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="icon-options-vertical"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-action">
                                                                        <a href="#" class="delete-notification">
                                                                            <i class="icon-trash"></i>
                                                                            <?php echo $this->lang->line('notifications_delete'); ?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php

                                                }

                                            } else {

                                                ?>
                                                <li class="no_results_found">
                                                    <div class="row">
                                                        <div class="col-12">
                                                        <?php
                                                            echo $this->lang->line('notifications_no_found');
                                                        ?>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            
                                            }
                                            ?>
                                        </ul>
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