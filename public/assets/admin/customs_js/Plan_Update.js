$(function() {
    $("form[name='editPlan']").validate({


        // using required rules steps 1


        rules: {
            name: {
                required: true,

            },
            price: "required",
            direct_commission: "required",
            roi_commission: "required",
            message: "required",

            name: {

                required: true,
                pattern: /^\S+(?: \S+)*$/,
                minlength: 3
            },

            price: {
                required: true,
                pattern: /^[-+]?\d*\.?\d+$/,
                minlength: 3

            },


            direct_commission: {
                required: true,
                pattern: /^[-+]?\d*\.?\d+$/,
                minlength: 3

            },

            roi_commission: {

                required: true,
                pattern: /^[-+]?\d*\.?\d+$/,
                minlength: 3
            },
            // 'commission[]': {
            //     required: true,
            // },



            rrrr: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            }
        },
        // this is message showing popup validation  step 3


        messages: {


            name: {
                required: " Please enter plan name",
                pattern: 'Invalid format',
                minlength: "Please enter at least 3 characters"



            },

            price: {
                required: "Please enter correct price name",
                pattern: "Please enter correct value"

            },

            direct_commission: {
                required: "Please enter direct commission",
                pattern: "Please enter correct value"
            },
            roi_commission: {
                required: "Please enter roi commission",
                pattern: "Please enter correct value"


            },




            copyright: {
                required: "Please enter copy right field",
                pattern: 'One space only allowed'
            }

        },



        submitHandler: function (editPlan) {
            $(".btn").attr("disabled", true);
            $("#spin").fadeIn(500);
            editPlan.submit();


        }


    });
});
