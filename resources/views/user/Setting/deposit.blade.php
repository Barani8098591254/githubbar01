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

                        <div class="transaction-wrapper deposit-ui">
                            <div class="transaction-wrapper profile-change">
                                <ul class="nav nav-pills mb-3 mt-3 justify-content-left" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="transaction-tab1" data-bs-toggle="pill"
                                            data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1"
                                            aria-selected="true">Deposit</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="transaction-tab2" data-bs-toggle="pill"
                                            data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2"
                                            aria-selected="false">Deposit History</button>
                                    </li>
                                </ul>
                            </div>


                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                    aria-labelledby="transaction-tab1">

                                    <div class="col-md-12 col-lg-12 mt-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-12 col-lg-8">
                                                <div class="depositcont">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="choosecurre">
                                                            <label for="exampleInputcurrency">Select Currency<span
                                                                    class="reqfi mx-1">*</span></label>
                                                        </div>
                                                        <div class="balance">
                                                            <h6><span>Balance:</span><b id="bal"> 0.00000000</b>
                                                            </h6>
                                                        </div>
                                                    </div>

                                                    <form>


                                                        <select class="form-select mt-2 curr"
                                                            aria-label="Default select example" id="currency_deposit"
                                                            name="currency_deposit">
                                                            <option value="0" selected>Select Currency</option>
                                                            @foreach ($currencyList as $key => $value)
                                                                { @endphp
                                                                <option value="<?php echo $value->symbol; ?>"><?php echo $value->symbol . ' -' . $value->name; ?>
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <label class="depositeloder" style="display: none;float:right">Loding ...</label>

                                                        <div class="form-group mt-3 qrCodess" style="display:none">
                                                            <label for="exampleInputPassword1" class="mb-2">Wallet
                                                                Address<span class="reqfi mx-1">*</span></label>
                                                            <p style="float:right;" id="copy"
                                                                onclick="copy_text_fun()"><i
                                                                    class="fas fa-copy copy_notifys"></i></p>
                                                            <input type="text" class="form-control" name="address"
                                                                id="address" placeholder="Address Not Available"
                                                                readonly autocomplete="off">
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                            <div class="col-md-12 col-lg-4">
                                                <div class="qrimgg qrCodess" style="display:none">
                                                    <img src="{{ URL::to('/') }}/public/assets/user/img/logo/qrimg.png"
                                                        class="img-fluid qr-codes">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="disclim mt-4 ">
                                            <h6 class="mb-2">Disclaimer</h6>

                                            <p class="mb-1">1. Send only using the <b class="currency_network"></b>.
                                                Using any other network will result in loss of funds</p>
                                            <p>2. Deposit only <b class="currency_network"></b>. to this deposit
                                                address. Depositing any other asset will result in a loss of funds.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel"
                                    aria-labelledby="transaction-tab2">

                                    <div class="depositcont show-datas table-responsive">
                                        <div class="dashboard-table-wrapper" class="table-responsive">

                                            <div class="dashboard-table table-responsive">
                                                <table id="depositlist" class="table-responsive">
                                                    <thead>

                                                        <tr>
                                                            <th scope="col">S.No</th>
                                                            <th scope="col">Address</th>
                                                            <th scope="col">Amount</th>
                                                            <th scope="col">Currency</th>
                                                            <th scope="col">Transaction ID</th>
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
    </div>

</main>


@include('user.common.footer')

<script type="text/javascript">
    $(document).on('click', '#copy', function() {
        document.getElementById("address").select();
        document.execCommand("copy");
        toastr.success('Address has been copied !', 'Success', {
            timeOut: 2000
        });
    })
</script>



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

<script>
    $(document).ready(function() {

        // Datapicker
        $(".datepicker").datepicker({
            "dateFormat": "yy-mm-dd",
            changeYear: true
        });

        // DataTable
        var dataTable = $('#depositlist').DataTable({
            language: {
                search: "",
                searchPlaceholder: "Currency,Address"
            },
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'searching': true,
            'ajax': {
                'url': base_urls + "/usergetdeposithistory",
                'data': function(data) {
                    // Read values
                    var from_date = $('#search_fromdate').val();
                    var to_date = $('#search_todate').val();

                    // Append to data
                    data.searchByFromdate = from_date;
                    data.searchByTodate = to_date;
                }
            },
            'columns': [{
                    data: 'id'
                },
                {
                    data: 'currency'
                },
                {
                    data: 'txid'
                },
                {
                    data: 'address'
                },
                {
                    data: 'amount'
                },
                {
                    data: 'status'
                },
                {
                    data: 'date'
                },
            ]
        });

        $('#depositlist_filter input').attr('data-toggle', 'tooltip');
   $('#depositlist_filter input').attr('title', 'Currency,Address');
   $('#depositlist_filter input').tooltip({
      placement: 'top', // Adjust the placement as needed
      trigger: 'hover'
   });

        // Search button
        $('#btn_search').click(function() {
            dataTable.draw();
        });

    });
</script>
