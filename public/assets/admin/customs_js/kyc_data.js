
$(function () {
    $("form[name='kycreject']").validate({

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

                required: "Please enter reject reason",
                pattern: 'Invalid format',
                minlength: "Please enter at least 3 characters"

            },

            message:
            {
                required: "Please enter your message",
                pattern: 'One space only allowed'
            }

        },


        submitHandler: function (reject) {
            $(".btn").attr("disabled", true);
            $("#spin").fadeIn(500);
            reject.submit();


        }


    });
});
