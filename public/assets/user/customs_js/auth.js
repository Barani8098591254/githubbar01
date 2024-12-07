$(document).ready(function(){


$.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
});

$.validator.addMethod( "lettersonly", function( value, element ) {
  return this.optional( element ) || /^[a-z\s-a-záéíóúý]+$/i.test( value );
}, "Letters Only Please" );

$.validator.addMethod("pwcheck", function(value) {
  return (/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{8,16}$/.test(value));
});

jQuery.validator.addMethod("noSpace", function(value, element) {
    return value.indexOf(" ") < 0 && value != "";
}, "No space please and don't leave it empty");

$.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z0-9]+$/);
});


  $("#signup-form").validate({
    // Specify validation rules
    ignore: ".ignore",
    rules: {
      username: {
        required : true,
        alpha : true,
        // lettersonly : true,
        minlength : 5,
        maxlength : 15,
      },
      mobNumber: {
        required : true,
        number : true,
        minlength : 8,
        maxlength : 12,
      },
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        pwcheck : true,
        minlength:8,

      },
      c_password: {
        required: true,
        equalTo:'#password',
      },
      referral_code:{
        required: true,
      },
      address : {
        required: true,
        noSpace:true,
        alpha:true,
        minlength : 40,
        maxlength : 43,
      },
      agree:{
        required: true,
      },

    },
    messages : {
        username: { required : "Please enter username",
        alpha : "Letters only please"
      },

      mobNumber : {
        required : "Please enter your mobile number"
      },

      email : {
        required : "Please enter your email id"
      },
      password: {
          required : "Please enter a password",
          pwcheck : "Password length must be 8-16 characters and contain an uppercase letter, lowercase letter, number and special character. spaces are not allowed."
      },

      c_password : {
          required : "Please enter a confirm password",
          equalTo : "Our password and confirmation password do not match.!",
      },

      referral_code : {
          required : "Please enter a referral code",
      },
      address : {
         required : "Please enter trust wallet address",
      },
      agree:{
          required : "Please click tearms and condition",
      }


    },
    submitHandler: function(form) {

        $('.signup').attr("disabled", true);
        $(".signup-form").load("submit", function (e){
              $.ajax({
                url: base_url+"signup",
                type: "POST",
                data: new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:true,
                beforeSend: function() {
                    $('#signup').hide();
                    $('#loader').show();
                },
                success: function (data) {

                  var res = JSON.parse(data);

                    if(res.status == 1){
                        $('#signup').attr("disabled", false);
                        $('#loader').hide();
                        $('#signup').show();
                        $('.signup-form')[0].reset();
                        toastr.success(res.msg, 'Success', {timeOut: 2000});
                        setTimeout(function() {
                            window.location.href = base_url+'signin';
                         }, 2000);

                    }else{
                      $('#signup').attr("disabled", false);
                      $('#loader').hide();
                      $('#signup').show();
                      toastr.error(res.msg, {timeOut: 2000});


                    }


                }
            });
        });

    },

  });

});



  $("#signin-form").validate({
    // Specify validation rules
    ignore: ".ignore",
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
      },


    },
    messages : {

      email : {
        required : "Please enter email id"
      },
      password: {
          required : "Please enter password",
      },

    },
    submitHandler: function(form) {

        // alert('hii');


        $('.login_btn').attr("disabled", true);
        // alert(base_url);
        $(".signin-form").load("submit", function (e){
            $.ajax({
                url: base_url + "signin",
                type: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: true,
                beforeSend: function () {
                $('#login_btn').hide();
                $('#loader').show();
                 },
                success: function (data) {

                  var res = JSON.parse(data);

                    if(res.status == 1){
                        $('.login_btn').attr("disabled", false);
                        // $('#loader').hide();
                        // $('#login_btn').show();
                        // $('.login-form')[0].reset();
                        $('#login_otp_section').show();
                        $('#login_section').hide()
                        $('.user_id').val(res.user_id);

                        toastr.success(res.msg, 'Success', {timeOut: 2000});
                        setTimeout(function() {
                            window.location.href = base_url+'userotp';
                         }, 2000);

                    }else if(res.status == 2){

                        // $('.login_btn').attr("disabled", false);
                        // $('#loader').hide();
                        // $('#login_btn').show();
                        // $('#tfa_otp_section').show();

                        // $('#login_section').hide();
                        // $('.user_id').val(res.user_id);


                        $('.login_btn').attr("disabled", false);
                        $('#loader').hide();
                        $('#login_btn').show();
                        $('#tfa_otp_section').show();
                        $('#login_section').hide();
                        $('.user_id').val(res.user_id);

                        toastr.success(res.msg, 'Success', {timeOut: 2000});

                        setTimeout(function() {
                            window.location.href = base_url+'dashboard';
                         }, 2000);

                    }else{
                      $('.login_btn').attr("disabled", false);
                      $('#loader').hide();
                      $('#login_btn').show();
                      toastr.error(res.msg, {timeOut: 2000});


                    }
                }
            });
        });

    },

  });


  // OTP Login

    $("#otp-form").validate({
    // Specify validation rules
    rules: {
      code: {
        required: true,

      },

    },
    messages : {

      code : {
        required : "Please enter login otp"
      },

    },
    submitHandler: function(form) {

        $(".otp-form").load("submit", function (e){
            $.ajax({
                url: base_url+"verification",
                type: "POST",
                data: new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:true,
                beforeSend: function() {
                    $('.loaders').show();
                    $('.otp_btn').hide();
                },
                success: function (data) {

                  var res = JSON.parse(data);

                    if(res.status == 1){


                        $('#login_otp_section').show();
                        toastr.success(res.msg, 'Success', {timeOut: 2000});


                        setTimeout(function() {
                            window.location.href = base_url+'dashboard';
                         }, 1000);

                    }else{

                      $('.loaders').hide();
                      $('.otp_btn').show();
                      $('.otp-form')[0].reset();
                      toastr.error(res.msg, {timeOut: 2000});

                    }


                }
            });
        });

    },

  });



 $('.forgot_link').click(function(){
    $('#login_section').hide();
    $('#login_otp_section').hide();
    $('#tfa_otp_section').hide();
    $('#resend_section').hide();
    $('#forgot_section').show();
 });


 $("#forgot-form").validate({
    rules: {
      email: {
        required: true,
        email : true,
      },
    },
    messages : {

      email : {
        required : "Please enter the valid register email id",
      },

    },
    submitHandler: function(form) {

        $(".forgot-form").load("submit", function (e){
            $.ajax({
                url: base_url+"forgetpw",
                type: "POST",
                data: new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:true,
                beforeSend: function() {
                    $('#fgt_btn').hide();
                    $('.loader-fgt').show();
                },
                success: function (data) {

                  var res = JSON.parse(data);

                    if(res.status == 1){

                        $('.loader-fgt').hide();
                        $('#fgt_btn').show();
                        $('#login_section');
                        toastr.success(res.msg, 'Success', {timeOut: 2000});
                         setTimeout(function() {
                            window.location.href = base_url+'signin';
                         }, 1000);

                    }else{

                      $('.loader-fgt').hide();
                      $('#fgt_btn').show();
                      $('.forgot-form')[0].reset();
                      toastr.error(res.msg, {timeOut: 2000});

                    }


                }
            });
        });

    },

  });





 $('.mail_link').click(function(){
    $('#login_section').hide();
    $('#login_otp_section').hide();
    $('#tfa_otp_section').hide();
    $('#resend_section').hide();
    $('#mail_section').show();
 });



  $("#mail-form").validate({
    rules: {
      email: {
        required: true,
        email : true,
      },
    },
    messages : {

      email : {
        required : "Please enter the valid register email id",
      },

    },
    submitHandler: function(form) {

        $(".mail-form").load("submit", function (e){
            $.ajax({
                url: base_url+"resendmailactive",
                type: "POST",
                data: new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:true,
                beforeSend: function() {
                    $('.fgt_btn').hide();
                    $('.loader-fgt').show();
                },
                success: function (data) {

                    var res = JSON.parse(data);

                      if(res.status == 1){

                          $('.loader-fgt').hide();
                          $('.fgt_btn').show();
                          $('.login_section');
                          toastr.success(res.msg, 'Success', {timeOut: 2000});
                           setTimeout(function() {
                              window.location.href = base_url+'signin';
                           }, 1000);

                      }else{

                        $('.loader-fgt').hide();
                        $('.fgt_btn').show();
                        $('.mail-form')[0].reset();
                        toastr.error(res.msg, {timeOut: 2000});

                      }


                  }
            });
        });

    },

  });



 $("#reset-form").validate({
    // Specify validation rules
    rules: {
      password: {
        required: true,
        pwcheck : true,
        minlength:8,
      },
      c_password: {
        required: true,
        equalTo:'#password',
      },

    },
    messages : {

      password : {
        required : "Please enter a password",
          pwcheck : "Password length must be 8-16 characters and contain an uppercase letter, lowercase letter, number and special character. spaces are not allowed."
      },
      c_password: {
          required : "Please enter a confirm password",
          equalTo : "your password and confirmation password do not match.!",
      },

    },
    submitHandler: function(form) {

        $('#reset_btn').hide();
        $('.loaders').show();

        form.submit();

    },

  });


   $('.forgot_link').click(function(){
    $('#login_section').hide();
    $('#login_otp_section').hide();
    $('#tfa_otp_section').hide();
    $('#resend_section').hide();
    $('#forgot_section').show();
 });


 $("#forgot-form").validate({
    rules: {
      email: {
        required: true,
        email : true,
      },
    },
    messages : {

      email : {
        required : "Please enter the valid register email id",
      },

    },
    submitHandler: function(form) {

        $(".forgot-form").load("submit", function (e){
            $.ajax({
                url: base_url+"forgetpw",
                type: "POST",
                data: new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:true,
                beforeSend: function() {
                    $('#fgt_btn').hide();
                    $('.loader-fgt').show();
                },
                success: function (data) {

                  var res = JSON.parse(data);

                    if(res.status == 1){

                        $('.loader-fgt').hide();
                        $('#fgt_btn').show();
                        $('#login_section');
                        toastr.success(res.msg, 'Success', {timeOut: 2000});
                         setTimeout(function() {
                            window.location.href = base_url+'signin';
                         }, 1000);

                    }else{

                      $('.loader-fgt').hide();
                      $('#fgt_btn').show();
                      $('.forgot-form')[0].reset();
                      $toastr.error(res.msg, {timeOut: 2000});

                    }


                }
            });
        });

    },

  });




  $("#contact-form").validate({
    // Specify validation rules
    rules: {
        name: {
        required: true,
        minlength:4,
      },

      email: {
        required: true,
        email : true,
      },
      subject: {
        required: true,
      },

      message: {
        required: true,
      },

     },
     messages : {

        name : {
        required : "Please enter your name",
      },

      email : {
        required : "Please enter your email",
      },
      subject : {
        required : "Please enter your subject",
      },
      message: {
          required : "Please enter your message ",
      },

     },

    submitHandler: function(form) {

        $('#contact_btn').hide();
        $('.loaders').show();

        form.submit();

    },

  });

  function togglePasswordVisibility(inputId) {
    var passwordInput = document.getElementById(inputId);
    var eyeIcon = document.getElementById('eye-icon-' + inputId);

    if (passwordInput.type === "password") {
    passwordInput.type = "text";
    eyeIcon.classList.remove("fa-eye-slash");
    eyeIcon.classList.add("fa-eye");
    } else {
    passwordInput.type = "password";
    eyeIcon.classList.remove("fa-eye");
    eyeIcon.classList.add("fa-eye-slash");
    }
    }
