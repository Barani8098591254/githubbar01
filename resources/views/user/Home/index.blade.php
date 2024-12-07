@include('user.common.header')


<body class="bg-white">

    {{-- <div class="preloader">
 <div class="loader">
 <div class="loader-box-1"></div>
 <div class="loader-box-2"></div>
 </div>
 </div> --}}


    <main class="home-3 main">

        <div class="hero-section ">
            <div class="hero-wrapper">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 col-lg-6">
                            <div class="hero-content">
                                <h6 class="hero-sub-title wow animate__animated animate__fadeInUp" data-wow-duration="1s"
                                    data-wow-delay=".25s">
                                    Safe and secure investment
                                </h6>
                                <h1 class="hero-title wow animate__animated animate__fadeInUp" data-wow-duration="1s"
                                    data-wow-delay=".50s">
                                    Best Hyip Investment <span>Solutions</span> For You
                                </h1>
                                <p class="wow animate__animated animate__fadeInUp" data-wow-duration="1s"
                                    data-wow-delay=".75s">
                                    There are many variations of passages available but the majority have suffered
                                    alteration in some form by injected humour or randomised words.
                                </p>
                                <div class="hero-btn wow animate__animated animate__fadeInUp" data-wow-duration="1s"
                                    data-wow-delay="1s">
                                    <a href="{{ URL::to('/signin') }}" class="theme-btn">Get Started</a>
                                    <!-- <div class="video-btn">
 <a href="https://www.youtube.com/watch?v=ckHzmP1evNU" class="play-btn popup-youtube"><i class="fas fa-play"></i></a>
 </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="hero-img wow animate__animated animate__fadeInRight" data-wow-duration="1s"
                                data-wow-delay=".25s">
                                <img src="{{ URL::to('/') }}/public/assets/user/img/hero/hero-3.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="hero-shape">
 <img src="assets/img/shape/shape-6.svg" alt="">
 </div> -->
            </div>
        </div>






        <div class="about-area pt-60 pb-60">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-left">
                            <div class="about-img">
                                <img src="{{ URL::to('/') }}/public/assets/user/img/about/02.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right">
                            <div class="site-heading mb-3">
                                <!-- <span class="site-title-tagline">About Us</span> -->
                                <h2 class="site-title">We Offer Best <span>Investment Solutions</span> For Your Profit
                                </h2>
                            </div>
                            <p class="about-text">There are many variations of passages of Lorem Ipsum available,
                                but the majority have suffered alteration in some form, by injected humour, or
                                randomised words which don't look even.</p>
                            <div class="about-list-wrapper">
                                <ul class="about-list list-unstyled">
                                    <li>
                                        <div class="icon"><span class="fas fa-check-circle"></span></div>
                                        <div class="text">
                                            <p>Take a look at our round up of the best shows</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon"><span class="fas fa-check-circle"></span></div>
                                        <div class="text">
                                            <p>It has survived not only five centuries</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon"><span class="fas fa-check-circle"></span></div>
                                        <div class="text">
                                            <p>Lorem Ipsum has been the ndustry standard dummy text</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ URL::to('aboutus') }}" class="theme-btn">Discover More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="feature-area pb-60 pt-10">
            <div class="container">
                <div class="feature-area-wrapper">
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="flaticon-approve"></i>
                                </div>
                                <div class="feature-content">
                                    <h5>Registered Company</h5>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="flaticon-security"></i>
                                </div>
                                <div class="feature-content">
                                    <h5>Secure Investment</h5>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item active">
                                <div class="feature-icon">
                                    <i class="flaticon-management"></i>
                                </div>
                                <div class="feature-content">
                                    <h5>Referral Program</h5>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="flaticon-megaphone"></i>
                                </div>
                                <div class="feature-content">
                                    <h5>24/7 Support</h5>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="invest-plan3 bg-2 py-110">
            <div class="container">
                <div class="invest-plan-wrapper pt-60 pb-30">
                    <div class="row">
                        <div class="col-lg-6 mx-auto">
                            <div class="site-heading text-center">
                                <!-- <span class="site-title-tagline">Plan</span> -->
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
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>
                <center>
                    <a href="{{ URL::to('investPlan') }}" class="high-plan theme-btn mb-4">More Plan</a>
                </center>
            </div>
        </div>
        </div>
        </div>


        <div class="profit-calculator pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <!-- <span class="site-title-tagline">Profit Calculator</span> -->
                            <h2 class="site-title">Calculate Your <span>Profit</span></h2>
                            <div class="heading-divider"></div>
                            <p>
                                It is a long established fact that a reader will be distracted by the readable content
                                of a page when looking at its layout.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="profit-calculator-form1">
                            <form action="#">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group mt-0">
                                            <label class="d-block">Your Plan</label>
                                            <select class="select" id="selectedPlanId" name="selectedPlanId">
                                                @php foreach ($plan as $key => $value) { @endphp
                                                    <option value="<?php echo $value->id; ?>" ><?php echo $value->name; ?></option>
                                                   @php } @endphp
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group mt-md-0">
                                            <label class="d-block">Currency</label>
                                                <select class="select" id="">
                                                @php foreach ($currencyList as $key => $value) { @endphp
                                                    <option value="<?php echo $value->id; ?>" ><?php echo $value->symbol.' -'.$value->name; ?></option>
                                                   @php } @endphp
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label>Invest Amount ($)</label>
                                            <input type="text" class="form-control" id="price" placeholder="Investment Amount" readonly>

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label>Direct Commission ($)</label>
                                            <input type="text" class="form-control" id="directCommission" placeholder="Direct Commission" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label>Daily ROI ($)</label>
                                            <input type="text" class="form-control" id="roi_commission" placeholder="Daily ROI" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label>Level 1 Commission ($)</label>
                                            <input type="text" class="form-control" placeholder="25%" id="level1Commission" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Level 2 Commission ($)</label>
                                            <input type="text" readonly="" class="form-control"
                                                placeholder="2,000" id="level2Commission" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Return</label>
                                            <input type="text" readonly="" class="form-control" id="roitotal"
                                                placeholder="500" readonly>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profit-calculator-img">
                            <img src="{{ URL::to('/') }}/public/assets/user/img/calculator/01.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <div class="transaction bg-2 pt-80 pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <!-- <span class="site-title-tagline">Transaction</span> -->
                            <h2 class="site-title">Our <span>Transaction</span></h2>
                            <div class="heading-divider"></div>
                            <p>
                                It is a long established fact that a reader will be distracted by the readable content
                                of a page when looking at its layout.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="transaction-wrapper">
                        <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="transaction-tab1" data-bs-toggle="pill"
                                    data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1"
                                    aria-selected="true">Latest Deposits</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="transaction-tab2" data-bs-toggle="pill"
                                    data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2"
                                    aria-selected="false">Latest Withdraw</button>
                            </li>

                        </ul>
                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                aria-labelledby="transaction-tab1">
                                <div class="transaction-content">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Investors</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Currency</th>
                                                    <th scope="col">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($depositList) > 0)
                                                @foreach ($depositList as $key => $value)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="transaction-investor">
                                                                <img src="assets/img/investor/is-1.jpg"
                                                                    alt="">
                                                                <span>{{ getuserName($value->user_id) }}</span>
                                                            </div>
                                                        </th>
                                                        <td>
                                                            <span
                                                                class="transaction-amount">{{ $value->amount }}</span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="transaction-currency">{{ $value->currency }}</span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="transaction-date">{{ date('d M Y h:i A', strtotime($value->created_at)) }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @else
                                                    <tr class="no-records">



                                                        <td colspan="5">
                                                            <div class="transaction-investor ">

                                                                <span>Record Not Found !!</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab2" role="tabpanel"
                                aria-labelledby="transaction-tab2">
                                <div class="transaction-content">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Investors</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Currency</th>
                                                    <th scope="col">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 @if(count($WithdrawReqList) > 0)
                                                @foreach ($WithdrawReqList as $key => $value)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="transaction-investor">
                                                                <img src="assets/img/investor/is-1.jpg"
                                                                    alt="">
                                                                <span>{{ getuserName($value->user_id) }}</span>
                                                            </div>
                                                        </th>
                                                        <td>
                                                            <span
                                                                class="transaction-amount">{{ $value->amount }}</span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="transaction-currency">{{ $value->currency }}</span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="transaction-date">{{ date('d M Y h:i A', strtotime($value->created_at)) }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @else
                                                    <tr class="no-records">
                                                        <td colspan="5">

                                                            <div class="transaction-investor">

                                                                <span>Record Not Found !!</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


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
                            <!-- <span class="site-title-tagline">Working Process</span> -->
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
                            <h4>Choose Plan</h4>
                            <p>It is a long established fact that a reader will be distracted.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center mb-30">
                        <div class="process-single">
                            <div class="icon">
                                <span>03</span>
                                <i class="flaticon-approve"></i>
                            </div>
                            <h4>Confirm Plan</h4>
                            <p>It is a long established fact that a reader will be distracted.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center mb-30">
                        <div class="process-single">
                            <div class="icon">
                                <span>04</span>
                                <i class="flaticon-wallet"></i>
                            </div>
                            <h4>Get Profit</h4>
                            <p>It is a long established fact that a reader will be distracted.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="choose-area bg-2 pt-80 pb-80">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="choose-content">
                            <div class="site-heading mb-3">
                                <!-- <span class="site-title-tagline">Why Choose Us</span> -->
                                <h2 class="site-title my-3">Invest For Your <span>Future In Best</span> Platform</h2>
                            </div>
                            <p class="about-text">There are many variations of passages of Lorem Ipsum available,
                                but the majority have suffered alteration in some form, by injected humour, or
                                randomised words which don't look even.</p>
                            <ul>
                                <li>
                                    <div class="choose-content-wrapper">
                                        <i class="flaticon-management"></i>
                                        <div class="choose-content-item">
                                            <h5>Our experience</h5>
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
                                            <h5>Certified company</h5>
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
                                            <h5>Quick Withdrawal</h5>
                                            <p class=" experience">
                                                It is a long established fact that a reader will be distracted.
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <a href="{{ URL::to('/signin') }}" class="theme-btn">Get Started</a>
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







        <div class="container pt-60 pb-60">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-6">
                    <div class="cta-area">
                        <div class="container">
                            <div class="row">
                                <div class="cta-content">
                                    <h5>We Offer More Commission</h5>
                                    <h2>Get <span>45%</span> Referral Commission</h2>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content </p>
                                    <a href="{{ URL::to('/signin') }}" class="theme-btn">Get Started</a>
                                </div>
                            </div>
                        </div>
                        <div class="cta-shape">
                            <img src="assets/img/shape/shape-3.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="payment-area ">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 mx-auto">
                                    <div class="site-heading text-center mb-3">
                                        <!-- <span class="site-title-tagline">Payment</span> -->
                                        <h2 class="site-title d-flex high-Payment">Payment <span class="px-3">Methods</span></h2>
                                        <div class="heading-divider"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="cta-content">
                                <p>It is a long established fact that a reader will be distracted by the readable
                                    content </p>
                                <a href="{{ URL::to('/signin') }}" class="theme-btn">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>





    </main>


    @include('user.common.footer')





    <script>
        $("#mail-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
            },
            messages: {
                email: {
                    required: "Enter a valid Email ID",
                },
            },
            submitHandler: function(form) {
                var $form = $(form);

                $("#loader-fgt").show();
                $("#fgt_btn").hide();

                $.ajax({
                    url: base_url + "resendmailactive",
                    type: "POST",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: true,
                    success: function(data) {
                        var res = JSON.parse(data);

                        if (res.status === 1) {
                            toastr.success(res.msg, 'Success', {
                                timeOut: 2000
                            });
                            setTimeout(function() {
                                window.location.href = base_url + 'sign-in';
                            }, 1000);
                        } else {
                            toastr.error(res.msg, {
                                timeOut: 2000
                            });
                        }

                        $("#loader-fgt").hide();
                        $("#fgt_btn").show();
                    },
                });
            },
        });
    </script>




<script>
    $(document).ready(function () {
        $('.select[name="selectedPlanId"]').on('change', function () {
            var selectedPlanId = $(this).val();
            var dataString = {id: selectedPlanId, plan_id:selectedPlanId }

            $.ajax({
                url: base_url + "fetch-data",
                type: 'POST',
                data: dataString,
            cache:false,
            async:true,
            beforeSend: function() {
                $('.sendOtp').hide();
                $('.otpLoading').show();

            },
                success: function (data) {
                    if (data.error) {

                        // alert(data.error);

                        toastr.error(data.error, {timeOut: 2000});
                    } else {
                        $('#price').val(data.price);
                        $('#directCommission').val(data.directCommission);
                        $('#roi_commission').val(data.roi_commission);
                        $('#level1Commission').val(data.level1Commission);
                        $('#level2Commission').val(data.level2Commission);
                        $('#roitotal').val(data.roitotal);



                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);

                }
            });
        });
    });
    </script>
