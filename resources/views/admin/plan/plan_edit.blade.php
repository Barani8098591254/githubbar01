@include('admin.common.header')

@include('admin.common.sidebar')


<!-- Main Content -->
<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h5 class="txt-dark">Plan </h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                <li><a href="dashboard">Dashboard</a></li>
                <li><a href="{{adminBaseurl()}}planList">plan List</a></li>
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
                                        <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/editPlan" class="form-horizontal" name="editPlan" id="editPlan" method="post" >
                                            @csrf
                                            <div class="form-body">
                                                <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account-box mr-10"></i>{{$title}}</h6>
                                                <hr class="light-grey-hr">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="hidden" name="id" id="id" value="{{$id}}">
                                                            <label class="control-label col-md-3">Plan Name</label>
                                                            <div class="col-md-9">
                                                                <input type="text" id="tradeName" name="tradeName" class="form-control" value="{{$plan->name}}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                            <div class="form-group">
                                                              <label class="control-label col-md-3">
                                                                 Select Currency
                                                                  </label>
                                                              <div class="col-md-9">
                                                                <select class="form-control valid" name="currency_id" id="currency_id" data-placeholder="Choose a Category" tabindex="1" aria-invalid="false">
                                                                    <option value="0">Choose Currency</option>
                                                                    @foreach($currency as $currencyOption)
                                                                        <option value="{{ $currencyOption->id }}" @if($currencyOption->id == $plan->currency_id) selected @endif>
                                                                            {{ $currencyOption->symbol }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                              </div>
                                                      </div>
                                                    </div>


                                                </div>


                                                <div class="row">


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Plan Pice (USD)</label>
                                                            <div class="col-md-9">
                                                                <input type="number" class="form-control" name="price" id="price" value="{{$plan->price}}" placeholder="Plan Pice">
                                                        </div>
                                                        </div>
                                                    </div>



                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">
                                                                Direct Commission (%)
                                                                </label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="direct_commission" id="direct_commission" value="{{$plan->direct_commission}}" Direct Commission (%)
placeholder="Direct Commission (%)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>



                                                <div class="row">


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">
                                                                ROI ( % )
                                                                </label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="roi_commission" id="roi_commission" value="{{$plan->roi_commission}}" placeholder="roi_commission">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">
                                                               Status
                                                                </label>
                                                            <div class="col-md-9">
                                                                <select class="form-control valid" name="status" id="status" data-placeholder="Choose a Category" tabindex="1" aria-invalid="false" name="status" id="status">
                                                                    <option value="1" name="status" id="status" <?php echo ($plan->status == 1) ? 'selected' : '' ?> >Active
                                                                    </option>
                                                                    <option value="0" name="status" id="status" <?php echo ($plan->status == 0) ? 'selected' : '' ?> >Inactive
                                                                    </option>
                                                                </select>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">
                                                                Number of Plan Days
                                                                </label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="days" id="days" value="{{$plan->days}}" placeholder="days">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">
                                                                Pair Commission
                                                                </label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="pair_commission" id="pair_commission" value="{{$plan->pair_commission}}" placeholder="days">
                                                            </div>
                                                        </div>
                                                    </div>




                                                </div>

<br>
<br>
                                                <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account-box mr-10"></i>
                                                    Level Commission ( % )</h6>

                                                <hr class="light-grey-hr">

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

                                                <div class="row">
                                                    <div id="parantContainer">

                                                    <?php
                                                    $commissionDataCount = count($commissionData);

                                                    for ($i = 0; $i < $commissionDataCount; $i++) {
                                                        $level = $i + 1;
                                                        $commission = isset($commissionData[$i]['commission']) ? $commissionData[$i]['commission'] : '';
                                                    ?>
                                                    <div class="col-md-6 levelone">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Level {{$level}}</label>
                                                            <div class="col-md-9 leveltwo">
                                                                <input type="text" class="form-control" name="commission[]" id="commission[]" value="{{$commission}}" placeholder="commission" step="any">
                                                            </div>
                                                        </div>
                                                </div>
                                                    <?php } ?>
                                                </div>

                                                <div id="levelsContainer">

                                                </div>
                                                </div>


                                            <div class="form-actions mt-10">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="" class="btn btn-success mr-10" id="btn-submit">Submit <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i></button>

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

   <input type="hidden" id="levelCount" value="{{ count($commissionData)+1}}">


@include('admin.common.footer')


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var levelCounter = <?php echo $commissionDataCount; ?>;

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
            newLevel.className = "col-md-6 level";
            newLevel.innerHTML = `
                <div class="form-group">
                    <label class="control-label col-md-3">Level ${levelCounter + 1}</label>
                    <div class="col-md-9">
                        <input type="number" class="form-control" name="commission[]" step="any" required="true">
                    </div>
                </div>
            `;
            levelsContainer.appendChild(newLevel);

            levelCounter += 1;
        }

        function removeLevel(level) {
            var levelsContainer = document.getElementById("levelsContainer");
            level.parentNode.removeChild(level);
            levelCounter -= 1;
        }

        function removeLastLevel() {

            var levelsContainer = document.getElementById("levelsContainer");
            var lastLevel = levelsContainer.lastElementChild;
            console.log('lastLevel---->',lastLevel);
            if(lastLevel == null){
                var levelsContainer = document.getElementById("parantContainer");
                 var lastLevel = levelsContainer.lastElementChild;
                 if (lastLevel && lastLevel.classList.contains("levelone")) {
                    var counter = levelCounter;
                    if(counter == 1){
                        return;
                    }
                    levelsContainer.removeChild(lastLevel);



                    levelCounter -= 1;
                }
            }else{
                if (lastLevel && lastLevel.classList.contains("level")) {
                    var counter = levelCounter;
                    if(counter == 1){
                        return;
                    }
                    levelsContainer.removeChild(lastLevel);
                    levelCounter -= 1;
                }
            }







        }
    });
</script>
