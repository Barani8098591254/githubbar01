@include('user.common.header')


<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ URL::to('/') }}"><i class="far fa-home"></i> Home</a></li>
                <li class="active">{{$subTitle}}</li>
            </ul>
        </div>
        <!-- <div class="breadcrumb-shape">
<img src="assets/img/shape/shape-5.svg" alt="">
</div> -->
    </div>

    <p>{!! check_static(5) !!}</p>

</main>

@include('user.common.footer')
