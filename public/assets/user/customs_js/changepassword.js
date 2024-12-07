$(document).ready(function(){



$.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
});

$.validator.addMethod("pwcheck", function(value) {
  return (/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{8,16}$/.test(value));
},'Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character');



  $("#changepw-form").validate({
// Specify validation rules
    rules: {
      current_password: {
        required: true,
      },
      password: {
        required: true,
        pwcheck : true,
        minlength:8,
      },
      c_password : {
        required: true,
        equalTo:'#password',
      },

    },
    messages : {

      current_password : {
        required : "Please enter current password",

      },
      password: {
          required : "Please enter new password",
          pwcheck : "Password length must be 8-16 characters and contain an uppercase letter, lowercase letter, number and special character. spaces are not allowed."
      },
       c_password : {
          required : "Please enter confirm password",
          equalTo : "Your password and confirmation password do not match.!",
      },

    },
    submitHandler: function(form) {
        $(".changepw-form").load("submit", function (e){
            $.ajax({
                url: base_urls+'/userchangepassword',
                type: "POST",
                data: new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:true,
                beforeSend: function() {
                    $('#cng-btn').hide();
                    $('.loaders').show();
                },
                success: function (data) {
                  var res = JSON.parse(data);

                    if(res.status == 1){

                        $('.loaders').hide();
                        $('#cng-btn').show();

                      toastr.success(res.msg, 'Success', {timeOut: 2000});


                        setTimeout(function() {
                            window.location.href = base_url+'logout';
                         }, 2000);

                    }else{

                      $('.loaders').hide();
                      $('#cng-btn').show();
                      toastr.error(res.msg, {timeOut: 2000});

                    }


                }
            });
        });

    },

  });

});
