<!DOCTYPE html>
<html lang="en">

<head>
    <title>No page found.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	
    <!-- Font Awesome -->
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.2.0/css/all.css">

    <!-- Font Poppins -->
    <link href="//fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">

    <!-- Midrub CSS -->
    <style>
        .error-template {
            text-align: center;
            padding: 100px 0;
            padding: 30vh 0;
            font-family: 'Poppins', sans-serif;
        }

        h2 {
            font-size: 40px;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .error-details {
            color: #33475b;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #000031;
            border: 0;
            padding: 10px 25px;
		}
		
		.btn-primary i {
			margin-right: 5px;
		}

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: #000031;
            opacity: 0.7;
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="error-template">
                    <h2>
                        Oops! 404 Not Found
                    </h2>
                    <div class="error-details">
                        There doesn't seem to be a page here.
                    </div>
                    <div class="error-actions">
                        <a href="/" class="btn btn-primary">
						    <i class="fas fa-home"></i>
							Take Me Home
						</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
	<script src="<?php echo site_url('assets/js/jquery.min.js'); ?>"></script>
	
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>

</body>

</html>