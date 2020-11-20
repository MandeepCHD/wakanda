<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">

				<?php if(Session::has('message')): ?>
		        <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-warning"></i> <?php echo e(Session::get('message')); ?>

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

				<div class="sign-up-row widget-shadow">
					<form method="post" action="<?php echo e(action('UsersController@updatepass')); ?>">
					<h5>Change Password :</h5>
					
					<div class="sign-u">
						<div class="sign-up1">
							<h4>Old Password* :</h4>
						</div>
						<div class="sign-up2">
							<input type="password" name="old_password" required>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="sign-u">
						<div class="sign-up1">
							<h4>New Password* :</h4>
						</div>
						<div class="sign-up2">
							<input type="password" name="password" required>
						</div>
						<div class="clearfix"> </div>
					</div>
					
					<div class="sign-u">
						<div class="sign-up1">
							<h4>Confirm* :</small></h4>
						</div>
						<div class="sign-up2">
							<input type="password" name="password_confirmation" required>
						</div>
						<div class="clearfix"> </div>
					</div>
					
					<div class="sub_home">
						<input type="submit" value="Submit">
						<div class="clearfix"> </div>
					</div>
					<input type="hidden" name="id" value="<?php echo e(Auth::user()->id); ?>">
                    <input type="hidden" name="current_password" value="<?php echo e(Auth::user()->password); ?>">
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"><br/>
				</form>
				</div>
			</div>
		</div>
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>