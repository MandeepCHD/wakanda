<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $trade = app('App\Http\Controllers\BuySellController'); ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				<h3 class="title1"><?php echo e($settings->site_name); ?> users list</h3>
				
				<?php if(Session::has('message')): ?>
		        <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i> <?php echo e(Session::get('message')); ?>

                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(count($errors) > 0): ?>
		        <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <i class="fa fa-warning"></i> <?php echo e($error); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
				<span style="margin:3px;">
				        <?php echo e($users->render()); ?>

				    </span>
				    
				    <form style="padding:3px; float:right;" role="form" method="post" action="<?php echo e(action('Controller@search')); ?>">
				            <a class="btn btn-default" href="<?php echo e(url('dashboard/manageusers')); ?>">Show all</a>
					   		<input style="padding:5px; margin-top:15px;" placeholder="Search user" type="text" name="searchItem" required>
					   		<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					   		<input type="hidden" name="type" value="subscription">
					   		<input type="submit" style="margin-top:-5px;" class="btn btn-default" value="Go">
					  </form>
					  
				<a href="#" data-toggle="modal" data-target="#sendmailModal" class="btn btn-default btn-lg" style="margin:10px;">Message all</a>
				<?php if($settings->enable_kyc =="yes"): ?>
				<a href="<?php echo e(url('dashboard/kyc')); ?>" class="btn btn-default btn-lg">KYC</a>
				<?php endif; ?>
				
					<table class="table table-hover"> 
						<thead> 
							<tr> 
								<th>ID</th> 
								<th>Balance</th> 
								<th>First Name</th> 
								<th>Last Name</th> 
								<th>Email</th> 
								<th>Phone</th>
								<th>Inv. plan</th>
								<th>Auto Trade</th>
								<th>Status</th>
								<th>Date registered</th> 
								<th>Action</th> 
							</tr> 
						</thead> 
						<tbody> 
							<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr> 
								<th scope="row"><?php echo e($list->id); ?></th>
								 <td>$<?php echo e($list->account_bal); ?></td> 
								 <td><?php echo e($list->name); ?></td> 
								 <td><?php echo e($list->l_name); ?></td> 
								 <td><?php echo e($list->email); ?></td> 
								 <td><?php echo e($list->phone_number); ?></td>
								 <?php if(isset($list->dplan->name)): ?> 
								 <td><?php echo e($list->dplan->name); ?></td>
								 <?php else: ?>
								 <td>NULL</td>
								 <?php endif; ?> 
								 <td><?php echo e($list->auto_trade); ?></td> 
								 <td><?php echo e($list->status); ?></td> 
								 <td><?php echo e($list->created_at); ?></td> 
								 <td>
								 <?php if($list->status==NULL || $list->status=='blocked'): ?>
								 <a class="btn btn-default" href="<?php echo e(url('dashboard/unblock')); ?>/<?php echo e($list->id); ?>">Unblock</a> 
								 <?php else: ?>
								 <a class="btn btn-default" href="<?php echo e(url('dashboard/ublock')); ?>/<?php echo e($list->id); ?>">Block</a>
								 <?php endif; ?>
								 <?php if($list->trade_mode=='on'): ?>
								 <a class="btn btn-default" href="<?php echo e(url('dashboard/usertrademode')); ?>/<?php echo e($list->id); ?>/off">Turn off trade</a> 
								 <?php else: ?>
								 <a class="btn btn-default" href="<?php echo e(url('dashboard/usertrademode')); ?>/<?php echo e($list->id); ?>/on">Turn on trade</a>
								 <?php endif; ?>
								 <?php if($list->type=='1'): ?>
								 <a class="btn btn-default" href="<?php echo e(url('dashboard/makeadmin')); ?>/<?php echo e($list->id); ?>/off">Remove admin</a> 
								 <?php else: ?>
								 <a class="btn btn-default" href="<?php echo e(url('dashboard/makeadmin')); ?>/<?php echo e($list->id); ?>/on">Make admin</a>
								 <?php endif; ?>
								 <a href="#"  data-toggle="modal" data-target="#topupModal<?php echo e($list->id); ?>" class="btn btn-default">Credit/Debit</a>
								 <a href="#" data-toggle="modal" data-target="#resetpswdModal<?php echo e($list->id); ?>"  class="btn btn-default">Reset Password</a>
								 <a href="#" data-toggle="modal" data-target="#clearacctModal<?php echo e($list->id); ?>" class="btn btn-default">Clear Account</a>
								 <!--<a href="#" data-toggle="modal" data-target="#TradingModal<?php echo e($list->id); ?>" class="btn btn-default">Add Trading History</a>-->
								 <a href="<?php echo e(url('dashboard/deluser')); ?>/<?php echo e($list->id); ?>" class="btn btn-default">Delete</a>
								<a href="#" data-toggle="modal" data-target="#edituser<?php echo e($list->id); ?>" class="btn btn-default">Edit</a>
								 <a href="#" data-toggle="modal" data-target="#sendmailtooneuserModal<?php echo e($list->id); ?>" class="btn btn-primary" style="margin:10px;">Send Message</a>
								 <a href="#" data-toggle="modal" data-target="#switchuserModal<?php echo e($list->id); ?>"  class="btn btn-success">Get access</a>
								 </td> 
							</tr> 

								<!-- Deposit for a plan Modal -->
								<div id="topupModal<?php echo e($list->id); ?>" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title" style="text-align:center;">Credit/Debit user account.</strong></h4>
								</div>
								<div class="modal-body">
										<form style="padding:3px;" role="form" method="post" action="<?php echo e(action('SomeController@topup')); ?>">
											<input style="padding:5px;" class="form-control" value="<?php echo e($list->name); ?>" type="text" disabled><br/>
											<input style="padding:5px;" class="form-control" placeholder="Enter amount" type="text" name="amount" required><br/>
											<div class="form-group">
											<label for="type">Select where to credit/debit</label>
												<select class="form-control" name="type" required>
												<option value="">Select Column</option>
												<option value="Bonus">Bonus</option>
												<option value="Profit">Profit</option>
												<option value="Ref_Bonus">Ref_Bonus</option>
												<option value="Deposit">Deposit</option>
												</select>
											</div>
											<div class="form-group">
											<label for="t_type">Select credit to add, debit to subtract.</label>
												<select class="form-control" name="t_type" required>
												<option value="">Select type</option>
												<option value="Credit">Credit</option>
												<option value="Debit">Debit</option>
												</select>
											</div>
											<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
											<input type="hidden" name="user_id" value="<?php echo e($list->id); ?>">
											<input type="hidden" name="user_pln" value="<?php echo e($list->plan); ?>">
											<input type="submit" class="btn btn-default" value="Save">
									</form>
								</div>
								</div>
							</div>
							</div>
							<!-- /deposit for a plan Modal -->


							<!-- send a single user email Modal-->
							<div id="sendmailtooneuserModal<?php echo e($list->id); ?>" class="modal fade" role="dialog">
									<div class="modal-dialog">

										<!-- Modal content-->
										<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title" style="text-align:center;">This message will be sent to <?php echo e($list->name); ?> <?php echo e($list->l_name); ?> </h4>
										</div>
										
										<div class="modal-body">
												<form style="padding:3px;" role="form" method="post" action="<?php echo e(action('UsersController@sendmailtooneuser')); ?>">
													<input type="hidden" name="user_id" value="<?php echo e($list->id); ?>">
													<textarea class="form-control" name="message" row="3" required=""></textarea><br/>
													
													<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
													<input type="submit" class="btn btn-default" value="Send">
											</form>
										</div>
										</div>
									</div>
									</div>

									<!-- /Trading History Modal -->
									
									<div id="TradingModal<?php echo e($list->id); ?>" class="modal fade" role="dialog">
									<div class="modal-dialog">

										<!-- Modal content-->
										<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title" style="text-align:center;">Add Trading History for <?php echo e($list->name); ?> <?php echo e($list->l_name); ?> </h4>
										</div>
										<div class="modal-body">
												<form style="padding:3px;" role="form" method="post" action="<?php echo e(action('Controller@addHistory')); ?>">
												<input type="hidden" name="user_id" value="<?php echo e($list->id); ?>">

												<div class="form-group">
													<label>Investment Plans</label>
													<select class="form-control" name="plan">
													<option value="">Select Plan</option>
													<?php $__currentLoopData = $pl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plns): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($plns->name); ?>"><?php echo e($plns->name); ?></option>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</select>
												</div>
												<label>Amount</label>
												<input type="number" name="amount" class="form-control">
												<br>
												<div class="form-group">
													<label>Type</label>
													<select class="form-control" name="type">
													<option value="">Select type</option>
													<option value="Bonus">Bonus</option>
													<option value="ROI">ROI</option>
													</select>
												</div>
													
													<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
													<input type="submit" class="btn btn-default" value="Add History">
											</form>
										</div>
										</div>
									</div>
									</div>
									<!-- /send a single user email Modal -->
					
					<!-- Edit user Modal -->
								<div id="edituser<?php echo e($list->id); ?>" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title" style="text-align:center;">Edit user details.</strong></h4>
								</div>
								<div class="modal-body">
										<form style="padding:3px;" role="form" method="post" action="<?php echo e(action('UsersController@edituser')); ?>">
											<input style="padding:5px;" class="form-control" value="<?php echo e($list->name); ?>" type="text" disabled><br/>
											<label>Full name</label>
											<input style="padding:5px;" class="form-control" value="<?php echo e($list->name); ?>" type="text" name="name" required><br/>
											<label>Email</label>
											<input style="padding:5px;" class="form-control" value="<?php echo e($list->email); ?>" type="text" name="email" required><br/>
											<label>Phone number</label>
											<input style="padding:5px;" class="form-control" value="<?php echo e($list->phone_number); ?>" type="text" name="phone" required><br/>
											<label>Referral link</label>
											<input style="padding:5px;" class="form-control" value="<?php echo e($list->ref_link); ?>" type="text" name="ref_link" required><br/>
											<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
											<input type="hidden" name="user_id" value="<?php echo e($list->id); ?>">
											<input type="submit" class="btn btn-default" value="Update user">
									</form>
								</div>
								</div>
							</div>
							</div>
							<!-- /Edit user Modal -->

							<!-- Reset user password Modal -->
							<div id="resetpswdModal<?php echo e($list->id); ?>" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title" style="text-align:center;">You are reseting password for <?php echo e($list->name); ?>.</strong></h4>
								</div>
								<div class="modal-body">
									<p>Default password:</p>
									<h3>Abc123</h3><br>
									<a class="btn btn-default" href="<?php echo e(url('dashboard/resetpswd')); ?>/<?php echo e($list->id); ?>">Proceed</a>
								</div>
								</div>
							</div>
							</div>
							<!-- /Reset user password Modal -->
							
							<!-- Switch useraccount Modal -->
							<div id="switchuserModal<?php echo e($list->id); ?>" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title" style="text-align:center;">You are about to login as <?php echo e($list->name); ?>.</strong></h4>
								</div>
								<div class="modal-body">
									<a class="btn btn-default" href="<?php echo e(url('dashboard/switchuser')); ?>/<?php echo e($list->id); ?>">Proceed</a>
								</div>
								</div>
							</div>
							</div>
							<!-- /Switch user account Modal -->

							<!-- Clear account Modal -->
							<div id="clearacctModal<?php echo e($list->id); ?>" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title" style="text-align:center;">You are clearing account for <?php echo e($list->name); ?> to $0.00</strong></h4>
								</div>
								<div class="modal-body">
									<a class="btn btn-default" href="<?php echo e(url('dashboard/clearacct')); ?>/<?php echo e($list->id); ?>">Proceed</a>
								</div>
								</div>
							</div>
							</div>
							<!-- /Clear account Modal -->
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							
						</tbody> 
					</table>
				</div>
			</div>
		</div>
		<?php echo $__env->make('modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>