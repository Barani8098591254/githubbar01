@include('user.common.header')



<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">Resend Activation Email</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{URL::to('/')}}"><i class="far fa-home"></i> Home</a></li>
                <li class="active">Resend Activation Email</li>
            </ul>
        </div>
    </div>



    <div class="login-area pt-60 pb-60 ">
        <div class="container">
            <div class="col-md-5 mx-auto">
                <div class="login-form">
                    <div class="login-header mb-4">
                        <div class="site-heading text-center mb-0">
                            <h2 class="site-title">Resend <span> Activation Email</span></h2>
                            <div class="heading-divider"></div>

                        </div>
                    </div>
                    <form action="#" id="mail-form" class="form account__form mail-form" method="post" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email">
                        </div>
                        <div class="d-flex align-items-center">

                            <button type="submit"  name="fgt_btn" id="fgt_btn" class="theme-btn fgt_btn">Resend Mail<i class="far fa-key"></i></button>
                            <button type="button" name="loader-fgt" id="loader-fgt" class="theme-btn loader-fgt" style="display: none;">Loading ...</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>



@include('user.common.footer')
