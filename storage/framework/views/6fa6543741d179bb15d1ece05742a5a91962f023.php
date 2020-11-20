<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				<h3 class="title1"><?php echo e($settings->site_name); ?> Support</h3>
				
				<div class="sign-up-row widget-shadow">
					<h4>For inquiries, suggestions or complains. Mail us at</h4>
					<h5 style="margin-top:20px;"><?php echo e($settings->contact_email); ?>

				</div>
			</div>
		</div>
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>