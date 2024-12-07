$(function() {
    $("form[name='ip']").validate({


        // using required rules steps 1


        rules: {
            ip: {
                required: true,

            },

            message: "required",

            ip: {

                required: true,
                pattern:  /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$|^([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}$|^([0-9a-fA-F]{1,4}:){1,7}:$|^([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}$|^([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}$|^([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}$|^([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}$|^([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}$|^[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})?$/,
                minlength: 3

            },

            rrrr: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            }
        },
        // this is message showing popup validation  step 3


        messages: {


            ip: {
                required: " Please enter your ip address",
                pattern: 'Give the correct ip address'
            },



            copyright: {
                required: "Please enter copy right field",
                pattern: 'One space only allowed'
            }

        },


        submitHandler: function (ip) {
            $(".btn").attr("disabled", true);
            $("#spin").fadeIn(500);
            ip.submit();


        }

    });
});
