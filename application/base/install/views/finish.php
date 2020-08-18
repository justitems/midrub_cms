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
    <form>
        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="start-tab" data-toggle="tab" href="#start" role="tab" aria-controls="start"
                    aria-selected="false">
                    <span>
                        1
                    </span>
                    Start
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="information-tab" data-toggle="tab" href="#information" role="tab"
                    aria-controls="information" aria-selected="false">
                    <span>
                        2
                    </span>
                    Information
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="database-tab" data-toggle="tab" href="#database" role="tab"
                    aria-controls="database" aria-selected="false">
                    <span>
                        3
                    </span>
                    Database
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="finish-tab" data-toggle="tab" href="#finish" role="tab"
                    aria-controls="finish" aria-selected="true">
                    <span>
                        4
                    </span>
                    Finish
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="finish" role="tabpanel" aria-labelledby="finish-tab">
                <div class="alert alert-success" role="alert">
                    Midrub was installed successfully.
                </div>   
                <div class="alert alert-primary" role="alert">
                    In 5 seconds you will be redirected to the login page.
                </div> 
            </div>
        </div>
    </form>
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