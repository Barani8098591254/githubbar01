
@include('user.common.header')


<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{URL::to('/')}}"><i class="far fa-home"></i> Home</a></li>
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


                        <div class="transaction-wrapper deposit-ui">
                         <div class="transaction-wrapper profile-change">
                            <ul class="nav nav-pills mb-3 mt-3 justify-content-left" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="transaction-tab1" data-bs-toggle="pill"
                                        data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1"
                                        aria-selected="true">Withdraw</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="transaction-tab2" data-bs-toggle="pill"
                                        data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2"
                                        aria-selected="false">Withdraw History</button>
                                </li>
                            </ul>
                        </div>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                    aria-labelledby="transaction-tab1">

                                    <div class="dashboard-widget-wrapper mb-4">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-4">
                                                <div class="dashboard-widget">
                                                    <div class="dashboard-widget-content">
                                                        <h5>Currency Balance</h5>
                                                        <span class="withtitle" id="currency-balance">0.00000000</span>
                                                    </div>
                                                    <i class="flaticon-world"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="dashboard-widget">
                                                    <div class="dashboard-widget-content">
                                                        <h5>Miminum Amount</h5>
                                                        <span id="minimum-amount">0.00000000</span>
                                                    </div>
                                                    <i class="flaticon-wallet"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="dashboard-widget">
                                                    <div class="dashboard-widget-content">
                                                        <h5>Maximum Amount</h5>
                                                        <span id="maximum-amount">0.00000000</span>
                                                    </div>
                                                    <i class="flaticon-dollar"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="withdrawform">

                                        <div class="row align-items-center">
                                            <div class="col-md-12 col-lg-8">


                                                @if ($settingwithdraw->withdraw == 1)



                                                <form class="withdrawForm" id="withdrawForm"  method="post" action="<?php echo URL::to('withdrawSubmit') ?>" autocomplete="off">
                                                    {{ csrf_field() }}

                                                   <select class="form-select mb-4 curr" aria-label="Default select example" id="swapsellpair" name="currency" onchange="getCurrencyInfo(this.value)">
                                                            <option selected>Select Currency</option>

                                                            @php foreach ($currencyList as $key => $value) { @endphp
                                                                <option value="<?php echo $value->id; ?>" ><?php echo $value->symbol.' -'.$value->name; ?></option>
                                                               @php } @endphp
                                                   </select>

                                                      <div class="mb-4">

                                                            <input type="text" class="form-control" name="receive_address" id="exampleInputText receive_address" aria-describedby="emailHelp" placeholder="Wallet Address">

                                                      </div>
                                                      <div class="mb-4">

                                                            <input type="text" class="form-control" name="withdraw_amount" id="withdraw_amount" aria-describedby="emailHelp" oninput="enforceNumberValidation(this)" placeholder="Withdraw Amount">

                                                      </div>
                                                      <div class="row">
                                                      <div class="col-md-12 col-lg-6">
                                                        <div class="">

                                                            <input type="password" class="form-control" name="security_pin" id="exampleInputText security_pin" aria-describedby="emailHelp" placeholder="Security Pin">

                                                          </div>
                                                          @if(empty(user_details(userId(),'w_pin')))
                                                          <a href="{{URL::to('/')}}/profile" style="float:right">Set Reset Pin</a>
                                                          @endif
                                                      </div>
                                                      <div class="col-md-12 col-lg-6">
                                                        <div class="input-group">
                                                            <div class="input-group-append">
                                                                <input type="password" class="form-control" name="email_otp" id="exampleInputText email_otp" aria-label="emailHelp" placeholder="Email otp">

                                                                <button class="theme-btn  withdrawBtn" type="submit" onclick="send_withdraw_email('<?php echo encrypt_decrypt('encrypt',userId()); ?>');" name="withdrawBtn" id="button-addon2 withdrawBtn">Send Otp</button>

                                                                <button class="theme-btn withOTPbtn" type="button" name="loader" id="loader" id="button-addon2 withOTPbtn"  style="display: none;">Loading ...</button>

                                                              </div>

                                                          </div>
                                                          <label id="exampleInputText email_otp-error" class="error" for="exampleInputText email_otp"></label>
                                                      </div>
                                                    </div>
                                                     <input type="hidden" name="user-fee" id="user-fee">
                                                        <input type="hidden" name="wth-currency" id="wth-currency">
                                                    <div class="submtibtn mt-4">
                                                        <button type="submit" name="withdrawBtnSubmit" id="withdrawBtnSubmit" class=" withdraw-ui theme-btn withdrawBtn button">Withdraw Request</button>
                                                             </div>
                                                </form>


                                            @else
                                                <Span><h4 style="padding-left:115px">Withdraw disabled</h4></Span>
                                            @endif





                                            </div>
                                            <div class="col-md-12 col-lg-4">
                                                <div class="dashboard-widget1">
                                                    <div class="dashboard-widget-content">
                                                        <h5>Fee Amount</h5>
                                                        <span id="fee-amount">0.00000000</span>
                                                    </div>
                                                    <i class="flaticon-dollar"></i>
                                                </div>
                                                <hr class="bdr">
                                                <div class="dashboard-widget1">
                                                    <div class="dashboard-widget-content">
                                                        <h5>Receive Amount</h5>
                                                        <span id="receive-amount">0.00000000</span>
                                                    </div>
                                                    <i class="flaticon-dollar"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel"
                                    aria-labelledby="transaction-tab2">

                                    <div class="depositcont show-datas">
                                        <div class="dashboard-table table-responsive">
                                            <table class="table" id="withdrawList">
                                                <thead>
                                                <tr>
                                                    <th scope="col">S.No</th>
                                                    <th scope="col">TxID</th>
                                                    <th scope="col">Address</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Fee</th>
                                                    <th scope="col">Reciving Amount</th>
                                                    <th scope="col">Currency</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Dated On</th>
                                                </tr>
                                                </thead>

                                                </table>
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






