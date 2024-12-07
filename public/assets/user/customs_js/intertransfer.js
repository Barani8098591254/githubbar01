
  // need code
  function interCurrency(selected) {

    $("#inetrtransferbalance").html('Loading <i class="fas fa-spinner fa-spin"></i>');
    $("#inetrtransfercurrency").html('');
    // $("#minimum-amount").html(''); // Clear the content
    // $("#maximum-amount").html(''); // Clear the content
    // $("#transferusername").val('');
    $("#amount").val('');
    $("#withdrawcode").val('');

    var intercurrencyselectedValue = selected.value;

    if (intercurrencyselectedValue === '' || intercurrencyselectedValue === 'null' || intercurrencyselectedValue === null) {
        toastr.error("Kindly select a valid currency !!!", { timeOut: 2000 });
    } else {
        $.ajax({
            url: base_url + "getCurrencyData",
            type: "POST",
            data: { "currency_id": intercurrencyselectedValue },
            beforeSend: function() {
            },
            success: function(currencyResponseData) {
                var res = JSON.parse(currencyResponseData);
                if (res.status == 1) {
                    var userBalance = res.userBalance;
                    var minAmount = res.minAmount; // Add this line to get the minimum amount
                    var maxAmount = res.maxAmount; // Add this line to get the maximum amount

                    // Set the values to the corresponding elements
                    $("#inetrtransferbalance").html(userBalance);
                    $("#inetrtransfercurrency").html($("#intercurrency option:selected").text());
                    $("#minimum-amount").html(minAmount); // Set the minimum amount
                    $("#maximum-amount").html(maxAmount); // Set the maximum amount

                } else {
                    toastr.error(res.msg, { timeOut: 2000 });
                }
            }
        });
    }
}


  $(document).ready(function(){
      $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
      });

      $("#intertransfer").validate({
        rules: {
          currency_id: {
            required: true,
          },
          transferusername: {
            required: true,
            alpha : true,
            minlength : 5,
            maxlength : 15,
          },
          amount: {
            required: true,
            min: 0.00000001,
          },
          withdrawcode: {
            required: true,
          },
        },
        messages : {
          currency_id : {
            required : "Currency is required"
          },
          transferusername: {
            required : "User name is required",
            alpha : "Letters Only allowed"
          },
          amount: {
            required : "Amount is required",
            min : "Please enter a value greater than or equal to 0.00000001",
          },
          withdrawcode: {
            required : "Security pin is required",
          },
        },
        submitHandler: function(form) {
          $("#transfersubmit").hide();
          $("#transferloader").show();
          form.submit();
        },
      });

      $("#redeemtransfer").validate({
        rules: {
          redeemcode: {
            required: true,
          },
          redeemwithdrawcode: {
            required: true,
          },
        },
        messages : {
          redeemcode : {
            required : "Redeem code is required"
          },
          redeemwithdrawcode: {
            required : "Security pin is required",
          },
        },
        submitHandler: function(form) {
          $("#redeemsubmit").hide();
          $("#redeemloader").show();
          form.submit();
        },
      });
  });

  // transferAmountKeyup key up
    function transferAmountKeyup(e){
      var buyFromAmountValue    = e.value;
      var intertransferBalance  = $("#inetrtransferbalance").text();
      if((+buyFromAmountValue) > intertransferBalance){
        $(".notifyjs-hidable").hide();
      toastr.error("Insufficiant Balance", {timeOut: 2000});


        $("#amount").val("");return;
      }else{
      }
    }



  //
    function validateForm (){
        $("#transfersubmit").hide();
          $("#transferloader").show();
    }
