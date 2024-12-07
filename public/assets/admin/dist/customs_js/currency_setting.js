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
                decimal: true,

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




        },

        messages: {

            name: {
                required: " Please enter Site name",
                pattern: 'Invalid format',
                minlength: "Please enter at least 3 characters"

            },
            per_day_limit: {
                required: "Please enter your Limit per day",
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
                required: "Please enter your fee amount",
                number: "Fee amount  is invalid",
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
