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
        <h5 class="txt-dark">User List</h5>
      </div>
      <!-- Breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
          <li>
            <a href="dashboard">Dashboard</a>
          </li>
          <li class="active">
            <span>User List</span>
          </li>
        </ol>
      </div>
      <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->
    <!-- Row -->
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default card-view">

            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">{{$title}}</h6>
                </div>
                <div class="clearfix"></div>
            </div>



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

                &nbsp;


                    <a href="usersList"><button type="button" class="btn btn-danger mt-20 mb-20">
                        <i class="fa fa-refresh "></i>  <span class="btn-text">Reset</span>
                  </button></a>
                </div>
                </div>
                </div>
            </form>


          <div class="panel-wrapper collapse in">
            <div class="panel-body">
              <div class="table-wrap">
                <div class="">
                  <table id="userlist" class="table table-hover display  pb-30">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>User name</th>
                        <th>Email Address</th>
                        <th>Mobile No</th>
                        <th>Email verification</th>
                        <th>Status</th>
                        <th>TFA Status</th>
                        <th>Withdraw Status</th>
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


    @include('admin.common.footer')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        function confirmUserStatusChange(action,msg) {
            let actionText =  msg;
            let confirmMessage = `Are you sure you want to ${actionText} this user account?`;

            Swal.fire({
                title: `Confirm ${actionText}`,
                text: confirmMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {


                if (result.isConfirmed) {
                    location.href = action;
                } else {
                    return false;
                }
            });
        }
    </script>



<script>
    function confirmtfaChange(action,msg) {
        let actionText =  msg;
        let confirmMessage = `Are you sure you want to ${actionText} this TFA status?`;

        Swal.fire({
            title: `Confirm ${actionText}`,
            text: confirmMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {


            if (result.isConfirmed) {
                location.href = action;
            } else {
                return false;
            }
        });
    }
</script>


<script>
    function confirmtwithdrawChange(action,msg) {
        let actionText =  msg;
        let confirmMessage = `Are you sure you want to ${actionText} this Withdraw status?`;

        Swal.fire({
            title: `Confirm ${actionText}`,
            text: confirmMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {


            if (result.isConfirmed) {
                location.href = action;
            } else {
                return false;
            }
        });
    }
</script>





    <!-- Datatable JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>



<!-- Datatable JS -->

<script>

    $(document).ready(function(){

       // Datapicker
       $( ".datepicker" ).datepicker({
          "dateFormat": "yy-mm-dd",
          changeYear: true
       });

       // DataTable
         var dataTable = $('#userlist').DataTable({
          language: { search: "", searchPlaceholder: "User Name, Email ID, Mobile Number"},
         'processing': true,
         'serverSide': true,
         'serverMethod': 'post',
         'searching': true, // Set false to Remove default Search Control
         'ajax': {
           'url': base_url+"/getuserslist",
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
            { data: 'id', class: 'text-center' },
            { data: 'username', class: 'text-center' },
            { data: 'email', class: 'text-center' },
            { data: 'mobile_no', class: 'text-center' },
            { data: 'is_verify', class: 'text-center' },
            { data: 'is_active', class: 'text-center' },
            { data: 'tfaStatus', class: 'text-center' },
            { data: 'withdraw_status', class: 'text-center' },
            { data: 'date', class: 'text-center' },
            { data: 'action' , class:'actionclass'},


         ]
      });



                                 // Add tooltip to the DataTable search input field
                                 $('#userlist_filter input').attr('data-toggle', 'tooltip');
   $('#userlist_filter input').attr('title', 'Username, Email, Mobile number');
   $('#userlist_filter input').tooltip({
      placement: 'top', // Adjust the placement as needed
      trigger: 'hover'
   });


      // Search button
      $('#btn_search').click(function(){
         dataTable.draw();
      });

    });


    </script>