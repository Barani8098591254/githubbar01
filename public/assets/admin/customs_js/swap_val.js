$(function() {
    $("form[name='createswap']").validate({


        // using required rules steps 1


        rules: {
            from_currency: {
                required: true,

            },

            to_currency: "required",
            binance_pair: "required",
            min: "required",
            max: "required",
            fee: "required",
            fee_type: "required",
            spread: "required",
            message: "required",

            from_currency: {

                required: true,


            },
            to_currency: {
                required: true,

            },

            binance_pair: {
                required: true,
            },

            min: {
                required: true,
                number: true

            },

            max: {
                required: true,
                number: true

            },


            fee: {
                required: true,
                number: true
            },


            fee_type: {
                required: true,
            },



            marketprice: {
                required: true,
                number: true

            },

            spread: {
                required: true,
                number: true

            }
        },
        // this is message showing popup validation  step 3


        messages: {


            from_currency: {
                required: "select your from currency"

            },

            to_currency: {
                required: "select your to currency"

            },

            binance_pair: {
                required: "Please enter your binace pair"
            },
            min: {
                required: "Please enter your min amount ",
                number: "Number only allowed",
                minlength: "Phone number must be min 6 characters long",
                maxlength: "Phone number must not be more than 12 characters long"


            },

            max: {
                required: "Please enter your max amount",
                number: "Number only allowed",
                minlength: "Phone number must be min 6 characters long",
                maxlength: "Phone number must not be more than 12 characters long"

            },

            fee: {
                required: "please enter your fee amount",
                pattern: 'One space only allword'
            },


            status: {
                required: "Select your status",
                pattern: 'One space only allword'
            },


            fee_type: {
                required: "Select your fee type",
                pattern: 'One space only allword'
            },


            fee_type: {
                required: "Select your fee type",
                pattern: 'One space only allword'
            },

            spread: {
                required: "Please enter spread value",
                pattern: 'One space only allword'
            },




            marketprice: {
                required: "Please enter marketprice amount",
                pattern: 'One space only allword'
            }

        },
        // submitHandler: function(form) {
        //   form.submit();




        submitHandler: function (createswap) {
            $(".btn").attr("disabled", true);
            $("#spin").fadeIn(500);
            createswap.submit();


        }



    });
});




$(function() {
    $("form[name='swapedit']").validate({


        // using required rules steps 1


        rules: {
            from_currency: {
                required: true,

            },

            to_currency: "required",
            binance_pair: "required",
            min: "required",
            max: "required",
            fee: "required",
            fee_type: "required",
            spread: "required",
            message: "required",

            from_currency: {

                required: true,


            },
            to_currency: {
                required: true,

            },

            binance_pair: {
                required: true,
            },

            min: {
                required: true,
                number: true

            },

            max: {
                required: true,
                number: true

            },


            fee: {
                required: true,
                number: true
            },


            fee_type: {
                required: true,
            },


            spread: {
                required: true,
                number: true

            }
        },
        // this is message showing popup validation  step 3


        messages: {


            from_currency: {
                required: "select your from currency"

            },

            to_currency: {
                required: "select your to currency"

            },

            binance_pair: {
                required: "Please enter your binace pair"
            },
            min: {
                required: "Please enter your min amount ",
                number: "Number only allowed",
                minlength: "Phone number must be min 6 characters long",
                maxlength: "Phone number must not be more than 12 characters long"


            },

            max: {
                required: "Please enter your max amount",
                number: "Number only allowed",
                minlength: "Phone number must be min 6 characters long",
                maxlength: "Phone number must not be more than 12 characters long"

            },

            fee: {
                required: "please enter your fee amount",
                pattern: 'One space only allword'
            },


            status: {
                required: "Select your status",
                pattern: 'One space only allword'
            },


            fee_type: {
                required: "Select your fee type",
                pattern: 'One space only allword'
            },


            spread: {
                required: "Please enter spread",
                pattern: 'One space only allword'
            }

        },
        // submitHandler: function(form) {
        //   form.submit();




        submitHandler: function (swapedit) {
            $(".btn").attr("disabled", true);
            $("#spin").fadeIn(500);
            swapedit.submit();


        }



    });
});
