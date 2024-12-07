
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
                    success: function (res) {

                        if(res.status == 1){


                            $('.login_btn').attr("disabled", false);

                            toastr.success(res.msg, 'success', {timeOut: 2000});


                            setTimeout(function() {
                                window.location.href = base_url+'/dashboard';
                            }, 2000);
                        }else{
                          $('.login_btn').attr("disabled", false);
                          $('#loader').hide();
                          $('#login_btn').show();
                         toastr.error(res.msg, 'Error', { timeOut: 2000 });


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
            required : "Please enter current password",

          },
          password: {
              required : "Please rnter new Password",
              pwcheck : "Password length must be 8-16 characters and contain an uppercase letter, lowercase letter, number and special character. Spaces are not allowed."
          },
           c_password : {
              required : "Please enter confirm password",
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
                                window.location.href = base_url+'/adminLogout';

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
});


function sendotp(){
        var usermail     = $("#email").val();
        var userpassword = $("#password").val();
        console.clear();
        var dataString = {usermail: usermail,userpassword: userpassword}
        $.ajax({
            url: base_url + "/sendloginotp",
            type: "POST",
            data: dataString,
            cache:false,
            async:true,
            beforeSend: function() {
                $('.sendOtp').hide();
                $('.otpLoading').show();

            },
            success: function(response) {
                if (response.status == 1) {
                   toastr.success(response.msg, 'Success', {timeOut: 2000});
                   $('.sendOtp').show();
                   $('.otpLoading').hide();

                } else {
                   toastr.error(response.msg, {timeOut: 2000});
                   $('.sendOtp').show();
                   $('.otpLoading').hide();
                }
            }
        });
    }


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
                        $('.change_pattern').hide();
                        $('.loaders').show();
                    },
                    success: function (data) {
                    console.log(data);
                      var res = JSON.parse(data);


                        if(res.status == 1){

                            $('.loaders').hide();
                            $('.change_pattern').show();

                            toastr.success(res.msg, 'Success', {timeOut: 2000});
                            setTimeout(function() {
                                window.location.href = base_url+'/adminLogout';
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















  document.addEventListener("DOMContentLoaded", function() {
    display_pattern();
    // Add an event listener for the reset button
    document.getElementById("resetPatternBtn").addEventListener("click", reset_pattern);
  });

  function display_pattern() {
    var lock = new PatternLock('#pattern1', {
      onDraw: function(pattern) {
        console.log('Pattern Drawn:', pattern);
        document.getElementById("pattern_val").value = pattern;
      }
    });
  }
  // Function to reset the pattern
  function reset_pattern() {
    var lock = new PatternLock('#pattern1');
    lock.reset(); // Reset the pattern
    document.getElementById("pattern_val").value = ""; // Clear the pattern value
  }





    // document.addEventListener("DOMContentLoaded", function() { display_pattern();});
    // function display_pattern()
    // {
    // var lock= new PatternLock('#pattern1',{
    //     onDraw:function(pattern){
    //       console.log('old patter--->',pattern);
    //         document.getElementById("pattern_val").value=lock.getPattern();

    //     }
    // });
    // }



