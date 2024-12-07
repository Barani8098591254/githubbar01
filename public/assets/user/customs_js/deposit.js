$(document).ready(function(){
	// $('.qr-codes').hide();
	var curr = $('.curr :selected').val();

    address_calback(curr);
    $('.curr').on('change', function() {

	  var curr = this.value;
	  address_calback(curr);
	});


	function address_calback(curr){

		if(curr){

			 $.ajax({
	            url: base_url+"create_address/"+curr,
	            type: "POST",
	             async:true,
	            beforeSend: function() {
                    $('.depositeloder').show();

	                $('#address').val('Loading...');
	            },
	            success: function (data) {

	              var res = JSON.parse(data);

	                if(res.status == 1){
                        $('.depositeloder').hide();
	                	var address = res.address;
	                	var curr 	= res.currency;
	                	var qrcode	= res.qrcode;
	                	var balance = res.balance;
	                	var network = res.network;

	                	$('#bal').html(balance+' '+curr);
	                    $('#address').val(address);
	                    $('.qr-codes').attr('src', qrcode);
	                    $('.currency_network').html(network);
	                    $('.qrCodess').show();
	                    if(curr == 'XRP'){
	                    	$('.xrp-tag').show();
	                    	$('#tag').val(res.tag);
	                    }else{
	                    	$('.xrp-tag').hide();
	                    	$('#tag').val(res.tag);
	                    }


	                     if(curr == 'XLM'){
	                     	console.log(res.tag);
	                    	$('.xlm-tag').show();
	                    	$('#xlmtag').val(res.tag);
	                    }else{
	                    	$('.xlm-tag').hide();
	                    	$('#xlmtag').val(res.tag);
	                    }

	                }else if(res.status == 2){
	                	  var curr 	= '';
	                    var qrcode	= res.qrcode;
	                    var balance = res.balance;
	                    var network = '';
                        $('.depositeloder').hide();

	                	  $('#bal').html(balance+' '+curr);
		                  $('#address').val('');
		                  $('.qr-codes').attr('src', qrcode);
		                  $('.currency_network').html(network);
	                    $('.qrCodess').hide();

	                }else{
	                  var curr 	= res.currency;
	                  var balance = res.balance;
	                  var qrcode	= res.qrcode;
	                  var network = res.network;
                      $('.depositeloder').hide();

	                  $('#bal').html(balance+' '+curr);
	                  $('#address').val('');
	                  $('.qr-codes').attr('src', qrcode);
	                  $('.currency_network').html(network);
	                   $('.qrCodess').hide();

	                  toastr.error('Invalid Address', {timeOut: 2000});

	                }


	            }
	        });

		}else{

		}
	}


	$.validator.addMethod('decimal', function(value, element) {
		return this.optional(element) || /^\d*(\.\d+)?$/.test(value);
	}, "Please enter the valid amount.");


  $("#withdrawForm").validate({

    rules: {
      currency : { required : true },
      withdraw_amount : { required : true, decimal : true },
      receive_address : { required : true },
      address_tag : { required : true },
      security_pin : { required : true, number : true, maxlength : 6, minlength:6 },
    },

    messages : {

      currency: { required : "Please choose corresponding currency" },
      address_tag: { required : "Please enter the address tag" },
      receive_address: { required : "Please enter the receive address" },
      withdraw_amount: { required : "Please enter the withdraw amount" },
      security_pin: {
        required : "Please enter the valid security pin",
        number : 'Numbers only allowed.',
        maxlength : '6 Digits numbers only allowed.',
        minlength : '6 Digits numbers only allowed.',
      },
    },

    submitHandler: function(form) {

      $("#withdrawBtnSubmit").attr("disabled", true);
      $("#withdrawBtnSubmit").html('Loading ...');

      form.submit();
    }

  });

});
