<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>Under Maintenance</title>

    <link rel="icon" type="image/x-icon" href="{{ URL::to('/') }}/public/assets/user/img/logo/favicon.png">

    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/flaticon.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/animate.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/magnific-popup.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/nice-select.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/style.css?<?php echo time(); ?>">
</head>

<body>





        <div class="error-area pt-70 pb-70">
            <div class="container">
                <div class="col-md-7 mx-auto">
                    <div class="error-wrapper">
                        <div class="error-img">
                            <img src="https://res.cloudinary.com/daomsvutm/image/upload/v1697087228/3d-illustration-of-website-under-maintenance-website-under-construction-website-maintenance-service-web-development-under-process-3d-rendering-png_dfd3r3.png" alt="">
                        </div>
                        <!-- <h2>Opos... Page Not Found!</h2> -->
                        <br>
                        <h4><?php echo setting()->maintanance_content; ?></h4>
                        <a href="{{ URL::to('/') }}" class="theme-btn">Go Back Home</a>
                    </div>
                </div>
            </div>
        </div>

    </main>


</body>
</html>
