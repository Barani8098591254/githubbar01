@include('admin.common.header')
@include('admin.common.sidebar')





<div class="page-wrapper" style="min-height: 373px;">
    <div class="container-fluid">

        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h5 class="txt-dark">{{$title}}</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                <li><a href="{{adminBaseurl()}}dashboard">Dashboard</a></li>
                <li><a href="{{adminBaseurl()}}swaplist">Swap List</a></li>
                <li class="active"><span>{{$title}}</span></li>

              </ol>
            </div>
            <!-- /Breadcrumb -->
        </div>


        <!-- Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default card-view">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">

                                        <div class="form-wrap">
                                                <div class="form-body">
                                                    <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Add Swap Pair</h6>
                                                    <hr class="light-grey-hr">
                                                    <div class="div-one">
                                            <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/swapstore" method="post" name="createswap" id="createswap" class="swap-Form" novalidate="novalidate">
                                                {{ csrf_field() }}


                                                                                      <!-- /Row -->
                                                                                      <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label mb-10"> From Currency </label>
                                                                                                <select class="form-control valid" name="from_currency" id="from_currency" data-placeholder="Choose a Category" tabindex="1" aria-invalid="false" onchange="changeFromCurrency(this);">
                                                                                                    <option value="">Select Value</option>
                                                                                                    <?php foreach ($currencyResult as $key => $value) { ?>
                                                                                                        <option value="<?php echo $value['id']; ?>" data-foo="<?php echo $value['symbol']; ?>"><?php echo $value['symbol']; ?></option>
                                                                                                    <?php } ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label mb-10"> To Currency </label>
                                                                                                <select class="form-control valid" name="to_currency" id="to_currency" data-placeholder="Choose a Category" tabindex="1" aria-invalid="false" onchange="changeToCurrency(this);">
                                                                                            <option value="">Select Value</option>
                                                                                                  <?php foreach ($currencyResult as $key => $value) { ?>
                                                                                                        <option value="<?php echo $value['id']; ?>" data-foo="<?php echo $value['symbol']; ?>"><?php echo $value['symbol']; ?></option>
                                                                                                    <?php } ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <!-- /Row -->


                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                          <div class="form-group">
                                                                                            {{-- <input type="text" id="id" name="id" class="form-control" value="{{$userid}}" readonly=""> --}}
                                                                                             <label class="control-label mb-10"><?= 'Pair' ?></label>
                                                                                            <input type="text" id="pair" name="pair" class="form-control" value="" readonly="">
                                                                                            <input class="form-control" type="hidden" name="pair_value" id="pair_value">
                                                                                          </div>
                                                                                        </div>
                                                                                        <!--/span-->
                                                                                        <div class="col-md-6">
                                                                                          <div class="form-group">
                                                                                            <label class="control-label mb-10">Binance Pair ( *Note: Kindly give correct binance pair ) </label>
                                                                                            <input type="text" id="binance_pair" name="binance_pair" class="form-control" value="" placeholder="Binance Pair">
                                                                                          </div>
                                                                                        </div>
                                                                                        <!--/span-->
                                                                                      </div>


                                                                                      <div class="row">
                                                                                        <div class="col-md-6">
                                                                                          <div class="form-group">
                                                                                             <label class="control-label mb-10">Min</label>
                                                                                            <input type="text" id="min" name="min" class="form-control" value="" placeholder="min">
                                                                                          </div>
                                                                                        </div>
                                                                                        <!--/span-->
                                                                                        <div class="col-md-6">
                                                                                          <div class="form-group">
                                                                                            <label class="control-label mb-10">Max</label>
                                                                                            <input type="text" id="max" name="max" class="form-control" value="" placeholder="max">
                                                                                          </div>
                                                                                        </div>
                                                                                        <!--/span-->
                                                                                      </div>


                                                                                      <div class="row">
                                                                                        <div class="col-md-6">
                                                                                          <div class="form-group">
                                                                                             <label class="control-label mb-10">Fee</label>
                                                                                            <input type="text" id="fee" name="fee" class="form-control" value="" placeholder="Fee">
                                                                                          </div>
                                                                                        </div>
                                                                                        <!--/span-->
                                                                                        <div class="col-md-6">
                                                                                          <div class="form-group">
                                                                                            <label class="control-label mb-10">Fee Type</label>

                                                                                            <select class="form-control" name="fee_type" id="fee_type" data-placeholder="Choose a Category" tabindex="1">
                                                                                            <option value="">Select value</option>
                                                                                            <option value="crypto">Crypto</option>
                                                                                            <option value="indices">Indices</option>
                                                                                            <option value="shares">Shares</option>
                                                                                            <option value="commodity">Commodity</option>
                                                                                            <option value="fiat">Fiat</option>

                                                                                        </select>

                                                                                        </div>
                                                                                        </div>
                                                                                        <!--/span-->
                                                                                      </div>



                                                                                      <div class="row">
                                                                                        <div class="col-md-6">
                                                                                          <div class="form-group">
                                                                                             <label class="control-label mb-10">Status</label>
                                                                                             <select class="form-control" name="status" id="status"data-placeholder="Choose a Category" tabindex="1">
                                                                                             <option value="1">Active</option>
                                                                                             <option value="0">Inactive</option>
                                                                                         </select>
                                                                                          </div>
                                                                                        </div>
                                                                                        <!--/span-->
                                                                                        <div class="col-md-6">
                                                                                          <div class="form-group">
                                                                                            <label class="control-label mb-10">Spread</label>
                                                                                            <input type="text" id="spread" name="spread" class="form-control" value="" placeholder="Spread">
                                                                                          </div>
                                                                                        </div>
                                                                                        <!--/span-->
                                                                                    </div>

                                                    <div class="form-actions mt-10">
                                                        <button type="submit" class="btn btn-success mr-10" id="btno-submit">Submit <i class="fa fa-spinner fa-spin" id="spino" style="font-size:20px; display:none;"></i></button>
                                                    </div>
                                                </form>
                                            </div>


                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Row -->






@include('admin.common.footer')


<script>
    $(document).ready(function() {
        $("#from_currency, #to_currency").change(updatePair);
    });

    function updatePair() {
        const fromCurrency = $("#from_currency").val();
        const toCurrency = $("#to_currency").val();

        if (!fromCurrency || !toCurrency || fromCurrency === toCurrency) {
            // Clear the pair fields if either currency is not selected or if both are the same
            $("#pair, #pair_value").val("");
        } else {
            const fromSymbol = $("#from_currency option:selected").data("foo");
            const toSymbol = $("#to_currency option:selected").text();
            const pair = fromSymbol + "_" + toSymbol;

            // Update the pair fields
            $("#pair, #pair_value").val(pair);
        }
    }
</script>




<script>
    function changeFromCurrency(select) {
        var fromCurrencyValue = select.value;
        var toCurrencyValue = document.getElementById('to_currency').value;

        if (fromCurrencyValue === toCurrencyValue) {
            alert("From Currency and To Currency cannot be the same.");

        }
    }

    function changeToCurrency(select) {
        var toCurrencyValue = select.value;
        var fromCurrencyValue = document.getElementById('from_currency').value;

        if (toCurrencyValue === fromCurrencyValue) {
            alert("From Currency and To Currency cannot be the same.");

        }
    }
    </script>
