@include('user.common.header')


<body>

    <div class="preloader">
        <div class="loader">
            <div class="loader-box-1"></div>
            <div class="loader-box-2"></div>
        </div>
    </div>



    <main class="main">

        <div class="site-breadcrumb">
            <div class="container">
                <h2 class="breadcrumb-title">{{$title}}</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ URL::to('/') }}"><i class="far fa-home"></i> Home</a></li>
                    <li class="active">{{$subTitle}}</li>
                </ul>
            </div>
        </div>


        <p>{!! check_static(1) !!}</p>




        <p>{!! check_static(2) !!}</p>



        <p>{!! check_static(3) !!}</p>



    </main>


    @include('user.common.footer')
