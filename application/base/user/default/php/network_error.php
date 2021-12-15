<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->lang->line('user_error_message'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=2" />

        <!-- User Static Messages CSS -->
        <link href="<?php echo base_url('assets/base/user/default/styles/css/messages.css'); ?>?ver=<?php echo MD_VER; ?>" rel="stylesheet" />

    </head>

    <body>
        <main role="main">
            <section>
                <div class="cms-error-message">
                    <?php echo $message; ?>
                </div>
            </section>
        </main>
    </body>
</html>