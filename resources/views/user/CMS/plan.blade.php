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


        <div class="invest-plan pt-60 pb-60">
            <div class="container">
                <div class="invest-plan-wrapper">
                    <div class="row">
                        <div class="col-lg-6 mx-auto">
                            <div class="site-heading text-center">
                                <h2 class="site-title">Investment <span>Plan</span></h2>
                                <div class="heading-divider"></div>
                                <p>
                                    It is a long established fact that a reader will be distracted by the readable
                                    content
                                    of a page when looking at its layout.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @php
                        // Define an array of colors
                        $colors = ['plan-color-1', 'plan-color-2', 'plan-color-3', 'plan-color-5','plan-color-6','plan-color-7','plan-color-8'];
                    @endphp

                    @foreach ($planList as $index => $data)
                        @php
                            // Get the color for the current plan based on the index
                            $colorClass = $colors[$index % count($colors)];
                        @endphp
                        <div class="col-md-6 col-lg-3">
                            <div class="plan-item {{ $colorClass }}">
                                <h4 class="plan-title">{{$data['name']}}</h4>
                                <div class="plan-rate">
                                    <h6 class="plan-price">$ {{number_format($data['price'],2)}}</h6>
                                    {{-- <span class="plan-price-type">ROI for Daily</span> --}}
                                </div>
                                <div class="plan-item-list">
                                    <ul>
                                        <li>Today ROI <?php echo $data['roi_commission']; ?> %</li>
                                        <li>Monthly ROI 5% to upto 15%</li>
                                    </ul>
                                </div>
                                <?php if(userId()){
                                    $link = URL::to('/Investment');
                                }else{
                                    $link = URL::to('/signup');

                                } ?>
                                <a href="{{$link}}" class="plan-btn">Invest Now</a>
                            </div>
                        </div>
                    @endforeach

                    </div>
                </div>
            </div>
        </div>

    </main>


    @include('user.common.footer')



