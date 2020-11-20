<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				<h3 class="title1">Your transaction (ROI) history</h3>
				
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

				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
					<table class="table table-hover"> 
						<thead> 
							<tr> 
								<th>ID</th> 
								<th>Plan</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Date created</th>
							</tr> 
						</thead> 
						<tbody> 
						<?php $__currentLoopData = $t_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr> 
								<th scope="row"><?php echo e($history->id); ?></th>
								 <td><?php echo e($history->plan); ?></td> 
                                 <td><?php echo e($settings->currency); ?><?php echo e($history->amount); ?></td> 
                                 <td><?php echo e($history->type); ?></td> 
								 <td><?php echo e($history->created_at); ?></td> 
							</tr> 
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody> 
					</table>
					<span style="margin:3px;">
				        <?php echo e($t_history->render()); ?>

				    </span>
				</div>
			</div>
		</div>
        <?php echo $__env->make('modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>