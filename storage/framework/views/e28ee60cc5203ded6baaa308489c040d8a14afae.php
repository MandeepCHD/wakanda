<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				<h3 class="title1">Manage clients deposits</h3>
				
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

			<div class="row">
				<div class="col">
					<form style="padding:3px; float:right;" role="form" method="post" action="<?php echo e(action('Controller@searchDp')); ?>">
						<a class="btn btn-default" href="<?php echo e(url('dashboard/mdeposits')); ?>">Show all</a>
						<input style="padding:5px; margin-top:15px;" size="50px" placeholder="Search by user ID, Status, Payment mode, Amount" type="text" name="query" required>
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
						<input type="submit" style="margin-top:-5px;" class="btn btn-default" value="Search">
					</form>
				</div>
			</div>

				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
				<span style="margin:3px;">
				        <?php echo e($deposits->render()); ?>

				    </span>
					<table class="table table-hover"> 
						<thead> 
							<tr> 
								<th>ID</th> 
								<th>Client name</th>
								<th>Client email</th>
                                <th>Amount</th>
                                <th>Payment mode</th>
                                <th>Plan</th>
								<th>Status</th> 
                                <th>Date created</th>
                                <th>Option</th>
							</tr> 
						</thead> 
						<tbody> 
							<?php $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr> 
								<th scope="row"><?php echo e($deposit->id); ?></th>
                                <td><?php echo e($deposit->duser->name); ?></td>
                                <td><?php echo e($deposit->duser->email); ?></td> 
								 <td>$<?php echo e($deposit->amount); ?></td> 
								 <td><?php echo e($deposit->payment_mode); ?></td>
								 <?php if(isset($deposit->dplan->name)): ?> 
								 <td><?php echo e($deposit->dplan->name); ?></td>
								 <?php elseif($deposit->plan=="Subscription Trading"): ?>
								 <td>Subscription Trading</td>
								 <?php else: ?>
								 <td>Account funds</td>
								 <?php endif; ?>
                                 <td><?php echo e($deposit->status); ?></td> 
								 <td><?php echo e($deposit->created_at); ?></td> 
                                 <td> 
                                 <a href="#" class="btn btn-default" data-toggle="modal" data-target="#popModal<?php echo e($deposit->id); ?>" title="View payment proof">
								     <i class="fa fa-eye"></i>
								     </a>
								     
								     <a href="<?php echo e(url('dashboard/deldeposit')); ?>/<?php echo e($deposit->id); ?>" class="btn btn-default">Delete</a>
                                 
                                 <a class="btn btn-default" href="<?php echo e(url('dashboard/pdeposit')); ?>/<?php echo e($deposit->id); ?>">Process</a>
                                 </td> 
							</tr> 
							
								<!-- POP Modal -->
			<div id="popModal<?php echo e($deposit->id); ?>" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title" style="text-align:center;"><?php echo e($deposit->duser->name); ?> proof of payment</h4>
			      </div>
			      <div class="modal-body">
                        <img src="<?php echo e($settings->site_address); ?>/cloud/app/images/<?php echo e($deposit->proof); ?>" style="max-width:100%; height: auto;">
			      </div>
			    </div>
			  </div>
			</div>
			<!-- /POP Modal -->
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody> 
					</table>
				</div>
			</div>
		</div>
        <?php echo $__env->make('modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>