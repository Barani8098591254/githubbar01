
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title><?php echo @($title) ? $title : 'Sign In' ?></title>
    <meta name="description" content="Philbert is a Dashboard & Admin Site Responsive Template by hencework." />
    <meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Philbert Admin, Philbertadmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
    <meta name="author" content="hencework" />

    <link href="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('/')}}/public/assets/admin/dist/css/style.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">
    <link href="{{ URL::to('/') }}/public/assets/admin/dist/patternlock/patternLock.css" rel="stylesheet" type="text/css" />

    <style>
  .error {
        color:rgb(232 121 121);
    }
    </style>

</head>
  <body>
    <!-- Preloader -->
    <div class="preloader-it">
      <div class="la-anim-1"></div>
    </div>
    <!-- /Preloader -->
