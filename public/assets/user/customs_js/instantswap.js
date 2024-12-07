$(document).ready(function(){

    $("#buyswap").validate({
      rules: {
        swapbuypair: {
          required: true,
        },
        fromAmount: {
          required: true,
        },
        toAmount: {
          required: true,
        },
      },
      messages : {
        swapbuypair : {
          required : "Pai is required"
        },
        fromAmount: {
          required : "Enter the from amount",
        },
        toAmount: {
          required : "Enter the to amount",
        },
      },
      submitHandler: function(form) {
        $("#buyswapsubmit").hide();
        $("#buyswaploader").show();
        form.submit();
      },
    });
});
  // need code
  $(".afterSelectPair").hide();
  $(".afterSelectPairSell").hide();
  $("#buyswapgetdata").hide();
  $("#sellswapgetdata").hide();
  // initial load in buypair
    buyPair({"value":""});
  // buy pair select
    var buypairvalue;
    var buybinancepairvalue;
    function buyPair(selected){
      // hide chart data
        $("#buychartdata").hide();
        $("#buychartdataloading").hide();
      var buypairselectedValue   = selected.value;
      if(buypairselectedValue == '' || buypairselectedValue == 'null' || buypairselectedValue == null){
        $(".notifyjs-hidable").hide();
        // toastr.error('Kindly selecte the valid pair !!!', {timeOut: 2000});

        $(".afterSelectPair").hide();
      }else{
        $.ajax({
          url: base_url+"getapairdata",
          type: "POST",
          data: {"pair_id":buypairselectedValue},
          beforeSend: function() {
            $(".afterSelectPair").hide();
            $("#buyswapgetdata").show();
          },
          success: function (pairResponseData) {
            var res = JSON.parse(pairResponseData);
            if(res.status == 1){
              var pairData                      = res.particullarpairData;
              var buypair                       = pairData.pair;
              var pairDatas                     = buypair.split("_");
              var buypairfromCurrencyValue      = pairDatas[0];
              var buypairtoCurrencyValue        = pairDatas[1];
              buypairvalue                      = pairData.pair;
              buybinancepairvalue               = pairData.bmarketpair;

              var buypairmarketprice            = pairData.marketprice;
              var buypairmin                    = pairData.min;
              var buypairmax                    = pairData.max;
              var buypairspread                 = pairData.spread;
              var buypairfromcurrency           = pairData.from_currency;
              var buypairtocurrency             = pairData.to_currency;
              var buypairfee                    = pairData.fee;

              var fromCurrencyBalance           = res.userFromBalance.toFixed(8);
              var toCurrencyBalance             = res.userToBalance.toFixed(8);

              // calculation part
                var buySpreadValue              = (+buypairmarketprice) * (+buypairspread) / 100;
                var buyMarketPriceValue         = (+buySpreadValue) + (+buypairmarketprice);

              // set id calls value
                $(".swapbuyfromcurrency").html(buypairfromCurrencyValue);
                $(".swapbuytocurrency").html(buypairtoCurrencyValue);
                $("#swapbuyfrombalance").html(fromCurrencyBalance);
                $("#swapbuytobalance").html(toCurrencyBalance);
                $("#swapbuymarketprice").html(buyMarketPriceValue);
                $("#swapbuymin").html(buypairmin);
                $("#swapbuymax").html(buypairmax);

                $("#marketPrice").val(buyMarketPriceValue);
                $("#swapbuyfee").val(buypairfee);
                // $("#pair").val(buypair);
                $("#fromAmount").val('');
                $("#toAmount").val('');

              // show page content
                $(".afterSelectPair").show();
                $("#buyswapgetdata").hide();

              // load chart data
                // buyChartData(buypairselectedValue);
            }else{
              $("#buyswapgetdata").hide();
              $(".notifyjs-hidable").hide();
              toastr.error(res.msg, {timeOut: 2000});
            }
          }
        });
      }
    }



  // from amount key up
    function buyFromKeyup(e){
      var buyFromAmountValue  = e.value;
      var toCurBalance        = $("#swapbuytobalance").text();
      // var buymarketprice      = $("#marketPrice").val();
      var buymarketprice      = $("#swapbuymarketprice").text();
      var toBoxValue          = (+buymarketprice) * (+buyFromAmountValue);
      toBoxValue              = toBoxValue;
      if((+toBoxValue) > toCurBalance){
        $(".notifyjs-hidable").hide();
        toastr.error('Insufficiant Balance', {timeOut: 2000});
        $("#toAmount").attr('placeholder',toBoxValue);
        $("#toAmount").val("");return;
      }else{
        var swapbuymin        = $("#swapbuymin").text();
        var swapbuymax        = $("#swapbuymax").text();
        if(((+swapbuymin) > (+toBoxValue)) || ((+swapbuymax) < (+toBoxValue))){
          $(".notifyjs-hidable").hide();
          toastr.error('Spend Amount not in Min and Max value range. Kindly check it.', {timeOut: 2000});
          $("#toAmount").attr('placeholder',toBoxValue);
          $("#toAmount").val("");return;
        }
        $("#toAmount").val(toBoxValue);
        var swapbuyfee            = $("#swapbuyfee").val();
        var feevalue              = (+buyFromAmountValue) * (+swapbuyfee) / 100;
        var swapbuyrecevieamount  = (+buyFromAmountValue) - (+feevalue);
        $("#swapbuyfeeamount").html(feevalue.toFixed(8));
        $("#swapbuyrecevieamount").html(swapbuyrecevieamount.toFixed(8));
      }
    }

    function buyToKeyup(e){
      var buyToAmountValue    = e.value;
      var toCurBalance        = $("#swapbuytobalance").text();
      if((+buyToAmountValue) > toCurBalance){
        $(".notifyjs-hidable").hide();
        toastr.error('Insufficiant Balance', {timeOut: 2000});
        $("#fromAmount").val("");return;
      }else{
        // var buymarketprice    = $("#marketPrice").val();
        var buymarketprice    = $("#swapbuymarketprice").text()
        var fromBoxValue      = (+buyToAmountValue) / (+buymarketprice);
        fromBoxValue          = fromBoxValue;
        var swapbuymin        = $("#swapbuymin").text();
        var swapbuymax        = $("#swapbuymax").text();
        if(((+swapbuymin) > (+buyToAmountValue)) || ((+swapbuymax) < (+buyToAmountValue))){
          $(".notifyjs-hidable").hide();
          toastr.error('Spend Amount not in Min and Max value range. Kindly check it.', {timeOut: 2000});
          $("#fromAmount").attr('placeholder',fromBoxValue);
          $("#fromAmount").val("");return;
        }
        $("#fromAmount").attr('placeholder',fromBoxValue);
        $("#fromAmount").val(fromBoxValue);

        var swapbuyfee            = $("#swapbuyfee").val();
        var feevalue              = (+fromBoxValue) * (+swapbuyfee) / 100;
        var swapbuyrecevieamount  = (+fromBoxValue) - (+feevalue);
        $("#swapbuyfeeamount").html(feevalue.toFixed(8));
        $("#swapbuyrecevieamount").html(swapbuyrecevieamount.toFixed(8));
      }
    }

    // buy-swap amount percentage
      function buyamountPercentage(percentage){
        var buyToCurBalance     = $("#swapbuytobalance").text();
        if((+buyToCurBalance)>0){
          var perAmount           = (+buyToCurBalance) * (+percentage) / 100;
          perAmount               = (+buyToCurBalance) * (+percentage) / 100;
          $("#toAmount").val(perAmount);
          buyToKeyup({"value":perAmount});
        }else{
          $(".notifyjs-hidable").hide();
          toastr.error('Insufficiant Balance', {timeOut: 2000});
          $("#fromAmount").val("");return;
        }
      }




    // sell pair select
    sellPair({"value":""});
    var sellpairvalue;
    var sellbinancepairvalue;
    function sellPair(selected){
      // hide chart data
        $("#sellchartdata").hide();
        $("#sellchartdataloading").hide();
      var sellpairselectedValue   = selected.value;
      if(sellpairselectedValue == '' || sellpairselectedValue == 'null' || sellpairselectedValue == null){
        $(".notifyjs-hidable").hide();
        // toastr.error('Kindly selecte the valid pair !!!', {timeOut: 2000});
        $(".afterSelectPairSell").hide();
      }else{
        $.ajax({
          url: base_url+"getapairdata",
          type: "POST",
          data: {"pair_id":sellpairselectedValue},
          beforeSend: function() {
            $(".afterSelectPairSell").hide();
            $("#sellswapgetdata").show();
          },
          success: function (pairResponseData) {

            var res = JSON.parse(pairResponseData);
            if(res.status == 1){
              var pairData                       = res.particullarpairData;
              var sellpair                       = pairData.pair;
              var pairDatas                      = sellpair.split("_");
              var sellpairfromCurrencyValue      = pairDatas[0];
              var sellpairtoCurrencyValue        = pairDatas[1];
              sellpairvalue                      = pairData.pair;
              sellbinancepairvalue               = pairData.bmarketpair;

              var sellpairmarketprice            = pairData.marketprice;
              var sellpairmin                    = pairData.min;
              var sellpairmax                    = pairData.max;
              var sellpairspread                 = pairData.spread;
              var sellpairfromcurrency           = pairData.from_currency;
              var sellpairtocurrency             = pairData.to_currency;
              var sellpairfee                    = pairData.fee;

              var fromCurrencyBalance           = res.userFromBalance.toFixed(8);
              var toCurrencyBalance             = res.userToBalance.toFixed(8);

              // calculation part
                var sellSpreadValue              = (+sellpairmarketprice) * (+sellpairspread) / 100;
                var sellMarketPriceValue         = (+sellpairmarketprice) - (+sellSpreadValue);
                console.log('fromCurrencyBalance---------->',fromCurrencyBalance);
              // set id calls value
                $(".swapsellfromcurrency").html(sellpairfromCurrencyValue);
                $(".swapselltocurrency").html(sellpairtoCurrencyValue);
                $("#swapsellfrombalance").html(fromCurrencyBalance);
                $("#swapselltobalance").html(toCurrencyBalance);
                $("#swapsellmarketprice").html(sellMarketPriceValue);
                $("#swapsellmin").html(sellpairmin);
                $("#swapsellmax").html(sellpairmax);

                $("#marketPrice").val(sellMarketPriceValue);
                $("#swapsellfee").val(sellpairfee);
                // $("#pair").val(sellpair);
                $("#sellfromAmount").val('');
                $("#selltoAmount").val('');

                  // show page content
                $(".afterSelectPairSell").show();
                $("#sellswapgetdata").hide();

              // load chart data
            }else{
              $("#sellswapgetdata").hide();
              $(".notifyjs-hidable").hide();
              toastr.error(res.msg, {timeOut: 2000});
            }
          }
        });
      }
    }



    // from amount key up
    function sellFromKeyup(e){

      var sellFromAmountValue   = e.value;
      // var sellmarketprice     = $("#marketPrice").val();
      var sellmarketprice     = $("#swapsellmarketprice").text();
      var fromCurBalance        = $("#swapsellfrombalance").text();
      var toBoxValue          = (+sellmarketprice) * (+sellFromAmountValue);
      toBoxValue              = toBoxValue;
      if((+sellFromAmountValue) > fromCurBalance){

        var fromCur             = $("#swapsellfromcurrency").text();
        $(".notifyjs-hidable").hide();
        toastr.error('Insufficiant Balance', {timeOut: 2000});
        $("#selltoAmount").attr('placeholder',toBoxValue);
        $("#selltoAmount").val("");
      }else{


        var swapsellmin         = $("#swapsellmin").text();
        var swapsellmax         = $("#swapsellmax").text();

        if(((+swapsellmin) > (+toBoxValue)) || ((+swapsellmax) < (+toBoxValue))){
          $(".notifyjs-hidable").hide();
          toastr.error('Recevie Amount not in Min and Max value range. Kindly check it.', {timeOut: 2000});
          $("#selltoAmount").attr('placeholder',toBoxValue);
          $("#selltoAmount").val("");
        }
        $("#selltoAmount").val(feevalue);
        $("#selltoAmount").attr('placeholder',toBoxValue);
        $("#selltoAmount").val("");
        var swapsellfee             = $("#swapsellfee").val();
        var feevalue                = (+toBoxValue) * (+swapsellfee) / 100;
        var swapsellrecevieamount   = (+toBoxValue) - (+feevalue);
        $("#swapsellfeeamount").html(feevalue.toFixed(8));
        $("#swapsellrecevieamount").html(swapsellrecevieamount.toFixed(8));
      }
    }

    function sellToKeyup(e){
      var sellToAmountValue     = e.value;
      var fromCurBalance        = $("#swapsellfrombalance").text();
      // var sellmarketprice       = $("#marketPrice").val();
      var sellmarketprice       = $("#swapsellmarketprice").text();
      var fromBoxValue          = (+sellToAmountValue) / (+sellmarketprice);
      if((+fromBoxValue) > (+fromCurBalance)){
        $(".notifyjs-hidable").hide();
        toastr.error('Insufficiant Balance', {timeOut: 2000});
        $("#sellfromAmount").attr('placeholder',fromBoxValue);
        $("#sellfromAmount").val("");
      }else{
        var swapsellmin         = $("#swapsellmin").text();
        var swapsellmax         = $("#swapsellmax").text();
        if(((+swapsellmin) > (+sellToAmountValue)) || ((+swapsellmax) < (+sellToAmountValue))){
          $(".notifyjs-hidable").hide();
          toastr.error('Recevie Amount not in Min and Max value range. Kindly check it.', {timeOut: 2000});
          $("#sellfromAmount").attr('placeholder',fromBoxValue);
          $("#sellfromAmount").val("");return;
        }
        $("#sellfromAmount").val(fromBoxValue);

        var swapsellfee             = $("#swapsellfee").val();
        var feevalue                = (+sellToAmountValue) * (+swapsellfee) / 100;
        var swapsellrecevieamount   = (+sellToAmountValue) - (+feevalue);
        $("#swapsellfeeamount").html(feevalue.toFixed(8));
        $("#swapsellrecevieamount").html(swapsellrecevieamount.toFixed(8));
      }
    }

  // sell-swap amount percentage
    function sellamountPercentage(percentage){
      var sellfromCurBalance  = $("#swapsellfrombalance").text();
      if((+sellfromCurBalance)>0){
        var perAmount           = (+sellfromCurBalance) * (+percentage) / 100;
        var perAmount           = (+sellfromCurBalance) * (+percentage) / 100;
        $("#sellfromAmount").val(perAmount);
        sellFromKeyup({"value":perAmount});
      }else{
        $(".notifyjs-hidable").hide();
        toastr.error('Insufficiant Balance', {timeOut: 2000});
        $("#selltoAmount").attr('placeholder',toBoxValue);
        $("#selltoAmount").val("");
      }
    }