<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>



<!-- Datatable JS -->

<script type="text/javascript">
    $(document).ready(function() {

    });

    function refresh() {
        location.reload();
    }

    $(document).on('click', '.copyAdd', function() {
        var value = $(this).attr('data-id');
        var textArea = document.createElement("textarea");
        textArea.value = value;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        toastr.success('copied !!!', 'Success', {
            timeOut: 2000
        });
    })
</script>

<script type="text/javascript">


function enforceNumberValidation(ele) {

    if ($(ele).data('decimal') != null) {
        // found valid rule for decimal
        var decimal = parseInt($(ele).data('decimal')) || 0;
        var val = $(ele).val();
        if (decimal > 0) {
            var splitVal = val.split('.');
            if (splitVal.length == 2 && splitVal[1].length > decimal) {
                // user entered invalid input
                $(ele).val(splitVal[0] + '.' + splitVal[1].substr(0, decimal));
            }
        } else if (decimal == 0) {
            // do not allow decimal place
            var splitVal = val.split('.');
            if (splitVal.length > 1) {
                // user entered invalid input
                $(ele).val(splitVal[0]); // always trim everything after '.'
            }
        }

    }

        calculateReceived();

}


 function calculateReceived() {

    var amount = $('#withdraw_amount').val();
    var fee = $('#user-fee').val();
    var symbol = $('#wth-currency').val();

    let received = amount - fee;
        console.log('received',received);

    if(received > 0) {
        received = received +' '+ symbol;
    } else {
        received = '0.0000000 '+ symbol;
    }



    $('#receive-amount').html(received);
}
</script>


<script>

$(document).ready(function(){

   // Datapicker
   $( ".datepicker" ).datepicker({
      "dateFormat": "yy-mm-dd",
      changeYear: true
   });

   // DataTable
     var dataTable = $('#withdrawList').DataTable({
      language: { search: "", searchPlaceholder: "Currency, Tx ID, Address"},
     'processing': true,
     'serverSide': true,
     'serverMethod': 'post',
     'searching': true,
     'ajax': {
       'url': base_urls+"/userwithdrawhistory",
       'data': function(data){
          // Read values
          var from_date = $('#search_fromdate').val();
          var to_date = $('#search_todate').val();

          // Append to data
          data.searchByFromdate = from_date;
          data.searchByTodate = to_date;
       }
     },
     'columns': [
        { data: 'id' },
        { data: 'txid' },
        { data: 'address' },
        { data: 'amount' },
        { data: 'fee' },
        { data: 'reciving_amt' },
        { data: 'currency' },
        { data: 'status' },

        { data: 'date' },
     ]
  });



  $('#withdrawList_filter input').attr('data-toggle', 'tooltip');
   $('#withdrawList_filter input').attr('title', 'Currency, Tx ID, Address');
   $('#withdrawList_filter input').tooltip({
      placement: 'top', // Adjust the placement as needed
      trigger: 'hover'
   });

  // Search button
  $('#btn_search').click(function(){
     dataTable.draw();
  });

});





</script>
