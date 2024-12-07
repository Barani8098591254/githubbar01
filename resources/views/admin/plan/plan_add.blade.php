@include('admin.common.header')

@include('admin.common.sidebar')


<!-- Main Content -->
<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h5 class="txt-dark">Create Plan</h5>
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
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-wrap">
                                        <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/Planstore" class="form-horizontal" name="createplan" id="createplan" method="post" >
                                            @csrf
                                            <div class="form-body">
                                                <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account-box mr-10"></i>{{$title}}</h6>
                                                <hr class="light-grey-hr">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                          <div class="form-group">
                                                            <label class="control-label col-md-3">
                                                               Select Currency
                                                                </label>
                                                            <div class="col-md-9">
                                                                <select class="form-control valid" name="currencyId" id="currencyId" data-placeholder="Choose a Category" tabindex="1" aria-invalid="false">
                                                                    <option value="" >Choose Curency</option>
                                                                    @foreach($currency as $key => $value)
                                                                        <option value="{{$value->id}}">{{$value->symbol}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Plan Name</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="name" id="name" value="" placeholder="Enter The Plan Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">
                                                                Direct Commission (%)
                                                                </label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="direct_commission" id="direct_commission" placeholder="Enter The Direct Commission (%)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">
                                                                ROI ( % )
                                                                </label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="roi_commission" id="roi_commission" placeholder="Enter The ROI (%)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                           <div class="form-group">
                                                            <label class="control-label col-md-3">Plan Price</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="price" id="price" placeholder="Enter The Plan Price">
                                                        </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">
                                                                <div class="form-group">
                                                            <label class="control-label col-md-3">
                                                               Status
                                                                </label>
                                                            <div class="col-md-9">
                                                                <select class="form-control valid" name="status" id="status" data-placeholder="Choose a Category" tabindex="1" aria-invalid="false">
                                                                    <option value="1" >Active
                                                                    </option>
                                                                    <option value="0">Inactive
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">

                                                    <div class="col-md-6">
                                                           <div class="form-group">
                                                            <label class="control-label col-md-3">Plan Days</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="days" id="days" placeholder="Enter The Plan days">
                                                        </div>
                                                        </div>

                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                         <label class="control-label col-md-3">Pair Commission</label>
                                                         <div class="col-md-9">
                                                             <input type="text" class="form-control" name="pair_commission" id="pair_commission" placeholder="Enter The Pair Commission">
                                                     </div>
                                                     </div>

                                                 </div>



                                                </div>



                                                <div class="row">
                                                    <div class="mb-20 pl-15" style="float: right;">
                                                        <button id="addLevelButton" title="Level Commission" class="btn btn-primary">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>
                                                        <button id="removeLevelButton" title="Remove Level Commission" class="btn btn-danger">
                                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>



                                                <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account-box mr-10"></i>
                                                    Level Commission ( % )</h6>


                                                <hr class="light-grey-hr">
                                                <div id="levelsContainer">
                                                    <div class="row">
                                                        <?php
                                                        for ($i = 1; $i <= 2; $i++) {
                                                        ?>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3 col-sm-12">Level <?php echo $i; ?></label>
                                                                <div class="col-md-9 col-sm-12">
                                                                    <input type="number" class="form-control" name="commission[]" id="commission[]">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions mt-10">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="" class="btn btn-success mr-10" id="btn-submit">Submit</i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"> </div>
                                                </div>
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




@include('admin.common.footer')



<script>
     document.addEventListener("DOMContentLoaded", function() {
        var levelCounter = 3;

        document.getElementById("addLevelButton").addEventListener("click", function(e) {
            e.preventDefault();
            addLevel();
        });

        document.getElementById("removeLevelButton").addEventListener("click", function(e) {
            e.preventDefault();
            removeLastLevel();
        });

        document.getElementById("levelsContainer").addEventListener("click", function(e) {
            if (e.target.classList.contains("level")) {
                removeLevel(e.target);
            }
        });

        function addLevel() {
            var levelsContainer = document.getElementById("levelsContainer");
            var newLevel = document.createElement("div");
            newLevel.className = "col-md-6 col-sm-12 level";
            newLevel.innerHTML = `
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-12">Level ${levelCounter}</label>
                    <div class="col-md-9 col-sm-12">
                        <input type="number" class="form-control" name="commission[]" id="commission[]">
                    </div>
                </div>
            `;
            levelsContainer.appendChild(newLevel);

            levelCounter += 1;
        }

        function removeLevel(level) {
            var levelsContainer = document.getElementById("levelsContainer");
            levelsContainer.removeChild(level);
        }

        function removeLastLevel() {
            var levelsContainer = document.getElementById("levelsContainer");
            var lastLevel = levelsContainer.lastChild;
            if (lastLevel) {
                levelsContainer.removeChild(lastLevel);
                levelCounter -= 1;
            }
        }
    });
</script>






