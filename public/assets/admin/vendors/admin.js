$(document).ready(function(){

 $.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
});

$.validator.addMethod("pwcheck", function(value) {
  return (/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{8,16}$/.test(value));
},'Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character');


$("#login-form").validate({
    ignore: [],
    rules: {
        email: {
            required: true,

        },
        password: {
            required: true,
        },
        pattern_val: {
            required: true,

          },
        otp: {
            required: true,
        },

    },
    messages: {
        email: {
            required: " Please enter your email",
        },

        password: {
            required: "Please enter your password",
        },
        pattern_val: {
            required : "Please Enter pattern",
      },otp: {
            required : "Please Enter OTP",
      },
    },

    submitHandler: function(form) {

        $('.login_btn').attr("disabled", true);
        $(".login-form").load("submit", function (e){
            $.ajax({
                url: base_url+"/adminlogin",
                type: "POST",
                data: new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:true,
                beforeSend: function() {
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
                        toastr.success(res.msg, 'Success', {timeOut: 2000});

                        setTimeout(function() {
                            window.location.href = base_url+'/dashboard';
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


$("#profileform").validate({
    rules: {
        username: {
            required: true,
        },

        email: {
            required: true,
        },

        phone: {
            required: true,
            number : true,
            minlength : 8,
            maxlength : 12,
        },
    },
    messages: {
        username: {
            required: " Username Can't be Empty",
        },
        email: {
            required: "Please enter your Email",
        },
        phone: {
            required: "Please Enter Your Phone Number",
        },
    },

    submitHandler: function(form) {

        $('.admin_profile').attr("disabled", true);
        $(".profileform").load("submit", function (e){
            $.ajax({
                url: base_url+"/profile",
                type: "POST",
                data: new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:true,
                beforeSend: function() {
                    $('.admin_profile').hide();
                    $('#loader').show();
                },
                success: function (data) {
                  var res = JSON.parse(data);

                    if(res.status == 1){
                        $('.admin_profile').attr("disabled", false);
                        $('#loader').hide();
                        $('.admin_profile').show();
                        // $('.login-form')[0].reset();
                        toastr.success(res.msg, 'Success', {timeOut: 2000});

                        // setTimeout(function() {
                        //     window.location.href = base_url+'/dashboard';
                        // }, 2000);
                    }else{
                      $('.admin_profile').attr("disabled", false);
                      $('#loader').hide();
                      $('#admin_profile').show();
                      toastr.error(res.msg, {timeOut: 2000});


                    }


                }
            });
        });

    },
});


$("#admin-change-pass").validate({
    // Specify validation rules
        rules: {
          current_password: {
            required: true,
          },
          password: {
            required: true,
            pwcheck : true,
            minlength:8,
          },
          c_password : {
            required: true,
            equalTo:'#password',
          },

        },
        messages : {

          current_password : {
            required : "Please Enter Current password",

          },
          password: {
              required : "Please Enter New Password",
              pwcheck : "Password length must be 8-16 characters and contain an uppercase letter, lowercase letter, number and special character. Spaces are not allowed."
          },
           c_password : {
              required : "Please Enter Confirm Password",
              equalTo : "Your password and confirmation password do not match.!",
          },

        },
        submitHandler: function(form) {

            $(".admin-change-pass").load("submit", function (e){
                $.ajax({
                    url: base_url+"/change_password",
                    type: "POST",
                    data: new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:true,
                    beforeSend: function() {
                        $('.change_pass').hide();
                        $('.loader').show();
                    },
                    success: function (data) {

                      var res = JSON.parse(data);

                        if(res.status == 1){

                            $('.loader').hide();
                            $('.change_pass').show();

                            toastr.success(res.msg, 'Success', {timeOut: 2000});

                            setTimeout(function() {
                                window.location.href = base_url+'/logout';
                             }, 2000);

                        }else{

                          $('.loader').hide();
                          $('.change_pass').show();
                          toastr.error(res.msg, {timeOut: 2000});


                        }


                    }
                });
            });

        },


});

// pattern

$("#admin_pattern").validate({
    // Specify validation rules
    ignore: [],
        rules: {
            current_pattern_val : {
                required : true,
              },
              new_pattern : {
                required: true,

              },
              confirm_pattern : {
                required: true,
                equalTo: '#new_pattern',
              },

        },
        messages : {

            current_pattern_val: {
                required : "Please Enter your Current Pattern",
              },
              new_pattern : {
                required : "Please Enter The New Pattern",
              },
              confirm_pattern : {
                required :"Please enter your Confirmed Pattern",
                equalTo : 'New Pattern & Confirm Pattern Not Matching',
              }

        },
        submitHandler: function(form) {
            $(".admin_pattern").load("submit", function (e){
                $.ajax({
                    url: base_url+"/change_pattern",
                    type: "POST",
                    data: new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:true,
                    beforeSend: function() {
                        // $('.change_pattern').hide();
                        // $('.loaders').show();
                    },
                    success: function (data) {
                    console.log(data);
                      var res = JSON.parse(data);


                        if(res.status == 1){

                            $('.loaders').hide();
                            $('.change_pattern').show();

                            toastr.success(res.msg, 'Success', {timeOut: 2000});
                            setTimeout(function() {
                                window.location.href = base_url+'/logout';
                             }, 2000);

                        }else{

                          $('.loader').hide();
                          $('.change_pattern').show();
                          toastr.error(res.msg, {timeOut: 2000});

                        }


                    }
                });
            });

        },


});

$("#setting_form").validate({
    rules: {
        site_name: {
            required: true,
            minlength:3,
        },
        email: {
            required: true,

        },
        phone: {
            required: true,
            number: true,
            minlength :8,
            maxlength :15,

        },
        address: {
            required: true,
        },
        facebook: {
            required: true,
        },
        telegram:{
            required: true,
        },instagram:{
            required: true,
        },twitter:{
            required: true,
        }


    },

    messages: {
        site_name: {
            required: " Please enter site name",
            minlength: "Enter atleast 3 characters",
        },
        email: {
            required: "Please enter your email",

        },
        phone: {
            required: "Please enter your Phone number",
        },
        address: {
            required: "Please enter your address",
        },
        facebook:{
            required: "Please enter your facebook",
        },telegram:{
            telegram: "Please enter your telegram",
        },instagram:{
            required: "Please enter your instagram",
        },twitter:{
            required: "Please enter your twitter",
        }


    },
    submitHandler: function(form) {

        $(".setting_form").load("submit", function (e){
            $.ajax({
                url: base_url+"/siteSettings",
                type: "POST",
                data: new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:true,
                beforeSend: function() {
                    $('.setting').hide();
                    $('.loader').show();
                },
                success: function (data) {

                  var res = JSON.parse(data);

                    if(res.status == 1){

                        $('.loader').hide();
                        $('.setting').show();

                        $.notify(res.msg, {className: 'success',clickToHide: true,});
                    }else{

                      $('.loader').hide();
                      $('.setting').show();
                      $.notify(res.msg, {className: 'error',clickToHide: true,});

                    }


                }
            });
        });

    },


});



});





    // Wait for the document to be ready
    $(document).ready(function() {
        // Find all elements with class "js-switch" and initialize Switchery on them
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });
    });



    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });









    $(function() {
        $("form[name='withdrawForm']").validate({


            // using required rules steps 1


            rules: {

                name: {
                    required: true,
                    pattern: /^([a-zA-Z]+\s)*[a-zA-Z]+$/,
                    minlength: 3

                },
                limit_per_day: {
                    required: true,
                    number: true
                },

                min_amount: {
                    required: true,
                    number: true
                },


                max_amount: {
                    required: true,
                    number: true
                },


                fee_amount: {
                    required: true,
                    number: true
                },

                binance_fee_amount: {
                    required: true,
                    number: true
                },


            },

            messages: {

                name: {
                    required: " Please enter Site name",
                    pattern: 'Invalid Format',
                    minlength: "Please enter at least 3 characters"

                },
                limit_per_day: {
                    required: "Please enter your Limit per day",
                    number: "Limit per day is invalid",
                },

                min_amount: {
                    required: "Please enter your Min Amount",
                    number: "Min Amount is invalid",
                },


                max_amount: {
                    required: "Please enter your Max Amount",
                    number: "Max Amount is invalid",
                },



                fee_amount: {
                    required: "Please enter your Fee Amount",
                    number: "Fee Amount  is invalid",
                },




                binance_fee_amount: {
                    required: "Please enter your Binance Fee Amount",
                    number: "Binance Fee Amountr is invalid",
                },



            },

            submitHandler: function(withdrawForm) {
            $("#btn-submit").attr("disabled", true);
            $("#spin").fadeIn(500);
            $("#loader").fadeIn(500);

            // Simulate delay to see the loader in action
            setTimeout(function() {
                withdrawForm.submit();
            }, 2000);
          }
        });
      });




    $(function() {
        $("form[name='depositForm']").validate({


            // using required rules steps 1


            rules: {

                currency_type: {
                    required: true,

                },


                binance_fee_amount: {
                    required: true,
                    number: true
                },


            },

            messages: {

                currency_type: {
                    required: " Please Select your currency Type",
                    minlength: "Please enter at least 3 characters"

                },


                binance_fee_amount: {
                    required: "Please enter your Binance Fee Amount",
                    number: "Binance Fee Amountr is invalid",
                },



            },

            submitHandler: function(depositForm) {
            $("#btno-submit").attr("disabled", true);
            $("#spino").fadeIn(500);
            $("#loader").fadeIn(500);

            // Simulate delay to see the loader in action
            setTimeout(function() {
                depositForm.submit();
            }, 2000);
          }
        });
      });

