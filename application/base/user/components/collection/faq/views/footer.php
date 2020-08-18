<button type="button" class="btn btn-primary btn-help-open-ticket" data-toggle="modal" data-target="#tickets-popup">
    <i class="icon-question"></i>
    <?php echo $this->lang->line('help'); ?>
</button>

<!-- Modal -->
<div class="modal fade" id="tickets-popup" tabindex="-1" role="dialog" aria-labelledby="accounts-manager-popup" aria-hidden="true">
    <div class="modal-dialog file-upload-box modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <?php echo form_open('user/faq', array('class' => 'submit-new-ticket', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                <div class="modal-header">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active show" id="nav-new-ticket-tab" data-toggle="tab" href="#nav-new-ticket" role="tab" aria-controls="nav-new-ticket" aria-selected="true">
                               <?php echo $this->lang->line('new_ticket'); ?> 
                            </a>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </nav>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-new-ticket" role="tabpanel" aria-labelledby="nav-new-ticket">
                            <div class="form-group">
                                <input type="text" class="form-control ticket-subject" placeholder="<?php echo $this->lang->line('ticket_subject'); ?>" autocomplete="off" required="required">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control ticket-body" placeholder="<?php echo $this->lang->line('enter_your_question_here'); ?>"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" data-type="main" class="btn btn-primary pull-right">
                        <?php echo $this->lang->line('submit_ticket'); ?>
                    </button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>