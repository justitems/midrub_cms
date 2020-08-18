<main role="main" class="main">
    <section class="member-access-form">
        <?php echo form_open('', array('class' => 'form-confirmation', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
        <div class="cl-form-column" id="page-form">
            <h1>
                <?php
                echo (md_the_single_content_meta('auth_confirmation_details_title')) ? md_the_single_content_meta('auth_confirmation_details_title') : $this->lang->line('auth_confirmation_page_title');
                ?>
            </h1>
            <h2>
                <?php
                echo (md_the_single_content_meta('auth_confirmation_details_under_title')) ? md_the_single_content_meta('auth_confirmation_details_under_title') : $this->lang->line('auth_confirmation_page_under_title');
                ?>
            </h2>
        </div>
        <div class="row">
            <div class="col-6">
                <button class="btn btn-success resend-confirmation-code" type="button">
                    <?php echo $this->lang->line('auth_confirmation_resend_confirmation_code'); ?>
                </button>
            </div>
            <div class="col-6">
                <button class="btn btn-primary change-email-area" type="button">
                    <?php echo $this->lang->line('auth_confirmation_change_email'); ?>
                </button>
            </div>
        </div>
        <div class="form-label-group change-email">
            <input class="form-control email" type="email" placeholder="Email" required>
            <button class="btn btn-primary" type="submit">
                <?php echo $this->lang->line('auth_confirmation_change_email_and_resend_code'); ?>
            </button>
        </div>
        <?php echo form_close() ?>
    </section>
</main>