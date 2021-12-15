<div class="row mt-3 mb-3">
    <div class="col-lg-12">
        <div class="theme-box-1">
            <nav class="navbar navbar-default theme-navbar-1">
                <div class="navbar-header ps-3 pe-3 pt-2 pb-2">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-8">
                            <a href="<?php echo site_url('admin/members?p=all_members&member=' . the_ticket_author_id()); ?>" class="navbar-header-title">
                                <?php echo md_the_admin_icon(array('icon' => 'person')); ?>
                                <?php echo the_ticket_author_username(); ?>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-4 text-end">
                            <div class="btn-group theme-dropdown-1">
                                <button type="button" class="btn btn-secondary dropdown-toggle d-flex justify-content-between align-items-start ticket-status" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>
                                        <?php
                                        if ( !the_ticket_status() ) {

                                            echo $this->lang->line('closed');

                                        } else {

                                            echo $this->lang->line('active');

                                        }
                                        ?>
                                    </span>
                                    <?php echo md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon')); ?>
                                </button>
                                <div class="dropdown-menu change-ticket-status">
                                    <div>
                                        <ul class="list-group theme-dropdown-items-list">
                                            <li class="list-group-item">
                                                <a href="#" class="dropdown-item" data-id="1">
                                                    <?php echo $this->lang->line('active'); ?>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="#" class="dropdown-item" data-id="0">
                                                    <?php echo $this->lang->line('closed'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>            
        </div>
    </div>
</div>
<div class="row mb-3 ticket-body">
    <div class="col-lg-12">
        <div class="theme-box-1">
            <div class="card theme-card-box">
                <div class="card-header">
                    <button class="btn btn-link">
                        <?php echo md_the_admin_icon(array('icon' => 'faq')); ?>
                        <?php echo the_ticket_subject(); ?>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 theme-card-box-article">
                            <p>
                                <?php echo nl2br(the_ticket_body()); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3 ticket-form">
    <div class="col-lg-12">
        <div class="theme-box-1 p-3 pt-0">
            <?php echo form_open('admin/support', array('class' => 'create-new-ticket-reply', 'data-csrf' => $this->security->get_csrf_token_name(), 'data-id' => the_ticket_id())) ?>
                <textarea placeholder="<?php echo $this->lang->line('support_enter_your_reply_here'); ?>" class="support-reply-body theme-textarea-1"></textarea>
                <button type="submit" class="btn btn-success theme-button-1">
                    <?php echo md_the_admin_icon(array('icon' => 'send')); ?>
                    <span>
                        <?php echo $this->lang->line('reply'); ?>
                    </span>
                </button>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="support-ticket-replies">
        </div>
    </div>
</div>