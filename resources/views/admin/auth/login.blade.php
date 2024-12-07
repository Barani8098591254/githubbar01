@include('admin.common.loginheader')

<div class="wrapper pa-0">
    <header class="sp-header">
      <div class="sp-logo-wrap pull-left">
        <a href="admin">

          {{-- <img class="brand-img mr-10" src="../public/assets/admin/dist/img/logo.png" alt="brand" /> --}}

        </a>
      </div>

      <div class="clearfix"></div>
    </header>
    <!-- Main Content -->
    <div class="page-wrapper pa-0 ma-0 auth-page">
      <div class="container-fluid">
        <!-- Row -->
        <div class="table-struct full-width full-height">
          <div class="table-cell vertical-align-middle auth-form-wrap">
            <div class="auth-form  ml-auto mr-auto no-float">
              <div class="row">
                <div class="col-sm-12 col-xs-12">
                  <div class="mb-30">
                    <h3 class="text-center txt-dark mb-10">Sign in </h3>
                  </div>
                  <div class="form-wrap">
                    <form action="" name="login-form" id="login-form"  autocomplete="off" method="Post" class="login-form">
                    @csrf
                      <div class="form-group">
                        <label class="control-label mb-10" for="">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                      </div>
                      <div class="form-group">
                        <label class="pull-left control-label mb-10" for="">Password</label>
                        <div class="clearfix"></div>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                      </div>

                         <div class="form-group">
                          <label class="pull-left control-label mb-10" for="exampleInputpwd_2">Email OTP</label>
                          <div class="clearfix"></div>
                          <input type="password" class="form-control"  id="otp" name="otp" placeholder="Enter OTP">
                          <label class="pull-right control-label mb-10 sendOtp" style="text-decoration: underline; color: blue; cursor: pointer;" onclick="sendotp();">Send OTP</label>

                          <label class="pull-right control-label mb-10 otpLoading" style="display:none">Loading...</label>


                      </div>

                      <div class="form-group">
                        <label class="pull-left control-label mb-10" for="exampleInputpwd_2">Pattern</label>
                      </div>
                      <div class="pattern-card">
                        <div class="form-group">
                          <div class="clearfix"></div>
                          <div id="pattern1_container" class="pattern_container col-4">
                            <div id="pattern1" name="pattern1" class="" style="margin: 0 auto;"></div>
                          </div>
                        </div>

                        <a class="capitalize-font txt-primary block mb-10 pull-right font-12 mr-45" href="void:javascript(0)"  onclick="reset_pattern();">Reset Pattern</a>

                      </div>
                      <input type="hidden" value="" id="pattern_val" name="pattern_val">

                      <div class="container">
                        <div class="row">
                          <div class="col-lg-4">

                            <div class="form-group text-center">
                                <button style="display: none;" type="button" name="loader" id="loader" class="btn btn-info btn-success btn-rounded ">Loading ... </button>

                                <button type="submit" name="login_btn" id="login_btn" class="btn btn-info btn-success btn-rounded login_btn">sign in</button>
                            </div>

                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('admin.common.loginfooter')


