<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				<h3 class="title1">Your Notifications</h3>

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

				<h3 class="title1"></h3>
				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
					<table class="table table-hover"> 
						<thead> 
							<tr> 
                                <th>Message</th>
                                <th>Recieve Date</th>
                                <th>Option</th>
							</tr> 
						</thead> 
						<tbody> 
							<?php $__currentLoopData = $Notif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr> 
                                <td> <a href="#" data-toggle="modal" data-target="#message<?php echo e($notification->id); ?>" class=" "> <?php echo e(substr($notification->message,0,85)); ?> </a> </td> 
                                <td><?php echo e($notification->created_at); ?></td> 
                                <td> <a href="<?php echo e(url('dashboard/delnotif')); ?>/<?php echo e($notification->id); ?>" class="btn btn-default">Delete</a> </td>
							</tr> 

							<div id="message<?php echo e($notification->id); ?>" class="modal fade" role="dialog">
									<div class="modal-dialog">
										<!-- Modal content-->
										<div class="modal-content">
										<div class="modal-header .modal-dialog-centered ">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<div class="modal-body">
											<divs style="color: black" class="font-italic bg-light">
                                                <p><?php echo e($notification->message); ?></p>
                                            </div>
										</div>
										</div>
									</div>
									</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody> 
					</table>
				</div>
			</div>
		</div>
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>