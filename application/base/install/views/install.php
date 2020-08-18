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
    <form class="start-installation" action="<?php echo md_the_url(); ?>?action=enter-information" method="POST">
        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="start-tab" data-toggle="tab" href="#start" role="tab" aria-controls="start"
                    aria-selected="true">
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
                <a class="nav-link" id="finish-tab" data-toggle="tab" href="#finish" role="tab"
                    aria-controls="finish" aria-selected="false">
                    <span>
                        4
                    </span>
                    Finish
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="start" role="tabpanel" aria-labelledby="start-tab">
                <div class="alert alert-primary" role="alert">
                    Ensure your server has the minimum requested configuration.
                </div>           
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h3>max_execution_time</h3>
                                <p>Should be at least 300</p>
                            </div>
                            <div class="col-2">
                                <h2>
                                    <span>
                                        <?php echo ini_get('max_execution_time'); ?>
                                    </span>
                                </h2>
                            </div>                            
                        </div>
                    </div>
                </div> 
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h3>session.gc_maxlifetime</h3>
                                <p>Should be at least 10800</p>
                            </div>
                            <div class="col-2">
                                <h2>
                                    <span>
                                        <?php echo ini_get('session.gc_maxlifetime'); ?>
                                    </span>
                                </h2>
                            </div>                            
                        </div>
                    </div>
                </div>  
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h3>max_input_time</h3>
                                <p>Should be at least 600</p>
                            </div>
                            <div class="col-2">
                                <h2>
                                    <span>
                                        <?php echo ini_get('max_input_time'); ?>
                                    </span>
                                </h2>
                            </div>                            
                        </div>
                    </div>
                </div>    
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h3>upload_max_filesize</h3>
                                <p>Should be at least 120 MB</p>
                            </div>
                            <div class="col-2">
                                <h2>
                                    <span>
                                        <?php echo ini_get('upload_max_filesize'); ?>
                                    </span>
                                </h2>
                            </div>                            
                        </div>
                    </div>
                </div>  
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h3>post_max_size</h3>
                                <p>Should be at least 120 MB</p>
                            </div>
                            <div class="col-2">
                                <h2>
                                    <span>
                                        <?php echo ini_get('post_max_size'); ?>
                                    </span>
                                </h2>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h3>allow_url_fopen</h3>
                                <p>Should be enabled</p>
                            </div>
                            <div class="col-2">
                                <h2>
                                <?php
                                    if( ini_get('allow_url_fopen') ) {
                                        
                                        echo '<i class="far fa-check-circle"></i>';

                                    } else {

                                        echo '<i class="fas fa-exclamation-circle"></i>';

                                    }
                                    ?>
                                    
                                </h2>
                            </div>                            
                        </div>
                    </div>
                </div>                                         
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h3>Curl Extension</h3>
                                <p>Should be enabled</p>
                            </div>
                            <div class="col-2">
                                <h2>
                                <?php
                                    if( extension_loaded('curl') ) {
                                        
                                        echo '<i class="far fa-check-circle"></i>';

                                    } else {

                                        echo '<i class="fas fa-exclamation-circle"></i>';

                                    }
                                    ?>
                                    
                                </h2>
                            </div>                            
                        </div>
                    </div>
                </div>                
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h3>Zip Extension</h3>
                                <p>Should be enabled</p>
                            </div>
                            <div class="col-2">
                                <h2>
                                <?php
                                    if( extension_loaded('zip') ) {
                                        
                                        echo '<i class="far fa-check-circle"></i>';

                                    } else {

                                        echo '<i class="fas fa-exclamation-circle"></i>';

                                    }
                                    ?>
                                    
                                </h2>
                            </div>                            
                        </div>
                    </div>
                </div> 

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h3>PHP Version</h3>
                                <p>Should be 7.3</p>
                            </div>
                            <div class="col-2">
                                <h2>
                                    <span>
                                        <?php echo phpversion(); ?>
                                    </span>
                                </h2>
                            </div>                            
                        </div>
                    </div>
                </div>     
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-sm btn-purple">
                        Start the installation
                    </button>
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