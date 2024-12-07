@include('user.common.header')


<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ URL::to('/') }}"><i class="far fa-home"></i> Home</a></li>
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
                                <h2 class="site-title">{{$title}}</h2>
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
                                        <div class="card-body mt-4">
                                            <p class="mb-3">Please make sure your trade details are valid before submit</p>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-12 col-lg-6">
                                                <div class="card">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="planname">
                                                            <h5>Trade Name</h5>
                                                        </div>
                                                        <div class="plann">
                                                            <p><?php echo @$checkPlan->name; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="card">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="planname">
                                                                <h5>Cancel Fee</h5>
                                                            </div>
                                                            <div class="plann">
                                                                <p>{{$checkPlan->cancel_fee}} %</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>


                                <form id="form" action="{{ url('submitCancelInvestment') }}" method="post" autocomplete="off">
                                                    {{ csrf_field() }}


                                                <div class=" d-flex justify-content-end mt-3">

                                                    <a class="theme-btn mx-2 mt-20" href="<?php echo url('Investment'); ?>">
                                                        Discard
                                                    </a>

                                                    <input type="hidden" name="submit" value="submit">
                                                    <input type="hidden" name="planId" value="<?php echo $checkPlan['id']; ?>">
                                                    <input type="hidden" name="currencyId" value="USD">

                                                    <button type="submit" name="login_btn" id="login_btn" onclick="confirmSubmit()" value="submit" class="theme-btn mx-2 mt-20 login_btn">Confirm</button>
                                                    <button type="button" name="loader" id="loader" class="theme-btn mx-2 mt-20" style="display: none;">Loading ...</button>

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
        text: "Are you sure you plan cancelled",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, confirm it!",
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user confirms, continue with form submission via AJAX
          $('#myForm').submit();

          submitFormViaAjax();
        }
      });
    }

    // Function to submit the form via AJAX
    function submitFormViaAjax() {
      var formData = new FormData(document.getElementById("form"));

      $.ajax({
        url: base_url+"submitCancelInvestment",
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
              window.location.href = base_url + 'Investment';
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
