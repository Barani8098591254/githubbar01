<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title><?php echo @($title) ? $title : 'Admin' ?></title>

    <link href="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('/')}}/public/assets/admin/dist/css/animate.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('/')}}/public/assets/admin/dist/css/basic-admin.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('/')}}/public/assets/admin/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    {{-- <link href="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" type="text/css" /> --}}

    <link href="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="{{URL::to('/')}}/public/assets/admin/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css">

    <link href="{{ URL::to('/') }}/public/assets/admin/dist/patternlock/patternLock.css" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('/')}}/public/assets/admin/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('/')}}/public/assets/admin/dist/css/style.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">

    <link href="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/summernote/dist/summernote.css" rel="stylesheet" type="text/css" />



    <link href="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />

    <link href="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />



    <style>
        form#login-form {
            color: red;
        }

        .error {
            color:rgb(232 121 121);
        }

        label#current_pattern_val-error {
    float: left;
}

label#new_pattern-error {
    float: left;
}

label#confirm_pattern-error {
    float: left;
}

table.dataTable thead .sorting,
table.dataTable thead .sorting_asc,
table.dataTable thead .sorting_desc {
    background : none !important
}
    </style>

  </head>
  <body>
    <!-- Preloader -->
    <div class="preloader-it">
      <div class="la-anim-1"></div>
    </div>
    <!-- /Preloader -->
    <style>
        span.switchery.switchery-default {
            border-radius: 20px!important;
            height: 20px!important;
            width: 33px!important;
        }


        .switchery>small{
            height: 20px!important;
            width: 20px!important;
        }
        td span.switchery.switchery-default + span.switchery.switchery-default{
            display: none;
        }



            /* Add custom CSS to disable the toggle button */
            .js-switch.tfa-tfa .bootstrap-switch-handle-on,
            .js-switch.tfa-tfa .bootstrap-switch-handle-off {
                pointer-events: none; /* Disable pointer events on the handles */
                opacity: 0.5; /* Reduce opacity to indicate disabled state */
            }
        </style>
