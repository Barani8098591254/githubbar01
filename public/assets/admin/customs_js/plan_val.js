$(function() {
    $("form[name='createplan']").validate({


        // using required rules steps 1


        rules: {
            currencyId: {
                required: true,

            },
            name: "required",
            direct_commission: "required",
            roi_commission: "required",
            price: "required",
            status: "required",
            days: "required",


            name: {

                required: true,
                pattern: /^\S+(?: \S+)*$/,
                minlength: 5
            },

            price: {
                required: true,
                pattern: /^[+-]?\d*\.?\d+$/

            },


            direct_commission: {
                required: true,
                pattern: /^[-+]?\d*\.?\d+$/

            },

            roi_commission: {

                required: true,
                pattern: /^[+-]?\d*\.?\d+$/
            },


            days: {

                required: true,
                pattern: /^[+-]?\d*\.?\d+$/
            },


            'commission[]': {
                required: true,
            },



            status: {
                required: true


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

            days: {
                required: "Please enter Plan Days",
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
