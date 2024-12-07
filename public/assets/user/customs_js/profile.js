$(document).ready(function(){


    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
    });

    $.validator.addMethod("pwcheck", function(value) {
      return (/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{8,16}$/.test(value));
    });

    $("input#first_name").on({
      keydown: function(e) {
        if (e.which === 32)
          return false;
      },
      change: function() {
        this.value = this.value.replace(/\s/g, "");
      }
    });

    $("input#first_name").on({
      keydown: function(e) {
        if (e.which === 32)
          return false;
      },
      change: function() {
        this.value = this.value.replace(/\s/g, "");
      }
    });

    $("input#last_name").on({
      keydown: function(e) {
        if (e.which === 32)
          return false;
      },
      change: function() {
        this.value = this.value.replace(/\s/g, "");
      }
    });

      $("#profile-form").validate({

        rules: {
          firstname: {
            required: true,
          },
          lastname: {
            required: true,
          },
          mobile: {
            required : true,
            number : true,
            minlength : 8,
            maxlength : 12,
          },
          dob:{
            required : true,
            date : true,
          },
          address : {
            required : true,
          },
          country :{
            required : true,
          },
          state:{
            required : true,
          },
          city : {
            required : true,
          },

        },
        messages : {

          firstname : {
            required : "Enter first name"
          },
          lastname: {
              required : "Enter last name",
          },
          mabile: {
              required : "Enter your mobile number",
          },
          dob: {
              required : "Select your date of birth",
          },
          address: {
              required : "Enter your current address",
          },
          country: {
              required : "Select your country",
          },
          state: {
              required : "Enter your state",
          },
          city: {
              required : "Enetr your city",
          },

        },
        submitHandler: function(form) {
          $('.profile_btn').attr("disabled", true);
            $(".profile-form").load("submit", function (e){

                $.ajax({
                    url: base_url+"profile",
                    type: "POST",
                    data: new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:true,
                    beforeSend: function() {
                        $('#profile_btn').hide();
                        $('#loader').show();
                    },
                    success: function (data) {

                      var res = JSON.parse(data);

                        if(res.status == 1){
                            $('.profile_btn').attr("disabled", false);
                            $('#loader').hide();
                            $('#profile_btn').show();

                            if(res.img != ''){
                              //$('.profilePicture').attr('src', res.img);
                            }

                            toastr.success(res.msg,'Success', {timeOut: 2000});


                        }else{
                          $('.profile_btn').attr("disabled", false);
                          $('#loader').hide();
                          $('#profile_btn').show();
                          toastr.error(res.msg, {timeOut: 2000});

                        }


                    }
                });
            });

        },

      });








          $("#c_pin-form").validate({
            // Specify validation rules

            rules: {
              current_pin: {
                required: true,
              },
              pin: {
                required: true,
                number : true,
                minlength:6,
                maxlength:6,
            },
              c_pin : {
                required: true,
                equalTo:'#pin',
              },

            },
            messages : {

              current_pin : {
                required : "Please enter security Pin",

              },
              pin: {
                  required : "Please enter new security pin",
                  number : "Number only please",
              },
               c_pin : {
                  required : "Please enter confirm security Pin",
                  equalTo : "Your security pin and confirmation security pin do not match.!",
              },

            },
            submitHandler: function(form) {

              // pin form old
                $(".c_pin-form").load("submit", function (e){
                    $.ajax({
                        url: base_url+"chnage_wPin",
                        type: "POST",
                        data: new FormData(this),
                         processData:false,
                         contentType:false,
                         cache:false,
                         async:true,
                        beforeSend: function() {
                            $('#c_pin-btn').hide();
                            $('.send_email_pin').hide();
                            $('.loader').show();
                          },
                        success: function (data) {

                          var res = JSON.parse(data);

                            if(res.status == 1){
                              console.log(res.status);
                                $('.loader').hide();
                                $('#c_pin-btn').show();
                                $('.send_email_pin').show();
                                $('.c_pin-form')[0].reset();
                                toastr.success(res.msg,'Success',{timeOut: 2000});


                            }else{

                              $('.loader').hide();
                              $('#c_pin-btn').show();
                              $('.send_email_pin').show();
                              toastr.error(res.msg, {timeOut: 2000});

                            }


                        }
                    });
                });


            },

          });





        $("#changepw-form").validate({
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
                required : "Please enter new password",
                pwcheck : "Password length must be 8-16 characters and contain an uppercase letter, lowercase letter, number and special character. Spaces are not allowed."
            },
             c_password : {
                required : "Please enter confirm password",
                equalTo : "Your password and confirmation password do not match.!",
            },

          },
          submitHandler: function(form) {
              $(".changepw-form").load("submit", function (e){
                  $.ajax({
                      url: base_urls+'/userchangepassword',
                      type: "POST",
                      data: new FormData(this),
                       processData:false,
                       contentType:false,
                       cache:false,
                       async:true,
                      beforeSend: function() {
                          $('#cng-btn').hide();
                          $('.loaders').show();
                      },
                      success: function (data) {
                        var res = JSON.parse(data);

                          if(res.status == 1){

                              $('.loaders').hide();
                              $('#cng-btn').show();

                            toastr.success(res.msg, 'Success', {timeOut: 2000});


                              setTimeout(function() {
                                  window.location.href = base_url+'logout';
                               }, 2000);

                          }else{

                            $('.loaders').hide();
                            $('#cng-btn').show();
                            toastr.error(res.msg, {timeOut: 2000});

                          }


                      }
                  });
              });

          },

        });




    $(function() {
        $("#tfa-form").validate({

            rules: {


                tfa_code: "required",

                password: "required",

                tfa_code: {

                    required: true,
                    minlength: 6
                },

                password: {
                    required: true,
                },


                message: {
                    required: true,
                    pattern: /^\S+(?: \S+)*$/

                }
            },

            messages: {
                tfa_code: {

                    required: " Please enter TFA code",
                    minlength: "Please enter at least 6 characters"

                },


                password: {
                    required: "Please enter your password",
                },


                message: {
                    required: "Please enter your message",
                    pattern: 'One space only allowed'
                }

            },


            submitHandler: function(rejectedform) {
                $(".btn").attr("disabled", true);
                $("#spin").fadeIn(500);
                rejectedform.submit();


            }


        });
    });





    $("#kyc-form").validate({

        rules: {
          proof_number: {
            required: true,
          },

        },
        messages : {
          proof_number: {
            required: "Enter national identity number",
          },

        },
        submitHandler: function(form) {
            $('.kyc_btn').attr("disabled", true);
            $(".kyc-form").load("submit", function (e){

                $.ajax({
                    url: base_url+"kycupload",
                    type: "POST",
                    data: new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:true,
                    beforeSend: function() {
                        $('#kyc_btn').hide();
                        $('.loader').show();
                    },
                    success: function (data) {

                      var res = JSON.parse(data);

                        if(res.status == 1){

                            $('.loader').hide();
                            $('.hidebrowse').hide();

                            if(res.front != ''){
                              $('.frontimg').attr('src', res.front);
                            }
                            if(res.back != ''){
                              $('.backimg').attr('src', res.back);
                            }
                            if(res.selfi != ''){
                              $('.selfiimg').attr('src', res.selfi);
                            }
                            $('.frontclr').css('color', res.frontclr);
                            $('.backclr').css('color', res.backclr);
                            $('.selficlr').css('color', res.selficlr);

                             $('.frontclr').text(res.frontsts);
                             $('.backclr').text(res.backsts);
                             $('.selficlr').text(res.selfists);
                             $('#proof_number').attr('readonly', true);

                            $('.kyc_btn').attr("disabled", false);

                            $('.kyc_btn').hide()
                            toastr.success(res.msg,'Success', {timeOut: 2000});



                        }else{
                          $('.kyc_btn').attr("disabled", false);
                          $('.loader').hide();
                          $('#kyc_btn').show();
                          toastr.error(res.msg, {timeOut: 2000});

                        }


                    }
                });
            });

        },

      });

    $("#fntimg").click(function () {
        $("#proof_front").trigger('click');
    });


    $("#bckimg").click(function () {
       $("#proof_back").trigger('click');
    });

    $("#sfiimg").click(function () {
       $("#selfi").trigger('click');
    });


    $('.proof_front').on('change', function() {
      var numb = $(this)[0].files[0].size / 1024 / 1024;
      numb = numb.toFixed(2);
      if (numb > 1) {
        alert('File size must be less than 1 MB. You file size is: ' + numb + ' MiB');
        $('.proof_front').val('');
        return false;
      }
    });


    $('.proof_back').on('change', function() {
      var numb = $(this)[0].files[0].size / 1024 / 1024;
      numb = numb.toFixed(2);
      if (numb > 1) {
        alert('File size must be less than 1 MB. You file size is: ' + numb + ' MiB');
        $('.proof_back').val('');
        return false;
      }
    });


    $('.selfi').on('change', function() {
      var numb = $(this)[0].files[0].size / 1024 / 1024;
      numb = numb.toFixed(2);
      if (numb > 1) {
        alert('File size must be less than 1 MB. You file size is: ' + numb + ' MiB');
        $('.selfi').val('');
        return false;
      }
    });



    proof_front.onchange = evt => {
      const [file] = proof_front.files
      if (file) {
        fntimg.src = URL.createObjectURL(file)
        $('.frontclr').text('Uploaded');
      }

      }

      proof_back.onchange = evt => {
      const [file] = proof_back.files
      if (file) {
        bckimg.src = URL.createObjectURL(file)
        $('.backclr').text('Uploaded');
      }

      }

    selfi.onchange = evt => {
      const [file] = selfi.files
      if (file) {
        sfiimg.src = URL.createObjectURL(file)
        $('.selficlr').text('Uploaded');
      }
    }







