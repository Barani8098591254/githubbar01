
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

                        <div class="col-lg-12 col-md-12">
                            <div class="dashboard-content">
                                <div class="dashboard-content-head">
                                    <div class="unique">
                                            <h4>{{$title}}</h4>
                                        </div>
                                </div>


                                 <div class="dashboard-content">
                                    <div class="dashboard-widget-wrapper">
                                    <div class="row">
                                      <div class="col-md-12 col-lg-12">
                                        <div class="dashboard-widgett">

                                            <div class="depositcont">
                                                <div class="dashboard-table table-responsive">
                                                 <table id="roicommission" class="" style="width:100%">
                                                     <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Currency</th>
                                                        {{-- <th>Amount</th>
                                                        <th>Equivalent USD</th> --}}
                                                        <th>Amount</th>

                                                        <th>Description</th>
                                                        <th>Wallet Status</th>
                                                        <th>Date and Time</th>

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

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</main>



@include('user.common.footer')

<!-- Datatable JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>






<script>

    $(document).ready(function(){



       // Datapicker
       $( ".datepicker" ).datepicker({
          "dateFormat": "yy-mm-dd",
          changeYear: true
       });


       // DataTable
         var dataTable = $('#roicommission').DataTable({


            language: { search: "", searchPlaceholder: "Currency, Description, Amount"},

         'processing': true,
         'serverSide': true,
         'serverMethod': 'post',
         'searching': true, // Set false to Remove default Search Control
         'ajax': {
           'url': base_url+"getroicommisson",
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
            { data: 'currency', class: 'text-center' },
            // { data: 'amount', class: 'text-center' },
            // { data: 'equamt', class: 'text-center' },
                        { data: 'equamt', class: 'text-center' },
            { data: 'description', class: 'text-center' },
            { data: 'wallet_status', class: 'text-center' },
            { data: 'date', class: 'text-center' },
         ]
      });

      $('#roicommission_filter input').attr('data-toggle', 'tooltip');
   $('#roicommission_filter input').attr('title', 'Currency, Description, Amount');
   $('#roicommission_filter input').tooltip({
      placement: 'top', // Adjust the placement as needed
      trigger: 'hover'
   });

      // Search button
      $('#btn_search').click(function(){
         dataTable.draw();
      });

    });


    </script>