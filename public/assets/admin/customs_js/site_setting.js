$(function() {
    $("form[name='setting_form']").validate({


        // using required rules steps 1


        rules: {
            sitename: {
                required: true,

            },

            contactmail: "required",
            contactnumber: "required",
            contactaddress: "required",
            site_status: "required",
            copyright: "required",
            maintanance_content: "required",
            fblink: "required",
            twitterlink: "required",
            instainlink: "required",
            telegramlink: "required",

            message: "required",

            sitename: {

                required: true,
                pattern: /^([a-zA-Z]+\s)*[a-zA-Z]+$/,
                minlength: 3

            },
            contactmail: {
                required: true,
                pattern: /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/,
                email: true
            },

            contactnumber: {
                required: true,
                minlength: 6,
                maxlength: 12,
                pattern: /^[0-9\s]*$/,
                number: true
            },

            contactaddress: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            },

            maintanance_content: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            },


            fblink: {
                required: true,
                pattern: /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
            },


            twitterlink: {
                required: true,
                pattern: /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
            },



            instainlink: {
                required: true,
                pattern: /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
            },



            telegramlink: {
                required: true,
                pattern: /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
            },


            copyright: {

                required: true,
                minlength: 5

            },

            rrrr: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            }
        },
        // this is message showing popup validation  step 3


        messages: {


            sitename: {
                required: "Please enter site name",
                pattern: 'Invalid Format',
                minlength: "Please enter at least 3 characters"



            },

            contactmail: {
                required: "Please enter your email",
                pattern: "Please enter the correct email ",

            },

            contactnumber: {
                required: "Please enter your phone number",
                number: "Phone number is invalid",
                minlength: "Phone number must be min 6 characters long",
                maxlength: "Phone number must not be more than 12 characters long"

            },
            contactaddress: {
                required: "Please enter your address",
                pattern: 'One space only allword'


            },

            maintanance_content: {
                required: "Please enter your maintance Content",
                pattern: 'One space only allword'


            },

            fblink: {
                required: "Give the correctfacebook Url",
                pattern: 'One space only allword'


            },


            twitterlink: {
                required: "Give the correct Twitter Url",
                pattern: 'One space only allword'


            },



            instainlink: {
                required: "Give the correct instagram Url",
                pattern: 'One space only allword'


            },

            telegramlink: {
                required: "Give the correct telegram Url",
                pattern: 'One space only allword'


            },


            maintanance_content: {
                required: "Please enter your maintance content",
                pattern: 'One space only allword'


            },


            copyright: {
                required: "Please enter copy right field",
                pattern: 'One space only allword'
            }

        },
        // submitHandler: function(form) {
        //   form.submit();




        submitHandler: function (setting_form) {
            $(".btn").attr("disabled", true);
            $("#spin").fadeIn(500);
            setting_form.submit();


        }



    });
});
