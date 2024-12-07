@include('admin.common.header')
@include('admin.common.sidebar')
 <div class="page-wrapper" style="min-height: 547px;">
    <div class="container-fluid">
      <!-- Title -->
      <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h5 class="txt-dark">Security Setting</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            <li>
              <a href="dashboard">Dashboard</a>
            </li>
            <li class="active">
              <span>Security Setting</span>
            </li>
          </ol>
        </div>
        <!-- /Breadcrumb -->
      </div>
      <!-- /Title -->
      <!-- Row -->
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default card-view">

            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">{{$title}}</h6>
                </div>
                <div class="clearfix"></div>
            </div>



            <div class="panel-heading">
              <div class="pull-left">
                <h6 class="panel-title txt-dark"></h6>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-wrap">

                        <form method="POST" id="admin-change-pass" class="admin-change-pass form-horizontal" id="admin-change-pass" name="admin-change-pass">
                            @csrf
                        <div class="form-body">
                          <h6 class="txt-dark capitalize-font">
                            <i class="zmdi zmdi-account mr-10"></i>Change Password</h6>
                          <hr class="light-grey-hr">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label col-md-3">Current Password</label>
                                <div class="col-md-9">
                                  <input type="text" class="form-control" placeholder="Current Password" id="current_password" name="current_password"  >
                                </div>
                              </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6"></div>
                            <!--/span-->
                          </div>
                          <!-- /Row -->
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label col-md-3">New Password</label>
                                <div class="col-md-9">
                                  <input type="text" class="form-control" placeholder="New Password"  id="password" name="password" >
                                </div>
                              </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6"></div>
                            <!--/span-->
                          </div>
                          <!-- /Row -->
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label col-md-3">Conform Password</label>
                                <div class="col-md-9">
                                  <input type="text" class="form-control" placeholder="Conform Password" id="c_password" name="c_password">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-actions mt-10">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="button"
                                            class="btn btn-success mr-10 mb-30 loader"
                                            id="loader" class="loader"
                                            style="display: none;">Loading...</button>

                                        <button type="submit" id="change_pass"
                                            class="btn btn-success change_pass mr-10">Change
                                            Password</button>

                                    </div>
                                </div>
                              </div>
                              <div class="col-md-6"></div>
                            </div>
                          </div>
                      </form>




                      <div class="seprator-block"></div>
                      <h6 class="txt-dark capitalize-font">
                        <i class="zmdi zmdi-account-box mr-10 "></i>Change Pattern
                      </h6>
                      <hr class="light-grey-hr">
                      <!-- /Row -->
                      <form class="form-horizontal admin_pattern" method="POST" id="admin_pattern" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="col-md-4 col-lg-4 text-center">
                              <div class="form-group">
                                <div id="pattern1_container" class="pattern_container">
                                  <label class="media-right">Current Pattern</label>
                                  <div id="pattern1" class="patternss"></div>
                                </div>
                                <input type="hidden" id="current_pattern_val" name="current_pattern_val">
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-4 text-center">
                              <div class="form-group">
                                <div id="pattern2_container" class="pattern_container">
                                  <label class="media-right">New Pattern</label>
                                  <div id="pattern2" class="patternss"></div>
                                </div>
                                <input type="hidden" class="new_pattern" id="new_pattern" name="new_pattern">
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-4 text-center">
                              <div class="form-group">
                                <div id="pattern3_container" class="pattern_container">
                                  <label class="media-right">Confirm New Pattern</label>
                                  <div id="pattern3" class="patternss"></div>
                                </div>
                                <input type="hidden" value="" id="confirm_pattern" name="confirm_pattern">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-actions mt-10">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="row">
                                <div class="col-md-offset-9 col-md-9">
                                  <button type="button" class="btn btn-success loaders" id="loaders"  style="display: none;">Loading...</button>
                                  <button type="submit" class="btn btn-success  change_pattern" style="position:relative; right:-85px;float:right" ; id="change_pattern">Update Pattern</button>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6"></div>
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
      <!-- /Row -->
    </div>

    @include('admin.common.footer')









    <script>

      document.addEventListener("DOMContentLoaded", function() {
        display_pattern();
      });

      function display_pattern() {
        var lock = new PatternLock('#pattern2', {
          onDraw: function(pattern) {
            document.getElementById("new_pattern").value = lock.getPattern();
          }
        });
      }
      var lock = new PatternLock('#pattern1', {
        onDraw: function(pattern) {
          console.log('old patter--->', pattern);
          document.getElementById("current_pattern_val").value = pattern;
        }
      });
      var lock = new PatternLock('#pattern2', {
        onDraw: function(pattern) {
          document.getElementById("new_pattern").value = pattern;
        }
      });
      var lock = new PatternLock('#pattern3', {
        onDraw: function(pattern) {
          var new_patter = $('.new_pattern').val();
          console.log('new_patter-->',new_patter,'---->pattern--->',pattern);
          if (new_patter != pattern) {
            var lock1 = new PatternLock('#pattern2');
            lock.reset();
            lock1.reset();

            alert('new patter and confirm patter does not match!!')

            document.getElementById("confirm_pattern").value = "";
            document.getElementById("new_pattern").value = "";
          } else {
            document.getElementById("confirm_pattern").value = lock.getPattern();
          }
        }
      });
    </script>
    <script type="text/javascript">
      $(document).on('change', '.upload', function() {
        var numb = $(this)[0].files[0].size / 1024 / 1024;
        numb = numb.toFixed(2);
        if (numb > 1) {
          alert('File size must be less than 1 MB. You file size is: ' + numb + ' MiB');
          $('.upload').val('');
          return false;
        }
      });
      $(document).on('change', '.upload', function() {
        $('.pic')[0].src = (window.URL ? URL : webkitURL).createObjectURL(this.files[0]);
      })
    </script>
