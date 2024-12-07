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

    </div>


    <div class="affiliate-area pt-60 pb-60">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="affiliate-img">
                        <img src="{{ URL::to('/') }}/public/assets/user/img/affiliate/01.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="affiliate-content">
                        <div class="site-heading mb-3">

                            <h2 class="site-title">Make money with <span>Hyiptox</span></h2>
                        </div>
                        <p>There are many variations of passages of Lorem Ipsum available,
                            but the majority have suffered alteration in some form, by injected humour, or
                            randomised words which don't look even.</p>
                        <div class="row py-5">
                            <div class="col-md-4">
                                <div class="affiliate-item">
                                    <div class="affiliate-percentage">
                                        <h1>50 <span>%</span></h1>
                                        <span>Level 01</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="affiliate-item">
                                    <div class="affiliate-percentage">
                                        <h1>10 <span>%</span></h1>
                                        <span>Level 02</span>
                                    </div>
                                </div>
                            </div>
                 <!--            <div class="col-md-4">
                                <div class="affiliate-item">
                                    <div class="affiliate-percentage">
                                        <h1>40 <span>%</span></h1>
                                        <span>Level 03</span>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <?php if(userId()){
                                    $link = URL::to('/affiliate');
                                }else{
                                    $link = URL::to('/signup');

                        } ?>
                        <a href="{{$link}}" class="theme-btn">Join Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="process-area pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <h2 class="site-title">How It <span>Works</span></h2>
                        <div class="heading-divider"></div>
                        <p>
                            It is a long established fact that a reader will be distracted by the readable content
                            of a page when looking at its layout.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-lg-3 col-md-6 text-center mb-30">
                    <div class="process-single">
                        <div class="icon">
                            <span>01</span>
                            <i class="flaticon-management"></i>
                        </div>
                        <h4>Create Account</h4>
                        <p>It is a long established fact that a reader will be distracted.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center mb-30">
                    <div class="process-single">
                        <div class="icon">
                            <span>02</span>
                            <i class="flaticon-security"></i>
                        </div>
                        <h4>Join Program</h4>
                        <p>It is a long established fact that a reader will be distracted.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center mb-30">
                    <div class="process-single">
                        <div class="icon">
                            <span>03</span>
                            <i class="flaticon-approve"></i>
                        </div>
                        <h4>Promote Plan</h4>
                        <p>It is a long established fact that a reader will be distracted.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center mb-30">
                    <div class="process-single">
                        <div class="icon">
                            <span>04</span>
                            <i class="flaticon-wallet"></i>
                        </div>
                        <h4>Earn Many</h4>
                        <p>It is a long established fact that a reader will be distracted.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="cta-area">
        <div class="container">
            <div class="row">
                <div class="cta-content">
                    <h5>We Offer More Commission</h5>
                    <h2>Get <span>5%</span> Referral Commission</h2>
                    <p>It is a long established fact that a reader will be distracted by the readable content <br> of a
                        page when looking at its layout.</p>
                        <?php if(userId()){
                                    $link = URL::to('/dashboard');
                                }else{
                                    $link = URL::to('/signup');

                        } ?>
                    <a href="{{$link}}" class="theme-btn">Get Started</a>
                </div>
            </div>
        </div>
        <div class="cta-shape">
            <img src="{{ URL::to('/') }}/public/assets/user/img/shape/shape-3.png" alt="">
        </div>
    </div>


    <div class="choose-area pt-60 pb-60">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="choose-content">
                        <div class="site-heading mb-3">

                            <h2 class="site-title my-3">Why Should You <span>Join Hyiptox</span> Affiliate</h2>
                        </div>
                        <p>There are many variations of passages of Lorem Ipsum available,
                            but the majority have suffered alteration in some form, by injected humour, or
                            randomised words which don't look even.</p>
                        <ul>
                            <li>
                                <div class="choose-content-wrapper">
                                    <i class="flaticon-management"></i>
                                    <div class="choose-content-item">
                                        <h5>Create Account Free</h5>
                                        <p class=" experience">
                                            It is a long established fact that a reader will be distracted.
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="choose-content-wrapper">
                                    <i class="flaticon-approve"></i>
                                    <div class="choose-content-item">
                                        <h5>Instant Payout</h5>
                                        <p class=" experience">
                                            It is a long established fact that a reader will be distracted.
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="choose-content-wrapper">
                                    <i class="flaticon-wallet"></i>
                                    <div class="choose-content-item">
                                        <h5>Top Rate Commission</h5>
                                        <p class=" experience">
                                            It is a long established fact that a reader will be distracted.
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                         <?php if(userId()){
                                    $link = URL::to('/dashboard');
                                }else{
                                    $link = URL::to('/signup');

                        } ?>
                        <a href="{{$link}}" class="theme-btn">Get Started</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="choose-img">
                        <img src="{{ URL::to('/') }}/public/assets/user/img/choose/01.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>


@include('user.common.footer')
