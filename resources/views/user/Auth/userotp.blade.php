@include('user.common.header')



<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">Login OTP</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{URL::to('/')}}"><i class="far fa-home"></i> Home</a></li>
                <li class="active">Login OTP</li>
            </ul>
        </div>
    </div>



    <div class="login-area pt-60 pb-60 ">
        <div class="container">
            <div class="col-md-5 mx-auto">
                <div class="login-form">
                    <div class="login-header mb-4">
                        <div class="site-heading text-center mb-0">
                            <h2 class="site-title">Login  <span>OTP</span></h2>
                            <div class="heading-divider"></div>

                        </div>
                    </div>
                    <form action="#" id="otp-form" class="form account__form otp-form" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Enter Login OTP *</label>
                            <input type="password" name="code" id="code" class="form-control" placeholder="Enter Login OTP ">
                        </div>
                        <input type="hidden" name="user_id" id="user_id" class="user_id" value="">
                        <div class="d-flex align-items-center">

                            <button type="submit"  name="otp_btn" id="otp_btn" class="theme-btn otp_btn">Submit<i class="far fa-key"></i></button>
                            <button type="button" name="loaders" id="loaders" class="theme-btn loaders" style="display: none;">Loading ...</button>

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
