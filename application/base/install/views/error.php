<!doctype html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Title -->
    <title>Install Midrub</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- Installation CSS -->
    <link rel="stylesheet" href="<?php echo md_the_url(); ?>assets/base/install/styles/css/main.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.2.0/css/all.css">

</head>

<body>
    <?php echo form_open(md_the_url(), 'class="error-page"'); ?>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="start" role="tabpanel" aria-labelledby="start-tab">
                <div class="alert alert-danger" role="alert">
                    <?php echo ERROR_MESSAGE; ?>
                </div>      
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-sm btn-purple">
                        Restart the installation
                    </button>
                </div>                
            </div>
        </div>
    <?php echo form_close(); ?>
    <div class="page-loading">
        <div class="animation-area">
            <div></div>
            <div></div>
        </div>
    </div>
    <script src="//code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="//cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="<?php echo md_the_url(); ?>assets/base/install/js/main.js?ver=0.0.8.1"></script>
    </body>

</html>