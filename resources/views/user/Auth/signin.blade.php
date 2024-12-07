@include('user.common.header')


<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">Sign In</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{URL::to('/')}}"><i class="far fa-home"></i> Home</a></li>
                <li class="active">Sign In</li>
            </ul>
        </div>

    </div>


    <div class="login-area pt-70 pb-70">
        <div class="container">
            <div class="col-md-5 mx-auto">
                <div class="login-form">
                    <div class="login-header mb-4">
                        <div class="site-heading text-center mb-0">
                            <!-- <span class="site-title-tagline">Plan</span> -->
                            <h2 class="site-title">Sign <span>In</span></h2>
                            <div class="heading-divider"></div>

                        </div>
                    </div>
                    <form action="#" id="signin-form" class="signin-form form account__form" method="post" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email"  name="email" id="email" class="form-control sign-inForms" placeholder="Enter Your Email">
                        </div>
                        <div class="form-group">
                            <label>Password *</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password ">
                            <span class="eye-icon" onclick="togglePasswordVisibility('password')">
                            <span class="icon">
                            <i id="eye-icon-password" class="fas fa-eye-slash"></i>
                            </span>
                            </span>
                            </div>

                        <div class="d-flex justify-content-between mb-4">
                            {{-- <div class="form-check">
                                <input class="form-check-input"  value="" id="remember">
                                <label class="form-check-label" for="remember">
                                    Resend Mail
                                </label>
                            </div> --}}
                            <a href="{{URL::to('resendmail')}}" class="forgot-pass">Resend Mail?</a>


                            <a href="{{URL::to('forgotpassword')}}" class="forgot-pass">Forgot Password?</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="submit" name="login_btn" id="login_btn" class="theme-btn login_btn">Login <i class="far fa-signin"></i></button>
                            <button type="button" name="loader" id="loader" class="theme-btn" style="display: none;">Loading ...</button>
                        </div>
                    </form>

                    <div class="login-footer">
                        <p>Don't have an account? <a href="{{URL::to('signup')}}">Register</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>






</main>

@include('user.common.footer')

<script type="text/javascript">
    $('.sign-inForms').attr('autocomplete', 'off');

</script>
