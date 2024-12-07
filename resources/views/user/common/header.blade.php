<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>{{ $title }}</title>

    <link rel="icon" type="image/x-icon" href="{{ URL::to('/') }}/public/assets/user/img/logo/fav.png">

    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/flaticon.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/animate.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/magnific-popup.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/nice-select.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/public/assets/user/css/style.css?<?php echo time(); ?>">

<link rel="" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


    {{-- <link href="{{ URL::to('/') }}/public/assets/user/bower_components/datatables/media/css/jquery.dataTables.min.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/') }}/public/assets/user/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" /> --}}

    <style>
        .form-group .error {
            color: red;
            margin-top: 3px;
        }
    </style>
</head>



<header class="home-3 header">
    <div class="main-navigation">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ URL::to('/') }}">
                    <img src="{{ URL::to('/') }}/public/assets/user/img/logo/footer-logo-biovus.webp" alt="logo">
                </a>
                <div class="mobile-menu-right">
                    <a href="#" class="mobile-search-btn search-box-outer"><i class="far fa-search"></i></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"><i class="far fa-stream"></i></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="main_nav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">

                            <a class="nav-link" href="{{ URL::to('/') }}"> Home </a>
                        </li>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ URL::to('aboutus') }}"> About </a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ URL::to('investPlan') }}">Plan</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ URL::to('affiliates') }}">affiliate</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ URL::to('contactus') }}">Contact</a></li>
                    </ul>
                    <div class="header-nav-right">
                        <?php if(Session::get('userId') ==''){ ?>
                        <?php }else{ ?>
                        <div class="header-btn">
                            <a href="{{ URL::to('profile') }}" class="theme-btn">MY Account</a>
                        </div>
                        <div class="header-btn">
                            <a href="{{ URL::to('logout') }}" class="theme-btn">logout</a>
                        </div>
                        <?php }?>

                        <?php if(Session::get('userId') ==''){ ?>
                        <div class="header-btn">
                            <a href="{{ URL::to('signin') }}" class="theme-btn">login</a>
                        </div>
                        <div class="header-btn">
                            <a href="{{ URL::to('signup') }}" class="theme-btn">Register</a>
                        </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
