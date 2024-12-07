@include('admin.common.header')

<style>
    div#chart_div {
    display: flex;
    justify-content: center;
}
</style>

@include('admin.common.sidebar')




<!-- Main Content -->
<div class="page-wrapper">
  <div class="container-fluid">
    <!-- Title -->
    <div class="row heading-bg">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h5 class="txt-dark">User Activity</h5>
      </div>
      <!-- Breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
          <li>
            <a href="dashboard">Dashboard</a>
          </li>
          <li><a href="{{ URL::to('/') .'/'. env('ADMIN_URL') . '/usersList/' }}">User List</a></li>
          <li class="active"><span>User Genealogy</span></li>
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


            <div class="card-body table-responsive">

                <div id="chart_div"></div>

              </div>



        </div>
      </div>
    </div>





    @include('admin.common.footer')

    <script src="{{ URL::to('/') }}/public/assets/admin/Js/genealogy.js"></script>

<script type="text/javascript">
    google.charts.load('current', { packages: ["orgchart"] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');
        data.addRows([<?php echo $treeData; ?>]);
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        chart.draw(data, { 'allowHtml': true });
    }
</script>


