<?php if ( md_the_option('crm_frontend_newsletter') ) { ?>
<section class="py-3 theme-presentation-newsletter">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>
                    <?php echo md_the_option('crm_frontend_newsletter_title'); ?>
                </h2>                            
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="<?php md_get_the_string('theme_enter_the_email'); ?>" />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <?php md_get_the_string('theme_subscribe_to_newsletter'); ?>
                    </button>
                </form>                           
            </div>
        </div>                                                                                                                
    </div>
</section>
<?php } ?>