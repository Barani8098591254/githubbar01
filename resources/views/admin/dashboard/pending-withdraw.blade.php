@include('admin.common.header')
<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
 @include('admin.common.sidebar')
<!-- Main Content -->
<div class="page-wrapper">
  <div class="container-fluid">
    <!-- Title -->
    <div class="row heading-bg">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h5 class="txt-dark">{{$title}}</h5>
      </div>
      <!-- Breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
          <li>
            <a href="{{ URL::to('/') .'/'. env('ADMIN_URL') . '/dashboard/' }}">Dashboard</a>
          </li>
          <li class="active">
            <span>{{$title}}</span>
          </li>
        </ol>
      </div>
      <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->
    <!-- Row -->
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default ard-view">

            <div class="pa-20">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">{{$title}}</h6>
                </div>
                <div class="clearfix"></div>
            </div>

          <div class="panel-wrapper collapse in">

            <div class="panel-body">
                <form id="filter-form" method="GET" action="">
                    @csrf
                    <div class="col-sm-10 date_customcol">
                    <div class="row date">
                    <div class="col-sm-3">
                    <label for="start-date">Start Date:</label>
                    <input type="text" id='search_fromdate' name="search_fromdate" class="form-control datepicker" data-toggle="tooltip" data-placement="top" value="{{@$fromDate}}" title="Start Date" placeholder="From Date" autocomplete="off">
                    </div>
                    <div class="col-sm-3">
                    <label for="end-date">End Date:</label>
                    <input type="text" id="search_todate" name="search_todate" class="form-control datepicker" data-toggle="tooltip" data-placement="top" value="{{@$toDate}}" title="End Date" placeholder="To Date" autocomplete="off">
                    </div>
                        <div class="col-sm-6">
                    <button type="button" id="btn_search" value="Search" class="btn btn-success mt-20 mb-20">
                    <i class="icon-rocket"></i>  <span class="btn-text">Filter</span>
                    </button>

                        <a href="withdrawHistory"><button type="button" class="btn btn-danger mt-20 mb-20">
                            <i class="fa fa-refresh "></i>  <span class="btn-text">Reset</span>
                      </button></a>

                    </div>

                    </div>
                    </div>
                </form>

              <div class="table-wrap">
                <div class="">
                  <table id="withdraw" class="table table-hover display  pb-30">
                    <thead>
                      <tr>
                        <th>S.no</th>
                        <th>Username</th>
                        <th>Currency</th>
                        <th>Address</th>
                        <th>Amount</th>
                        <th>TXID</th>
                        <th>Fee</th>
                        <th>Recive Amount</th>
                        <th>Status</th>
                        <th>Date Time</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Approved Withdraw -->
    <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 class="modal-title">Approved Withdraw</h5>
          </div>
          <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/approved-withdraw" method="post" id="approvedform" name="approvedform" class="approved-form">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="form-group">
                <label for="recipient-name" class="control-label mb-10">Transaction ID:</label>
                <input type="text" class="form-control" id="txId" name="txId" placeholder="Enter Withdraw Transaction ID">
              </div>
              <input type="hidden" name="withdrawId" id="withdrawId" class="withdrawId">
              <input type="hidden" name="userId" id="userId" class="userId">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              {{-- <button type="submit" id="btn-submit" name="btn-submit" class="btn btn-success">Approved</button> --}}
              <button type="submit" id="btn btn-submit" name="btn btn-submit" class="btn btn-success">Approved <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i>
              </button>
              <button type="button" class="button content__space loader" name="loader" id="loader" disabled="" style="display:none"></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Approved Withdraw -->


    <!-- Rejected Withdraw -->
    <div id="responsive1-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 class="modal-title">Rejected Withdraw</h5>
          </div>
          <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/rejected-withdraw" class="rejected-form" name="reject" id="reject" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="form-group">
                <label for="recipient-name" class="control-label mb-10">Rejected Reason:</label>
                <textarea class="form-control" id="reason" name="reason"></textarea>
              </div>
              <input type="hidden" name="withdrawId" id="withdrawId" class="withdrawId">
              <input type="hidden" name="userId" id="userId" class="userId">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" id="btn rejected-submit" name="btn-rejected-submit" class="btn btn-danger">Rejected <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i>
              </button>
              <button type="button" class="button content__space loader" name="loader" id="loader" disabled="" style="display:none"></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Rejected Withdraw -->



    {{-- REJECT REASON VIEW--}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title" id="exampleModalLabel1">Reject Reson</h5>
          </div>
          <div class="modal-body">
            <form action="" name="reason" id="reason" method="post">
                @csrf
                 <div class="form-group">
                <label for="recipient-name" class="control-label mb-10">Withdraw Reject Reason</label>
                <textarea class="form-control reason" id="reason" name="reason">Bad</textarea>
                <input type="hidden" name="withdrawId" id="withdrawId" class="withdrawId">

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    {{-- REJECT REASON VIEW --}}



    @include('admin.common.footer')


    <script>
        $(document).ready(function() {
            $(document).on("click", ".approved", function() {
                var user_id = $(this).attr("data-userid");
                $('.userId').val(user_id);
            });
        });

        $(document).ready(function() {
            $(document).on("click", ".rejected", function() {
                var user_id = $(this).attr("data-userid");
                $('.userId').val(user_id);
            });
        });

    </script>




    <script type="text/javascript">
      $(document).on("click", ".approved", function() {
        var id = $(this).attr("data-id");
        $('.withdrawId').val(id);
      });
      $(document).on("click", ".rejected", function() {
        var id = $(this).attr("data-id");
        $('.withdrawId').val(id);
      });

      $(document).on("click", ".reason", function() {
        var id = $(this).attr("data-id");
        $('.withdrawId').val(id);
      });

    </script>

<!-- Datatable JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>



<script type="text/javascript">
    $(document).ready(function() {
        // Your other JavaScript code here
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
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Your other JavaScript code here
    });

    function refresh() {
        location.reload();
    }

    $(document).on('click', '.curpoint.copyaddress', function() {
        var value = $(this).attr('data-id');
        var textArea = document.createElement("textarea");
        textArea.value = value;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        toastr.success('Copied!', 'Success', {
            timeOut: 2000
        });
    });
</script>


<script>

$(document).ready(function(){

   // Datapicker
   $( ".datepicker" ).datepicker({
      "dateFormat": "yy-mm-dd",
      changeYear: true
   });

   // DataTable
     var dataTable = $('#withdraw').DataTable({
    language: { search: "", searchPlaceholder: "User Name, Currency, Address"},
     'processing': true,
     'serverSide': true,
     'serverMethod': 'post',
     'searching': true, // Set false to Remove default Search Control

     'ajax': {
       'url': base_url+"/getwithdrawpending",
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
        { data: 'id',className: 'text-center' },
        { data: 'name', class: 'text-center' },
        { data: 'currency', class: 'text-center' },
        { data: 'address', class: 'text-center' },
        { data: 'txId', class: 'text-center' },
        { data: 'amount', class: 'text-center' },
        { data: 'fee', class: 'text-center' },
        { data: 'recive_amount', class: 'text-center' },
        { data: 'status', class: 'text-center' },
        { data: 'date', class: 'text-center' },
        { data: 'action', class: 'text-center' },

     ]
  });

  // Search button
  $('#btn_search').click(function(){
     dataTable.draw();
  });

});


</script>






