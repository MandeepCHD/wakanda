<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				<h3 class="title1">Available Plans</h3>
				
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

				<a class="btn btn-default" href="#" data-toggle="modal" data-target="#plansModal"><i class="fa fa-plus"></i> New plan</a>

                <div class="containter">
						<div class="row">
						<h2>Main plans</h2>
						<?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                		<div class="col-lg-4">
							<div class="sign-up-row widget-shadow" style="width:100%; padding:0px;">
								<h3 style="background-color:#e9e9e9; padding:20px;">
								<?php echo e($plan->name); ?>

								<?php if(Auth::user()->type=="1"): ?>
								<a href="#" data-toggle="modal" data-target="#editplansModal<?php echo e($plan->id); ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>&nbsp; &nbsp;
								<a href="<?php echo e(url('dashboard/trashplan')); ?>/<?php echo e($plan->id); ?>" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i></a>
								<?php endif; ?>
								</h3>
								<div style="padding:20px; text-align:center;">
								<h4><strong><?php echo e($settings->currency); ?><?php echo e($plan->price); ?>+</strong><br><br><small> <b>Min. Possible deposit:</b>  <?php echo e($settings->currency); ?><?php echo e($plan->min_price); ?> <br><b>Max. Possible deposit:</b> <?php echo e($settings->currency); ?><?php echo e($plan->max_price); ?></small></h4>
									<hr>
									<p><i class="fa fa-star"></i><?php echo e($settings->currency); ?><?php echo e($plan->minr); ?> Minimum return</p>
									<hr>
									<p><i class="fa fa-star"></i><?php echo e($settings->currency); ?><?php echo e($plan->maxr); ?> Maximum return</p>
									<hr>
									<p><i class="fa fa-gift"></i> <?php echo e($settings->currency); ?><?php echo e($plan->gift); ?> Gift Bonus</p>
									<hr>
									<form style="padding:3px;" role="form" method="post" action="<?php echo e(action('Controller@joinplan')); ?>">
					                    <label>Amount to invest: (<?php echo e($settings->currency); ?><?php echo e($plan->price); ?> default)</label><br><br>
                                        <input type="number" min="<?php echo e($plan->min_price); ?>" max="<?php echo e($plan->max_price); ?>" name="iamount" placeholder="<?php echo e($settings->currency.$plan->price); ?>" class="form-control">
                                       <hr>
            							   <label>Select investment duration</label><br/>
                                           <select class="form-control" name="" style="border:0px solid #fff; height:50px; font-weight:bold;" disabled>
            									<option><?php echo e($plan->expiration); ?></option>
            								</select><br>
											<input type="hidden" name="duration" value="<?php echo e($plan->expiration); ?>">
            							   <input type="hidden" name="id" value="<?php echo e($plan->id); ?>">
            					   		<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            					   		<input type="submit" class="btn btn-default" value="Join plan">
            					   </form>
								</div>
							</div>
						</div>

						<!-- edit Plans Modal -->
			<div id="editplansModal<?php echo e($plan->id); ?>" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title" style="text-align:center;">Add new plan / package</h4>
			      </div>
			      <div class="modal-body">
              		<form style="padding:3px;" role="form" method="post" action="<?php echo e(action('Controller@updateplan')); ?>">
					  <label>Plan name</label><br/>	   
					  <input style="padding:5px;" class="form-control" value="<?php echo e($plan->name); ?>" type="text" name="name" required><br/>
					  <label>Plan price</label><br/>		 
					  <input style="padding:5px;" class="form-control" value="<?php echo e($plan->price); ?>" type="text" name="price" required><br/>
					  <label>Plan MIN. price</label><br/>		 
					  <input style="padding:5px;" class="form-control" value="<?php echo e($plan->min_price); ?>" type="text" name="min_price" required><br/>
					  <label>Plan MAX. price</label><br/>		 
					  <input style="padding:5px;" class="form-control" value="<?php echo e($plan->max_price); ?>" type="text" name="max_price" required><br/>
					  <label>Minimum return</label><br/>
					<input style="padding:5px;" class="form-control" value="<?php echo e($plan->minr); ?>" placeholder="Enter minimum return" type="text" name="minr" required><br/>
					<label>Maximum return</label><br/>
					<input style="padding:5px;" class="form-control" value="<?php echo e($plan->maxr); ?>"  placeholder="Enter maximum return" type="text" name="maxr" required><br/>
					<label>Gift Bonus</label><br/>
					<input style="padding:5px;" class="form-control" value="<?php echo e($plan->gift); ?>"  placeholder="Enter Additional Gift Bonus" type="text" name="gift" required><br/>
					  <!-- <label>Plan expected return (ROI)</label><br/>
					  <input style="padding:5px;" class="form-control" placeholder="Enter expected return" value="<?php echo e($plan->expected_return); ?>" type="text" name="return" required><br/> -->
					  
					  
								 <label>top up interval</label><br/>
                               <select class="form-control" name="t_interval">
									<option><?php echo e($plan->increment_interval); ?></option>
									<option>Monthly</option>
									<option>Weekly</option>
									<option>Daily</option>
									<option>Hourly</option>
								</select><br>
								<label>top up type</label><br/>
                               <select class="form-control" name="t_type">
									<option><?php echo e($plan->increment_type); ?></option>
									<option>Percentage</option>
									<option>Fixed</option>
								</select><br>
								<label>top up amount (in % or $ as specified above)</label><br/>
                               <input style="padding:5px;" class="form-control" value="<?php echo e($plan->increment_amount); ?>" placeholder="top up amount" type="text" name="t_amount" required><br/>
							   <label>Investment duration</label><br/>
                               <select class="form-control" name="expiration">
									<option><?php echo e($plan->expiration); ?></option>
									<option>One week</option>
									<option>One month</option>
									<option>Three months</option>
									<option>Six months</option>
									<option>One year</option>
								</select><br>
							   <input type="hidden" name="id" value="<?php echo e($plan->id); ?>">
					   		<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					   		<input type="submit" class="btn btn-default" value="Submit">
					   </form>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- /edit plans Modal -->
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						
					</div>
				</div>
			</div>
		</div>
		<?php echo $__env->make('modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>