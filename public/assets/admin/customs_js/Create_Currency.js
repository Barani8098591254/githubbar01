$(function() {
    $.validator.addMethod('decimal', function(value, element) {
        return this.optional(element) || /^[0-9]+\.\d{1,8}$/.test(value);
    }, "Please enter a crypto format point eight decimal");


    $("form[name='createcurrency']").validate({


        // using required rules steps 1


        rules: {
            name: {
                required: true,
                pattern: /^([a-zA-Z]+\s)*[a-zA-Z]+$/,
                minlength: 3

            },

            symbol: {
                required: true,
                pattern: /^[a-zA-Z]+$/,
                minlength: 2,
                maxlength: 5
            },


            type: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            },


            status: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            },



            withdraw_status: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            },


            deposit_status: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            },


            deposit_status: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            },


            decimal: {
                required: true,
                number: true

            },


        },

        messages: {

            name: {
                required: " Please enter currency ame",
                pattern: 'Invalid format',
                minlength: "Please enter at least 3 characters",
                maxlength: "Please enter at least 5 characters"

            },
            symbol: {
                required: "Please enter your currency symbol",
                pattern: "Invalid format",
            },

            type: {
                required: "Please enter your min amount",
                pattern: "Min amount is invalid",
            },


            status: {
                required: "Select your currency status",
                pattern: "Max amount is invalid",
            },



            withdraw_status: {
                required: "Select your withdraw status",
                pattern: "Fee amount  is invalid",
            },


            deposit_status: {
                required: "Select your deposit status",
                pattern: "Fee amount  is invalid",
            },

            decimal: {
                required: "Please enter your decimal value",
                pattern: "Numbers only allowed",
            }





        },

        submitHandler: function(createcurrency) {
        $("#btn-submit").attr("disabled", true);
        $("#spin").fadeIn(500);
        $("#loader").fadeIn(500);

        // Simulate delay to see the loader in action
        setTimeout(function() {
            createcurrency.submit();
        }, 2000);
      }
    });
  });
