<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $uc = app('App\Http\Controllers\UsersController'); ?>
<?php
$array = \App\users::all();
$usr = Auth::user()->id;
?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				<h3 class="title1">Refer users to <?php echo e($settings->site_name); ?> community</h3>

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
                
                
                <?php if(Auth::user()->type =="1"): ?>
                <div class="sign-up-row widget-shadow">
                    <h2 style="text-align:center;">Add users</h2><br>
					
                <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('dashboard/saveuser')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label for="name" class="col-md-4 control-label">Full Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required>

                                <?php if($errors->has('name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required>

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="col-md-4 control-label">Phone number</label>

                            <div class="col-md-6">
                                <input id="phone" type="number" class="form-control" name="phone" value="<?php echo e(old('phone')); ?>" required>

                                <?php if($errors->has('phone')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('phone')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                <?php if($errors->has('password_confirmation')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
                        </div>
                    </form>

				</div>
                <?php endif; ?>


				<div class="sign-up-row widget-shadow">
                    <strong>You can refer users by sharing your referral link:</strong><br>
					<h4 style="color:green;"> <?php echo e(Auth::user()->ref_link); ?></h4>
                
				</div>
				
				<h3 class="title1">
                <small>Your sponsor</small><br>
                <i class="fa fa-user"></i><br>
                <small><?php echo e($uc->getUserParent($usr)); ?></small>
                </h3>

				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
					<table class="table table-hover"> 
						<thead> 
							<tr> 
								<th>Client name</th>
                                <th>Client Inv. plan</th>
                                <th>Client status</th>
                                <th>Ref level</th>
                                <th>Date registered</th>
							</tr> 
						</thead> 
						<tbody> 
							<?php echo $uc->getdownlines($array,$usr); ?>

						</tbody> 
					</table>
				</div>
			</div>
		</div>
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>