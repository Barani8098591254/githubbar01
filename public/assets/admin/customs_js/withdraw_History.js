$(function() {
    $("form[name='reject']").validate({


        // using required rules steps 1


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

            rrrr: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            }
        },
        // this is message showing popup validation  step 3


        messages: {


            reason: {
                required: "Please Enter Your Valid Rejecet Reason",
                pattern: 'One Space only allowed'
            },



            copyright: {
                required: "Please enter Copy right Field",
                pattern: 'One Space only allowed'
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




$(function () {
    $("form[name='approvedform']").validate({

        rules: {
            txId: {
                required: true,

            },

            message: "required",

            txId: {

                required: true,
                pattern: /^\S+(?: \S+)*$/,
                minlength: 3

            },


            message: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            }
        },

        messages: {
            txId: {

                required: "Please enter transaction id",
                pattern: 'Invalid Format',
                minlength: "Please enter at least 3 characters"

            },

            message:
            {
                required: "Please enter your message",
                pattern: 'One Space only allowed'
            }

        },


        submitHandler: function (approvedform) {
            $(".btn").attr("disabled", true);
            $("#spin").fadeIn(500);
            approvedform.submit();


        }


    });
});

