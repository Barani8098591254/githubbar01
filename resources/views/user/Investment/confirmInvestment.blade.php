@include('user.common.header')

<style>
    .custom-select-container {
    position: relative;
    width: 30%;
}

.form-control.plann {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    padding-right: 30px; /* Adjust this value to make space for the arrow */
    border: 1px solid #ccc; /* Add border for a cleaner look */
    border-radius: 4px; /* Optional: Add border-radius for rounded corners */
}

.custom-select-arrow {
    position: absolute;
    top: 50%;
    right: 10px; /* Adjust this value to position the arrow */
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 6px 6px 0 6px;
    border-color: #555 transparent transparent transparent; /* Adjust arrow color */
}

/* Style the dropdown to show a scrollbar */
.custom-select-container select {
    overflow-y: auto;
    max-height: 150px; /* Adjust this value based on your design */
    border: none; /* Remove default select border */
}

/* Optional: Style the options in the dropdown */
.custom-select-container select option {
    padding: 10px;
    background-color: #fff; /* Set background color for options */
}

/* Optional: Style the dropdown when it's open */
.custom-select-container select:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(81, 203, 238, 1); /* Add a subtle box-shadow for focus effect */
}

</style>

<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ URL::to('/') }}"><i class="far fa-home"></i> Home</a></li>
                <li><a href="{{ URL::to('/Investment') }}"></i> Investment</a></li>
                <li class="active">{{$subTitle}}</li>
            </ul>
        </div>
    </div>


    <div class="dashboard-area pt-70 pb-70">
        <div class="container">
            <div class="row">

                @include('user.common.settingTab')

                <div class="col-lg-9 col-md-8">
                    <div class="dashboard-content">
                        <div class="dashboard-content-head">

                            <div class="unique">
                                <h2 class="site-title">Confirm your trade</h2>
                                <h4></h4>

                            </div>
                        </div>
                        <div class="dashboard-referral mt-5">
                            <div class="dashboard-card">
                                <!-- <h3>Your Referral Link</h3> -->
                                <div class="dashboard-referral-link">

                                    <div class="card-header">
                                        <div class="card-title">
                                            <h4>Your Trade Details</h4>

                                        </div>

                                        <div class=" mb-4">

                                            <div class="balance d-flex justify-content-end">
                                            <span class="text-dark"> Balance:  &nbsp </span>
                                            <span id="inetrtransferbalance" class="text-dark text-bold"> {{$getBalance}} {{get_currency($currId)->symbol}} </span>  &nbsp <span class="text-dark text-bold currSymbols"></span>
                                            <span id="inetrtransfercurrency" style=" font-weight: bold;"></span>
                                          </div>


                                            <div class="row">
                                                <div class="col-md-12 col-lg-6 ">
                                                    <div class="card mt-4">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="planname">
                                                                <h5>Trade Name</h5>
                                                            </div>
                                                            <div class="plann">
                                                                <p><?php echo @$checkPlan->name; ?></p>
                                                                <input type="hidden"  id="planIds" name="planId" value="{{$planId}}">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-12 col-lg-6">
                                                    <div class="card mt-4">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="planname">
                                                                <h5>Payment Currency</h5>
                                                            </div>
                                                            <div class="custom-select-container">
                                                                <select class="form-control plann valid" aria-label="Default select example" name="currency_id" id="swapbuypair" onchange="interCurrency(this);">
                                                                    <option selected>Select Currency</option>
                                                                        @foreach($currency as $currencyOption)
                                                                        <option value="{{ $currencyOption->id }}" @if($currencyOption->id == $currId) selected @endif>
                                                                            {{ $currencyOption->symbol }}
                                                                        </option>
                                                                    @endforeach
                                                                     </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}



                                                    <div class="col-md-12 col-lg-6">
                                                        <div class="card mt-4">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="planname">
                                                                    <h5>Payment Currency</h5>
                                                                </div>
                                                                <div class="custom-select-container">
                                                                    <select class="form-control plann valid" aria-label="Default select example" name="currency_id" id="swapbuypair" onchange="interCurrency(this);">
                                                                        <option selected>Select Currency</option>
                                                                        @foreach($currency as $currencyOption)
                                                                        <option value="{{ $currencyOption->id }}" @if($currencyOption->id == $currId) selected @endif>
                                                                            {{ $currencyOption->symbol }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="custom-select-arrow"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                            </div>



                                            <div class="row mt-4">


                                                <div class="col-md-12 col-lg-6">
                                                    <div class="card">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="planname">
                                                                <h5>Plan Price Value</h5>
                                                            </div>
                                                            <div class="plann">

                                                                <span id="plancurrencyprice" class="text-dark plann text-bold">{{getplan(encrypt_decrypt('decrypt',$planId))->price}}</span>
                                                                <span id="pricevalue" style="font-weight: bold;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12 col-lg-6">
                                                    <div class="card">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="planname">
                                                                <h5>Today ROI</h5>
                                                            </div>
                                                            <div class="plann">
                                                                <p><?php echo $checkPlan['roi_commission']; ?> %</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>





                                            <form  id="form" action="{{ url('submitInvestment') }}" method="post" autocomplete="off">
                                                {{ csrf_field() }}
                                            <div class=" d-flex justify-content-end mt-3">

                                                <a class="theme-btn mx-2 mt-20" href="<?php echo url('Investment'); ?>">
                                                    Discard
                                                </a>

                                                <input type="hidden" name="submit" value="submit">
                                                <input type="hidden" name="planId" value="<?php echo $checkPlan['id']; ?>">
                                                <input type="hidden" name="currency_id"  id="currency_id" value="{{$currId}}">

                                                  <input type="hidden" name="price" id="price" value="{{getplan(encrypt_decrypt('decrypt',$planId))->price}}">

                                                <button type="submit" name="login_btn" id="login_btn" value="submit" class="theme-btn mx-2 mt-20 login_btn change_pattern">Confirm</button>
                                                <button type="button" name="loader" id="loader" class="theme-btn mx-2 mt-20 loaders" style="display: none;">Loading ...</button>

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

</main>



@include('user.common.footer')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<script>
    // Function to handle the form submission
    function handleFormSubmission() {
      // Show a SweetAlert confirmation dialog
      Swal.fire({
        title: "Are you sure?",
        text: "Are you sure plan confirm",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, confirm it!",
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user confirms, continue with form submission via AJAX
          submitFormViaAjax();
        }
      });
    }

    // Function to submit the form via AJAX
    function submitFormViaAjax() {
      var formData = new FormData(document.getElementById("form"));

      $.ajax({
        url: base_url + "submitInvestment",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        async: true,
            beforeSend: function() {
                        $('#login_btn').hide();
                        $('#loader').show();
                    },
        success: function (res) {


          if (res.status == 1) {
            $('.loaders').hide();
            $('.change_pattern').show();
            toastr.success(res.msg, 'success', { timeOut: 2000 });


            setTimeout(function () {
                window.location.href = base_url + 'Investmenthistory';
            }, 2000);
          } else {
            $('.loaders').hide();
            $('.change_pattern').show();
            toastr.error(res.msg, { timeOut: 2000 });
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    }



    // Attach the form submission handling to the form's submit event
    $("#form").on("submit", function (e) {
      e.preventDefault(); // Prevent the default form submission
      handleFormSubmission(); // Show the confirmation dialog
    });
  </script>






<script>
    function interCurrency(selected) {
      $("#inetrtransferbalance").html('Loading <i class="fas fa-spinner fa-spin"></i>');
      $("#plancurrencyprice").html('Loading <i class="fas fa-spinner fa-spin"></i>');
    //   $("#currency_id").html('Loading <i class="fas fa-spinner fa-spin"></i>');
      $("#inetrtransfercurrency").html('');
      $("#pricevalue").html('');
      $("#amount").val('');
      $("#withdrawcode").val('');

      var intercurrencyselectedValue = selected.value;
      var planId = $("#planIds").val(); // Fetch the planId from the hidden input field


      if (intercurrencyselectedValue === '' || intercurrencyselectedValue === 'null' || intercurrencyselectedValue === null) {
        toastr.error("Kindly select a valid currency !!!", { timeOut: 2000 });
      } else {
        $.ajax({
          url: base_url + "getCurrencyData",
          type: "POST",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          },
          data: { "currency_id": intercurrencyselectedValue },
          beforeSend: function() {
            // Any pre-AJAX request logic
          },
          success: function(currencyResponseData) {
            var res = JSON.parse(currencyResponseData);
            if (res.status == 1) {
              var userBalance = res.userBalance;
               $('.currSymbols').html(res.symbol)

              $("#inetrtransferbalance").html(userBalance);
              $("#inetrtransfercurrency").html($("#intercurrency option:selected").text());


              $.ajax({
                url: base_url + "getplanprice/" + planId,

                type: "GET",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                data: { "currency_id": intercurrencyselectedValue },
                beforeSend: function() {
                  // Any pre-AJAX request logic
                },

                success: function(planResponseData) {
                    var res = JSON.parse(planResponseData);
                    if (res.status == 1) {
                        var planPrice = res.planprice; // Use planPrice with a capital 'P'
                        var currency_id = res.currency_id
                        var price =  res.planprice
                        $("#plancurrencyprice").html(planPrice);
                        $("#currency_id").val(currency_id);
                        $("#price").val(price);


                // success: function(planResponseData) {
                //     var res = JSON.parse(planResponseData);
                //     if (res.status == 1) {
                //         var planprice = res.planprice;

                //         $("#plancurrencyprice").html(planPrice);
                        $("#pricevalue").html($("#intercurrency option:selected").text());

                    } else {
                        toastr.error(res.msg, { timeOut: 2000 });
                    }
                }
              });


            } else {
              toastr.error(res.msg, { timeOut: 2000 });
            }
          }
        });
      }
    }
    </script>

