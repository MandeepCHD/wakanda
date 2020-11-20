<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="row">
					<div class="col-lg-5 col-md-5 col-sm-5" style="margin-bottom:5px; padding:0px;">
						<h3 style="color:#555; margin:20px 0px 20px 0px;"><?php echo e($title); ?></h3>				
					</div>
				</div>
				
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
                
                <div class="sign-u" style="background-color:#fff; padding:5px 15px 15px 15px;">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 nav-pills bg-primary" style="color:#fff; padding:30px 20px 30px 20px;">
                            <h3><i class="fa fa-money"></i> Active Account</h3>
                        </div>
                        <div class="col-lg-8 col-md-8" >
                            <!-- <p style="color:#999;">Activated on: <?php echo e(\Carbon\Carbon::parse($cplan->created_at)->toDayDateTimeString()); ?></p> -->
                            
                            <h4>Account name: <small><?php echo e($cplan->name); ?></small></h4>
                            
                            <h4>Amount: <small><?php echo e($settings->currency); ?><?php echo e($cplan->price); ?></small></h4>
                            <!-- <h4>Duration: <small><?php echo e($cplan->inv_duration); ?></small></h4> -->
                            <?php if(Auth::user()->acnt_type_active=="yes"): ?>
                            <p style="color:green;">Active! <i class="glyphicon glyphicon-ok"></i></p>
                            <?php else: ?>
                            <p style="color:#fa3425;">Inactive! <i class="fa fa-info-circle"></i></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" data-toggle="modal" data-target="#switchtypeModal" class="d-inline btn btn-sm btn-danger rounded-pill">Switch Type</a>
                            <!-- Modal -->
                            <div class="modal fade" id="switchtypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Switch Account Now</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="">
                                            <form action="<?php echo e(action('SomeController@switchaccount')); ?>" method="post">
                                                <select name="acnt_change" id="" class="form-control">
                                                <option value="">Select Account Type</option>
                                                <?php $__currentLoopData = $system_plan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($plan->id); ?>"><?php echo e($plan->name); ?>, Amount: <?php echo e($settings->currency); ?><?php echo e($plan->price); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select> <br>
                                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                <input type="hidden" name="time" value="later">
                                                <input type="hidden" name="id" value="<?php echo e(Auth::user()->id); ?>">
                                                <input type="submit" value="Change" class="btn btn-primary">
                                            </form>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
					
                        </div>
                    </div>
				</div>
				
				<!-- <h3 style="margin:20px 0px 20px 0px;">Concurrent packages</h3>
 
                <a href="<?php echo e(url('dashboard/mplans')); ?>" class="btn btn-lg btn-default nav-pills" style="color:#fff; background-color:brown; border-radius: none; ">Add plan</a>
                
                    <div class="row row-one" style="margin-top:10px;">
                    <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if($cplan->id != $plan->id): ?>
                        <div class="col-md-4" style="margin-bottom: 18px;">
                            <div class="flip-card">
                                <div class="flip-card-inner">
                                    <div class="flip-card-front text-center" style="padding-top:25px;">
                                        <i class="fa fa-th" style="font-size:50px; color: white;"></i>
                                        <h1 style="color:#fff;"><?php echo e($plan->dplan->name); ?></h1>
										<div style="text-align:left; padding:6px;">
                                        <p style="color:black;"> <b style="color: white;">Activated on: </b><?php echo e(\Carbon\Carbon::parse($plan->created_at)->toDayDateTimeString()); ?></p>
										<?php if($plan->dplan->increment_type=="Fixed"): ?>
										<p style="color:black;"> <b style="color: white;">ROI: </b><?php echo e($settings->currency.$plan->dplan->increment_amount); ?></p>
										<?php else: ?>
										<p style="color:black;"> <b style="color: white;">ROI: </b><?php echo e($plan->dplan->increment_amount); ?>%</p>
										<?php endif; ?>
										<p style="color:black;"> <b style="color: white;">Interval: </b><?php echo e($plan->dplan->increment_interval); ?></p>
										</div>
                                    </div>
                                    <div class="flip-card-back" style="text-align:left; padding:30px;">
                                        <h3> <b>Amount:</b> <?php echo e($settings->currency); ?><?php echo e($plan->amount); ?></h3> 
                                        <h3> <b>Duration: </b><?php echo e($plan->inv_duration); ?></h3>
										<p style="color:black;"> <b style="color: white;">Min Return: </b><?php echo e($settings->currency.$plan->dplan->minr); ?></p>
										<p style="color:black;"> <b style="color: white;">Max Return: </b><?php echo e($settings->currency.$plan->dplan->maxr); ?></p>
                                        <?php if($plan->active=="yes"): ?>
                                        <p style="color:green;">Active! <i class="glyphicon glyphicon-ok"></i></p>
                                        <?php elseif($plan->active=="expired"): ?>
                                        <p style="color:#fa3425;">Expired! <i class="fa fa-info-circle"></i></p>
                                        <?php else: ?>
                                        <p style="color:#fa3425;">Inactive! <i class="fa fa-info-circle"></i></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <?php endif; ?>
				        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div> -->
			</div>
		</div>	
	<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	