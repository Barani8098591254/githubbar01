$(function() {
    $.validator.addMethod('decimal', function(value, element) {
        return this.optional(element) || /^[0-9]+\.\d{1,8}$/.test(value);
    }, "Please enter a crypto format point eight decimal");


    $("form[name='reply_page']").validate({


        // using required rules steps 1


        rules: {


            admin_msg: {
                required: true,
            },




        },

        messages: {

            admin_msg: {
                required: " Please enter admin message",
                pattern: 'Invalid format',
                minlength: "Please enter at least 3 characters"

            },





        },

        submitHandler: function(reply_page) {
        $("#btn-submit").attr("disabled", true);
        $("#spin").fadeIn(500);
        $("#loader").fadeIn(500);

        // Simulate delay to see the loader in action
        setTimeout(function() {
            reply_page.submit();
        }, 2000);
      }
    });
  });
