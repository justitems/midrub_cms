<div class="row nav-ticket-header">
    <div class="col-lg-12">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-8">
                            <a href="<?php echo site_url('admin/users#' . the_ticket_author_id()); ?>">
                                <i class="icon-user"></i>
                                <?php echo the_ticket_author_username(); ?>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-4 text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary dropdown-toggle ticket-status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    if ( !the_ticket_status() ) {

                                        echo $this->lang->line('closed');

                                    } else {

                                        echo $this->lang->line('active');

                                    }
                                    ?>
                                </button>
                                <div class="dropdown-menu change-ticket-status">
                                    <a class="dropdown-item" href="#" data-id="1">
                                        <?php echo $this->lang->line('active'); ?>
                                    </a>
                                    <a class="dropdown-item" href="#" data-id="0">
                                        <?php echo $this->lang->line('closed'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
<div class="row ticket-body">
    <div class="col-lg-12">
        <div class="panel panel-default menu-item">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <h3>
                            <?php echo the_ticket_subject(); ?>
                        </h3>
                        <p>
                            <?php echo the_ticket_body(); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row ticket-form">
    <div class="col-lg-12">
        <?php echo form_open('admin/support', array('class' => 'create-new-ticket-reply', 'data-csrf' => $this->security->get_csrf_token_name(), 'data-id' => the_ticket_id())) ?>
            <textarea placeholder="Enter your reply here" class="reply-body"></textarea>
            <button type="submit" class="btn btn-success">
                <i class="fa fa-share"></i>
                <?php echo $this->lang->line('reply'); ?>
            </button>
        <?php echo form_close() ?>
    </div>
</div>
<div class="row ticket-replies">
</div>