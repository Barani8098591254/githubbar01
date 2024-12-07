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
                        <div class="dashboard-content-head">

                            <div class="unique">
                                    <h4>{{$title}}</h4>

                                </div>
                        </div>
                        <div class="dashboard-referral mt-5">
                            <div class="dashboard-card">
                                <!-- <h3>Your Referral Link</h3> -->
                                <div class="dashboard-referral-link">

                                <div class="invest-plan-wrapper">
                                    <div class="row">
                                        <div class="col-lg-6 mx-auto">
                                        </div>
                                    </div>

                                    <div class="row">


                                        <div class="card-body table-responsive">

                                            <div id="chart_div" class="genealogy"></div>

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


<script src="{{ URL::to('/') }}/public/assets/user/js/genealogy.js"></script>


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
