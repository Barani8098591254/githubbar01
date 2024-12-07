
$.validator.addMethod('decimal', function(value, element) {
    return this.optional(element) || /^\d*(\.\d+)?$/.test(value);
}, "Please enter the valid amount.");


function getCurrencyInfo(currencyId) {

    $('#receive-amount').html(' --- ');

    $(".formInput").attr("disabled", true);

    $('.displayTxt').html('Loading ...');

    $('#withdrawBtnSubmit').html('Loading ...');

    $.post(base_url+'witdraw-details', {

        currencyId : currencyId,

    }, function(output, status){

         $(".displayTxt").removeClass("spinner-border spinner-border-sm");
         $('.addressTag').hide();

        var result = JSON.parse(output);

        if(status) {

            if(result.status) {

                let output = result.data;
                $('#currency-balance').html(output.balance);
                $('#minimum-amount').html(output.min_amount);
                $('#maximum-amount').html(output.max_amount);
                $('#fee-amount').html(output.fee_amount);
                $('#user-fee').val(output.user_fee);
                $('#wth-currency').val(output.currency);
                $(".spinner-border").removeClass("invisible");
                $(".nill").addClass("invisible");
                $(".formInput").attr("disabled", false);

                if(output.address_tag == 1){
                    $('.addressTag').show();
                }

            } else {

                $(".displayTxt").html(" --- ");

                $.notify(result.msg, {className: 'error',clickToHide: true,});
            }

        } else {

            $(".displayTxt").html(" --- ");

            $.notify('Invalid request.', {className: 'error',clickToHide: true,});
        }

        $('#withdrawBtnSubmit').html('Withdraw Request');
    });
}



$("#withdrawForm").validate({

rules: {
  currency : { required : true },
  withdraw_amount : { required : true, decimal : true },
  receive_address : { required : true },
  address_tag : { required : true },
  security_pin : { required : true, number : true, maxlength : 6, minlength:6 },
  email_otp : {required : true, number : true}
},

messages : {

  currency: { required : "Please choose corresponding currency" },
  address_tag: { required : "Please enter the address tag" },
  receive_address: { required : "Please enter the receive address" },
  withdraw_amount: { required : "Please enter the withdraw amount" },
  security_pin: {
    required : "Please enter the valid security pin",
    number : 'Numbers only allowed',
    maxlength : '6 Digits numbers only allowed',
    minlength : '6 Digits numbers only allowed',
  },
  email_otp : {required : "Please enter email OTP"},
},

submitHandler: function(form) {

  $("#withdrawBtnSubmit").attr("disabled", true);
  $("#withdrawBtnSubmit").html('Loading ...');

  form.submit();
}

});




function send_withdraw_email($user_id){

    var user_id = $user_id;

          $.ajax({
            url: base_url+"sendwithdrawotp",
            type: "POST",
            data: {'value' : user_id},
            cache:false,
            async:true,
            beforeSend: function() {
                $('.withdrawBtn').prop('disabled', true);
                $('.withOTPbtn').prop('disabled', true);

                $('.withOTPbtn').show();
            },
            success: function (data) {

              var res = JSON.parse(data);
              console.log(res);
                if(res.status == 1){
                   $('.withdrawBtn').prop('disabled', false);
                   $('.withOTPbtn').prop('disabled', false);
                   $('.withOTPbtn').hide();
                   toastr.success(res.msg, {className: 'success',clickToHide: true,});


                }else{
                  $('.withdrawBtn').prop('disabled', false);
                  $('.withOTPbtn').prop('disabled', false);
                  $('.withOTPbtn').hide();
                  toastr.error(res.msg, {className: 'error',clickToHide: true,});

                }


            }
        });
}
