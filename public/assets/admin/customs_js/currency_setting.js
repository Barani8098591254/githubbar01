$(function() {
    $.validator.addMethod('decimal', function(value, element) {
        return this.optional(element) || /^[0-9]+\.\d{1,8}$/.test(value);
    }, "Please enter a crypto format point eight decimal");


    $("form[name='withdrawForm']").validate({


        // using required rules steps 1


        rules: {
            per_day_limit: {
                required: true,
                number: true,
                min: 0.01,
               max: 1000000.00

            },

            min: {
                required: true,

            },


            max: {
                required: true,
                number: true,
                min: 0.01,
                max: 1000000.00
            },


            fee: {
                required: true,
                number: true,
                min: 0.01,
                max: 1000000.00
            },

            usdprice:{
                required: true,
                number: true,

            },


        },

        messages: {

            name: {
                required: " Please enter site name",
                pattern: 'Invalid format',
                minlength: "Please enter at least 3 characters"

            },
            per_day_limit: {
                required: "Please enter your limit per day",
                number: "Limit per day is invalid",
            },

            min: {
                required: "Please enter your min amount",
                number: "Min amount is invalid",
            },


            max: {
                required: "Please enter your max amount",
                number: "Max amount is invalid",
            },



            fee: {
                required: "Please enter your Fee amount",
                number: "Fee amount  is invalid",
            },


            usdprice: {
                required: "Please enter your usdprice amount",
                number: "Usdprice amount is invalid",
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
    $("form[name='internaltransferamount']").validate({


        // using required rules steps 1


        rules: {
            Imin: {
                required: true,
                number: true,


            },

            Imax: {
                required: true,
                number: true,


            },


            Imin: {

                required: true,
                decimal: true,


            },

            Imax: {
                required: true,
                number: true,
                min: 0.01,
                max: 1000000.00

            }
        },
        // this is message showing popup validation  step 3


        messages: {


            ip: {
                required: " Please enter your min internal transfer amount",
                pattern: 'Give correct amount'
            },



            copyright: {
                required: "Please enter your max internal transfer amount",
                pattern: 'Give correct amount'
            }

        },


        submitHandler: function (internaltransferamount) {
            $(".btn").attr("disabled", true);
            $("#spinc").fadeIn(500);
            internaltransferamount.submit();


        }

    });
});
