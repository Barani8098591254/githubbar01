
$.validator.addMethod("pwcheck", function(value) {
    return (/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{8,16}$/.test(value));
  },'Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character');


$(function() {
    $("form[name='emailSet']").validate({


        // using required rules steps 1


        rules: {
            smtp_host: {
                required: true,

            },

            smtp_port: "required",
            email_from: "required",
            smtp_user: "required",
            smtp_pass: "required",
            smtp_new_Pass: "required",


            smtp_host: {

                required: true,
                pattern: /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/,
                minlength: 3

            },

            email_from: {
                required: true,
                pattern: /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/,
                email: true
            },


            smtp_user: {
                required: true,
                email:true,
                minlength: 3
            },

            smtp_port: {
                required: true,
                minlength: 4,
                pattern: /^[0-9\s]*$/,
                number: true
            },


            smtp_pass: {
                required: true,
                pattern: /^\S+(?: \S+)*$/
            },
            smtp_new_Pass: {
                required: true,
                pwcheck : true,
                pwcheck : "Password length must be 8-16 characters and contain an uppercase letter, lowercase letter, number and special character. Spaces are not allowed."

            }
        },
        // this is message showing popup validation  step 3


        messages: {


            smtp_host: {
                required: "Please enter your Host Name",
                pattern: 'Invalid Format',
            },

            smtp_host: {
                required: "Please enter your email",
                alphanumeric: "Name should contain only letters",

            },



            email_from: {
                required: "Please enter your email",
                alphanumeric: "Name should contain only letters",

            },
            phone: {
                required: "Please enter your Phone number",
                number: "Phone number is invalid",
                minlength: "Phone number must be min 6 characters long",
                maxlength: "Phone number must not be more than 12 characters long"

            },


            copyright: {
                required: "Please enter Copy right Field",
                pattern: 'One Space only Allowed'
            }

        },
        // submitHandler: function(form) {
        //   form.submit();


        submitHandler: function(form) {
            $(".btn").attr("disabled", true);
            $("#overlay").fadeIn(500);
            form.submit();


        }


    });
});








$(function() {
    $("form[name='setting_form']").validate({


        // using required rules steps 1


        rules: {
            name: {
                required: true,

            },

            email: "required",
            phone: "required",
            address: "required",
            facebook_link: "required",
            twitter_link: "required",
            instagram_link: "required",
            telegram_link: "required",
            site_status: "required",
            maintanance_content: "required",
            message: "required",

            name: {

                required: true,
                pattern: /^([a-zA-Z]+\s)*[a-zA-Z]+$/,
                minlength: 3

            },
            email: {
                required: true,
                pattern: /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/,
                email: true
            },

            phone: {
                required: true,
                minlength: 6,
                maxlength: 12,
                pattern: /^[0-9\s]*$/,
                number: true
            },

            address: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            },

            maintanance_content: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            },


            facebook_link: {
                required: true,
                pattern: /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
            },


            twitter_link: {
                required: true,
                pattern: /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
            },



            instagram_link: {
                required: true,
                pattern: /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
            },



            telegram_link: {
                required: true,
                pattern: /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
            },


            application_name: {

                required: true,
                pattern: /^([a-zA-Z]+\s)*[a-zA-Z]+$/,
                minlength: 5

            },

            copyright: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            }
        },
        // this is message showing popup validation  step 3


        messages: {


            name: {
                required: " Please enter Site name",
                pattern: 'Invalid Format',
                minlength: "Please enter at least 3 characters"



            },

            email: {
                required: "Please enter your email",
                alphanumeric: "Name should contain only letters",

            },

            phone: {
                required: "Please enter your Phone number",
                number: "Phone number is invalid",
                minlength: "Phone number must be min 6 characters long",
                maxlength: "Phone number must not be more than 12 characters long"

            },
            address: {
                required: "Please enter your Address",
                pattern: 'One Space only Allowed'


            },

            maintanance_content: {
                required: "Please enter your Maintance Content",
                pattern: 'One Space only Allowed'


            },

            facebook_link: {
                required: "Give the Correct Facebook Url",
                pattern: 'One Space only Allowed'


            },


            twitter_link: {
                required: "Give the Correct Twitter Url",
                pattern: 'One Space only Allowed'


            },



            instagram_link: {
                required: "Give the Correct Instagram Url",
                pattern: 'One Space only Allowed'


            },

            telegram_link: {
                required: "Give the Correct Telegram Url",
                pattern: 'One Space only Allowed'


            },


            maintanance_content: {
                required: "Please enter your Maintance Content",
                pattern: 'One Space only Allowed'


            },


            copyright: {
                required: "Please enter Copy right Field",
                pattern: 'One Space only Allowed'
            }

        },
        // submitHandler: function(form) {
        //   form.submit();


        submitHandler: function(form) {
            $(".btn").attr("disabled", true);
            $("#overlay").fadeIn(500);
            form.submit();


        }


    });
});


$('#btn-validate').click(function() {
    var $captcha = $('#recaptcha'),
        response = grecaptcha.getResponse();

    if (response.length === 0) {
        $('.msg-error').text("reCAPTCHA is mandatory");
        if (!$captcha.hasClass("error")) {
            $captcha.addClass("error");
        }
    } else {
        $('.msg-error').text('');
        $captcha.removeClass("error");
        alert('reCAPTCHA marked');
    }
})





$(function() {
    $("form[name='rejec0t']").validate({

      rules: {
          reason: {
                required: true,

              },

          message: "required",

  reason: {

          required: true,
          pattern: /^([a-zA-Z]+\s)*[a-zA-Z]+$/,
          minlength: 3

        },

        message: {
          required: true,
          pattern: /^\S+(?: \S+)*$/

        }
      },

      messages: {
          reason: {

          required: " Please enter name",
          pattern: 'Invalid Format',
          minlength: "Please enter at least 3 characters"

        },

        message:
        {
         required: "Please enter your message",
         pattern: 'One Space only Allowed'
        }

      },


      submitHandler: function(rejectedform) {
          $(".btn").attr("disabled", true);
          $("#spin").fadeIn(500);
          rejectedform.submit();


      }


    });
  });
