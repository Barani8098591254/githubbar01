@include('user.common.header')



<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">Forgot Pasword</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{URL::to('/')}}"><i class="far fa-home"></i> Home</a></li>
                <li class="active">Forgot Pasword</li>
            </ul>
        </div>
    </div>


    <div class="login-area pt-60 pb-60 ">
        <div class="container">
            <div class="col-md-5 mx-auto">
                <div class="login-form">
                    <div class="login-header mb-4">
                        <div class="site-heading text-center mb-0">
                            <h2 class="site-title">Forgot <span> Pasword</span></h2>
                            <div class="heading-divider"></div>

                        </div>
                    </div>
                    <form action="{{URL::to('')}}/resetPasssubmit" id="reset-form" class="form account__form account__form" method="post" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>New Password *</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter New Password ">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password *</label>
                            <input type="password" name="c_password" id="c_password" class="form-control" placeholder="Enter Confirm Password ">
                        </div>
                         <input type="hidden" name="link" id="link" value="<?php echo $link ?>">
                        <div class="d-flex align-items-center">

                            <button type="submit"  name="reset_btn" id="reset_btn" class="theme-btn reset_btn">Submit<i class="far fa-key"></i></button>
                            <button type="button" name="loader" id="loader" class="theme-btn loaders" style="display: none;">Loading ...</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>



@include('user.common.footer')
