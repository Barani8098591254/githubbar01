
@include('admin.common.header')
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
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="table-wrap">
										<div class="table-responsive">
											<table id="datable_1" class="table table-hover display  pb-30" >
												<thead>
													<tr>
														<th>S.No</th>
														<th>Name</th>
														<th>Subject</th>
														<th>Status</th>
														<th>Date Time</th>

                                                        <th>Action</th>






													</tr>
												</thead>

												<tbody>
													<tr>
														<td>1</td>
														<td>Home</td>
														<td>Heading Title</td>
                                                        <td><span class="label label-danger">pending</span></td>
                                                        <td>27/12/2023</td>
                                                        <td>
                                                            <a href="emailEdit" class=""><i title="Edit email" class="fa fa-edit"></i></a>
                                                        </td>

													</tr>



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

