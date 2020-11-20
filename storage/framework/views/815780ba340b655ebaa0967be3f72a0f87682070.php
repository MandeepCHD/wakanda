<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $trade = app('App\Http\Controllers\BuySellController'); ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				<h3 class="title1">Your Buy/Sell Orders</h3>
				
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
								<th>ORDER ID</th> 
								<th>TYPE</th>
                                <th>OPEN AT</th>
								<th>VOLUME</th> 
								<th>MARKET</th>
								<th>SYMBOL</th> 
                                <th>S/L</th>
                                <th>T/P</th>
                                <th>STATUS</th>
								<th>CLOSE AT</th> 
                                <th>PROFIT</th>
                                <th>LOSS</th>
							</tr> 
						</thead> 
						<tbody> 
							<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr> 
								 <td><?php echo e($deposit->order_type); ?></td> 
								 <td><?php echo e($deposit->type); ?></td> 
                                 <td><?php echo e($deposit->created_at); ?></td> 
								 <td><?php echo e($settings->currency); ?><?php echo e($deposit->orders); ?></td> 
								 <td><?php echo e($deposit->market); ?></td> 
                                 <td><?php echo e($deposit->symbol); ?></td> 
								 <td><?php echo e($deposit->stoploss); ?></td> 
                                 <td><?php echo e($deposit->takeprofit); ?></td> 
								 <td><?php echo e($deposit->status); ?></td> 
                                 <td><?php echo e($deposit->closed_at); ?></td> 
								 <td><?php echo e($settings->currency); ?><?php echo e($deposit->profit); ?></td> 
                                 <td><?php echo e($settings->currency); ?><?php echo e($deposit->loss); ?></td> 
							</tr> 
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody> 
					</table>
				</div>
			</div>
		</div>
        
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>