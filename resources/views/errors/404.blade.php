
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>404 Error</title>

    <link rel="icon" type="image/x-icon" href="{{ URL::to('/') }}/public/assets/user/img/logo/favicon.png">


    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/style.css?<?php echo time(); ?>">


</head>

<main class="main my-5">
    <div class="error-area pt-70 pb-70">
    <div class="container">
    <div class="col-md-7 mx-auto">
    <div class="error-wrapper">
    <div class="error-img">
        <img src="{{ URL::to('/') }}/public/assets/user/img/about/404.png" alt="">
    </div>
    <h3>Opos... Page Not Found!</h3>

    <p>The page you looking for not found may be it not exist or removed.</p>
    <a href="{{ URL::to('') }}" class="theme-btn">Go Back Home </a>
    </div>
    </div>
    </div>
    </div>

    </main>


