
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
						<li><a href="dashboard">Dashboard</a></li>
						<li class="active"><span>{{$title}}</span></li>
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
                                <i class="icon-rocket"></i>  <span class="btn-text">  Filter</span>
                                </button>

                                &nbsp;
                                    <a href="activeuser"><button type="button" class="btn btn-danger mt-20 mb-20">
                                        <i class="fa fa-refresh "></i>  <span class="btn-text">  Reset</span>
                                  </button></a>

                                </div>




                                </div>
                                </div>
                            </form>

							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="table-wrap">
										<div class="">
											<table id="activekyclist" class="table table-hover display  pb-30" >
												<thead>
													<tr>
														<th>S.No</th>
														<th>User name</th>
														<th>Email Address</th>
														<th>Kyc Status </th>
                                                        <th>Date Time</th>
                                                        <th>Action</th>
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




@include('admin.common.footer')

<!-- Datatable JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>






<script>

    $(document).ready(function(){

       // Datapicker
       $( ".datepicker" ).datepicker({
          "dateFormat": "yy-mm-dd",
          changeYear: true
       });

       // DataTable
         var dataTable = $('#activekyclist').DataTable({
            language: { search: "", searchPlaceholder: "User Name, Email"},
         'processing': true,
         'serverSide': true,

         'serverMethod': 'post',
         'searching': true, // Set false to Remove default Search Control
         'ajax': {
           'url': base_url+"/getactivekyc",
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
            { data: 'kyc_status', class: 'text-center' },
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

