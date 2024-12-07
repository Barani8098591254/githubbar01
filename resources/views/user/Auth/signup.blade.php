@include('user.common.header')



<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">Register</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{URL::to('/')}}"><i class="far fa-home"></i> Home</a></li>
                <li class="active">Register</li>
            </ul>
        </div>

    </div>


    <div class="login-area  pt-70 pb-70">
        <div class="container">
            <div class="col-md-6 mx-auto">
                <div class="login-form">


                    <div class="login-header mb-4">
                        <div class="site-heading text-center mb-0">
                            <h2 class="site-title">Sign <span>Up</span></h2>
                            <div class="heading-divider"></div>

                        </div>
                    </div>
                    <form action="#" id="signup-form" class="signup-form form account__form" method="post" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="row mb-0">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Full Name *</label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder=" Enter Your Name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email Address *</label>
                                    <input type="email"  name="email" id="email" class="form-control" placeholder=" Enter Your Email">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Password *</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password ">
                                    <span class="eye-icon" onclick="togglePasswordVisibility('password')">
                                        <span class="icon">
                                        <i id="eye-icon-password" class="fas fa-eye-slash"></i>
                                        </span>
                                        </span>
                                        <label id="password-error" class="error" for="password"></label>
                                    </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Confirm Password *</label>
                                    <input type="password" name="c_password" id="c_password" class="form-control" placeholder="Confirm Password ">
                                    <span class="eye-icon" onclick="togglePasswordVisibility('c_password')">
                                    <span class="icon">
                                    <i id="eye-icon-c_password" class="fas fa-eye-slash"></i>
                                    </span>
                                    </span>
                                    <label id="c_password-error" class="error" for="c_password"></label>
                                    </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Mobile Number *</label>
                                    <input type="text" name="mobNumber" id="mobNumber" class="form-control" placeholder="Enter Your Number">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Referral code *</label>
                                    <input type="text" name="referral_code" id="referral_code" class="form-control" placeholder="Enter Your code" value="{{ @$refeerralLink }}"  <?php echo ($refeerralLink) ? "readonly" : "" ?> >
                                </div>
                            </div>


                        </div>

                        <div class="form-check form-group">
                            <input class="form-check-input" type="checkbox" value="" id="agree" name="agree">
                            <label class="form-check-label" for="agree">
                                I agree with the <a target="_blank" href="{{URL::to('termsofservice')}}">Terms Of Service</a>
                            </label><br>
                            <label id="agree-error" class="error" for="agree"></label>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="submit" name="signup" id="signup" class="theme-btn ">Register <i class="far fa-paper-plane"></i></button>
                            <button type="button" name="loader" id="loader" class="theme-btn" style="display: none;">Loading ...</button>
                        </div>
                        <div class="login-footer">
                            <p>Already have an account? <a href="{{URL::to('signin')}}">Login</a></p>
                        </div>
                    </form>







                </div>
            </div>
        </div>
    </div>

</main>

@include('user.common.footer')
