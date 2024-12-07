
@include('user.common.header')

<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

<style>
    .dashboard-widgett {
    align-items: center;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 25px;
    /* background: linear-gradient(to right, #301EA2 0%, #442BCB 100%); */
    background: #ecf1fa;
}

thead.dataajaxtable {
    color: #fff;
    background: linear-gradient(to right, #de5c70 0%, #e98c5d 51%, #de5c70 100%);
    font-weight: 600;
    font-size: 16px;
}


table.dataTable.no-footer {
    /* border-bottom: 0px solid #111!important; */
    border-bottom: azure!important;
}

table.dataTable thead .sorting {
    /* background-image: url(../images/sort_both.png); */
    background: linear-gradient(to right, #de5c70 0%, #e98c5d 51%, #de5c70 100%)!important;
}

</style>
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



                                            <table id="investmenttable" class="table pt-5 table-responsive" style="width:100%">
                                                <thead class="dataajaxtable">
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>User Name</th>
                                                        <th>Investment Amount</th>
                                                        <th>Currency</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
                                                        <th>Matured date</th>

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
         var dataTable = $('#investmenttable').DataTable({

            language: { search: "", searchPlaceholder: "Username,Currency, Type"},

         'processing': true,
         'serverSide': true,
         'serverMethod': 'post',
         'searching': true, // Set false to Remove default Search Control
         'ajax': {
           'url': base_url+"getuserinvestment",
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
            { data: 'plan_amount', class: 'text-center' },
            { data: 'currency', class: 'text-center' },
            { data: 'status', class: 'text-center' },
            { data: 'date', class: 'text-center' },
            { data: 'matured_date', class: 'text-center' },
         ]
      });

      // Search button
      $('#btn_search').click(function(){
         dataTable.draw();
      });

    });


    </script>