$("#securitysetting").validate({
    // Specify validation rules
        rules: {

          pin: {
            required: true,
            number : true,
            minlength:6,
            maxlength:6,
        },
          c_pin : {
            required: true,
            equalTo:'#pin',
          },

        },
        messages : {


          pin: {
              required : "Please enter security pin",
              pwcheck : "Password length must be 8-16 characters and contain an uppercase letter, lowercase letter, number and special character. Spaces are not allowed."
          },
          c_pin : {
              required : "Please enter confirm security pin",
              equalTo : "Your security pin and confirmation security pin do not match.!",
          },

        },

        submitHandler: function(form) {
            $('.sec_btn').attr("disabled", true);
            $(".securitysetting").load("submit", function (e){

                  $.ajax({
                      url: base_url+"security",
                      type: "POST",
                      data: new FormData(this),
                       processData:false,
                       contentType:false,
                       cache:false,
                       async:true,
                       beforeSend: function() {
                        $('#sec_btn').hide();
                        $('.loaderss').show();
                    },
                      success: function (data) {

                        var res = JSON.parse(data);


                            if(res.status == 1){
                            $('.sec_btn').attr("disabled", false);
                            $('.loaderss').hide();
                            $('#sec_btn').show();


                              toastr.success(res.msg,'Success', {timeOut: 2000});
                              setTimeout(function() {
                                                  window.location.href = base_url+'profile';
                                                  }, 2000);


                          }
                          else{
                            $('.sec_btn').attr("disabled", false);
                            $('.loaderss').hide();
                            $('#sec_btn').show();
                            toastr.error(res.msg, {timeOut: 2000});

                          }


                      }
                  });
              });

          },




      });




      $("#c_pin-form").validate({
        // Specify validation rules

        rules: {
          current_pin: {
            required: true,
          },
          pin: {
            required: true,
            number : true,
            minlength:6,
            maxlength:6,
        },
          c_pin : {
            required: true,
            equalTo:'#pin',
          },

        },
        messages : {

          current_pin : {
            required : "Please enter security Pin",

          },
          pin: {
              required : "Please enter new security pin",
              number : "Number only please",
          },
           c_pin : {
              required : "Please enter confirm security pin",
              equalTo : "Your security pin and confirmation security pin do not match.!",
          },

        },
        submitHandler: function(form) {

          // pin form old
            $(".c_pin-form").load("submit", function (e){
                $.ajax({
                    url: base_url+"chnage_wPin",
                    type: "POST",
                    data: new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:true,
                    beforeSend: function() {
                        $('#c_pin-btn').hide();
                        $('.send_email_pin').hide();
                        $('.loader').show();
                      },
                    success: function (data) {

                      var res = JSON.parse(data);

                        if(res.status == 1){
                          console.log(res.status);
                            $('.loader').hide();
                            $('#c_pin-btn').show();
                            $('.send_email_pin').show();
                            $('.c_pin-form')[0].reset();
                            toastr.success(res.msg,'Success',{timeOut: 2000});

                            setTimeout(function() {
                                window.location.href = base_url+'profile';
                                }, 2000);


                        }else{

                          $('.loader').hide();
                          $('#c_pin-btn').show();
                          $('.send_email_pin').show();
                          toastr.error(res.msg, {timeOut: 2000});

                        }


                    }
                });
            });


        },

      });



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
