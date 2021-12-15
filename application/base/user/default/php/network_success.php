<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->lang->line('user_success_message'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=2" />

        <!-- User Static Messages CSS -->
        <link href="<?php echo base_url('assets/base/user/default/styles/css/messages.css'); ?>?ver=<?php echo MD_VER; ?>" rel="stylesheet" />

    </head>

    <body>
        <main role="main">
            <section>
                <div class="cms-success-message">
                    <?php echo $message; ?>
                </div>
            </section>
        </main>
        <script language="javascript">

            // Close the Modal
            setTimeout(function(){
                window.opener.Main.reload_accounts();
                window.close();
            }, 1500);
            
        </script>
    </body>
</html>