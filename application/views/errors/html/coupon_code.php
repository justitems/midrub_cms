<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->lang->line('default_errors_subscription_has_been_expired'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=2" />

        <!-- Bootstrap CSS -->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.2.0/css/all.css">

        <!-- Simple Line Icons -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">

        <!-- Subscription Expired CSS -->
        <link href="<?php echo base_url('assets/base/user/default/styles/css/subscription-expired.css'); ?>?ver=<?php echo MD_VER; ?>1" rel="stylesheet" />

        <!-- Set website url -->
        <meta name="url" content="<?php echo site_url(); ?>">

    </head>

    <body>
        <main role="main">
            <header>
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="font-logo">
                            <a href="<?php echo site_url(); ?>">
                                <?php if ( md_the_option('frontend_theme_logo') ): echo '<img src="' . md_the_option('frontend_theme_logo') . '" class="logo">'; else: echo $this->config->item('site_name'); endif; ?>
                            </a>
                        </h5>
                        <div class="dropdown">
                            <a href="#" role="button" id="subscription-expired-sign-out-dropdown" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="https://www.gravatar.com/avatar/<?php echo $this->user_email; ?>" class="img-fluid rounded-circle z-depth-0" width="30">
                                <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 01.708 0L8 10.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="subscription-expired-sign-out-dropdown">
                                <a href="<?php echo site_url('logout') ?>" class="dropdown-item">
                                    <?php echo $this->lang->line('default_errors_sign_out'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <section class="gateways-page">
                <div class="container-fluid" data-price="<?php echo $plan_data[0]['plan_price']; ?>">
                    <div class="row">
                        <div class="col-xl-4 offset-xl-4">
                            <div class="col-xl-12">
                                <div class="panel panel-success mb-4">
                                    <div class="panel-heading">
                                        <h3>
                                            <?php echo $this->lang->line('default_errors_total'); ?>
                                            <span class="float-right subscription-expired-price">
                                                <?php echo $plan_data[0]['plan_price']; ?>
                                            </span>
                                            <span class="float-right">
                                                <?php echo $plan_data[0]['currency_sign']; ?>
                                            </span>
                                            <span class="float-right subscription-expired-discount-price"></span>
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php echo form_open('error/subscription-expired?p=pay&plan=' . $plan_id, array('class' => 'subscription-expired-verify-coupon-code-form', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                                        <div class="row coupon-code">
                                            <div class="col-xl-8 col-sm-8 col-xs-8 col-8">
                                                <input type="text" class="subscription-expired-discount-code" placeholder="<?php echo $this->lang->line('default_errors_enter_coupon'); ?>" required>
                                            </div>
                                            <div class="col-xl-4 col-sm-4 col-xs-4 col-4">
                                                <button type="submit" class="btn btn-primary subscription-expired-verify-coupon-code-btn"><?php echo $this->lang->line('default_errors_apply'); ?></button>
                                            </div>
                                        </div>
                                        <?php echo form_close() ?>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="<?php echo site_url('error/subscription-expired?p=pay&plan=' . $plan_id) ?>" class="btn btn-primary">
                                                    <?php echo $this->lang->line('default_errors_next'); ?>
                                                    <i class="icon-arrow-right-circle"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- jQuery -->
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

        <!-- POPPER JS -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

        <!-- Main JS -->
        <script src="<?php echo base_url('assets/js/main.js'); ?>?ver=<?php echo MD_VER; ?>5"></script>        

        <!-- Subscription Expired JS -->
        <script src="<?php echo base_url('assets/base/user/default/js/subscription-expired.js'); ?>?ver=<?php echo MD_VER; ?>5"></script>        

    </body>
</html>