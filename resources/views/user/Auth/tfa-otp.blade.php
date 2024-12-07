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



    <div class="login-area pt-60 pb-60 tfa_otp_section" id="tfa_otp_section" name="tfa_otp_section">
        <div class="container">
            <div class="col-md-5 mx-auto">
                <div class="login-form">
                    <div class="login-header mb-4">
                        <div class="site-heading text-center mb-0">
                            <h2 class="site-title">Login  <span>OTP</span></h2>
                            <div class="heading-divider"></div>

                        </div>
                    </div>
                    <form action="#" id="tfa-form" name="tfa-form" class="form  tfa_otp_section" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Enter TFA *</label>

                            <input type="password"  name="tfa_code" id="tfa_code" class="form-control" placeholder="Enter TFA Code *" autocomplete="off">

                        </div>
                        <input type="hidden" name="user_id" id="user_id" class="user_id" value="">
                        <div class="d-flex align-items-center">

                            <button type="submit"  name="tfa_btn" id="tfa_btn" class="theme-btn tfa_btn">Submit<i class="far fa-key"></i></button>
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









<script>
    $("#tfa-form").validate({
  // Specify validation rules
  rules: {
    tfa_code: {
      required: true,
      minlength : 6,
      maxlength : 6,
    },

  },
  messages : {

    tfa_code : {
      required : "Please Enter TFA"
    },

  },
  submitHandler: function(form) {

      $(".tfa-form").load("submit", function (e){
          $.ajax({
              url: base_url + "tfalogin",
              type: "POST",
              data: new FormData(this),
               processData:false,
               contentType:false,
               cache:false,
               async:true,
              beforeSend: function() {
                  $('#tfa_btn').hide();
                  $('.loader').show();
              },
              success: function (data) {

                var res = JSON.parse(data);

                  if(res.status == 1){

                      $('.loader').hide();
                      $('#tfa_btn').show();
                      $('#tfa_otp_section').hide();
                      $('#login_otp_section').show();
                      $('#user_id').val(res.user_id);



                      // $.notify(res.msg, {className: 'success',clickToHide: true,});
                      toastr.success(res.msg, {timeOut: 2000});


                  }else{

                    $('.loader').hide();
                    $('#tfa_btn').show();
                    $('.otp-form')[0].reset();
                  //   $.notify(res.msg, {className: 'error',clickToHide: true,});
                    toastr.error(res.msg, {timeOut: 2000});


                  }


              }
          });
      });

  },

});
</script>
