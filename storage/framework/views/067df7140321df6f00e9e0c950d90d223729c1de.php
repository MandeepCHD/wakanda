<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				
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

               <!-- <a class="btn btn-default" href="#" data-toggle="modal" data-target="#withdrawalModal"><i class="fa fa-plus"></i> Request withdrawal</a>-->
			   

                <div class="row">
                    <h3 class="title1">See our withdrawal methods</h3>
                    <?php $__currentLoopData = $wmethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4">
                        <div class="panel panel-default" style="border:0px solid #fff;">
                                    <!-- Panel Heading Starts -->
                        	<div class="panel-heading">
                                <h3>
                                    <?php echo e($method->name); ?>

                                </h3>
                        	</div>
                                   
                            <div class="panel-body">
    						<h4>Minimum amount: <strong style="float:right;"> <?php echo e($settings->currency); ?><?php echo e($method->minimum); ?></strong></h4><br>
    						
    						<h4>Maximum amount:<strong style="float:right;"> <?php echo e($settings->currency); ?><?php echo e($method->maximum); ?></strong></h4><br>
    						
    						<h4>Charges (Fixed):<strong style="float:right;"> <?php echo e($settings->currency); ?><?php echo e($method->charges_fixed); ?></strong></h4><br>
    						
    						<h4>Charges (%): <strong style="float:right;"> <?php echo e($method->charges_percentage); ?>%</strong></h4><br>
    						
    						<h4>Duration:<strong style="float:right;"> <?php echo e($method->duration); ?></strong></h4><br>
    						
    						<a class="btn btn-default" href="#" data-toggle="modal" data-target="#withdrawalModal<?php echo e($method->id); ?>"><i class="fa fa-plus"></i> Request withdrawal</a>
    						</div>
                        </div>
                    </div>
                    
                    <!-- Withdrawal Modal -->
        			<div id="withdrawalModal<?php echo e($method->id); ?>" class="modal fade" role="dialog">
        			  <div class="modal-dialog">
        
        			    <!-- Modal content-->
        			    <div class="modal-content">
        			      <div class="modal-header">
        			        <button type="button" class="close" data-dismiss="modal">&times;</button>
        			        <h4 class="modal-title" style="text-align:center;">Payment will be sent through your selected method.</h4>
        			      </div>
        			      <div class="modal-body">
                                <form style="padding:3px;" role="form" method="post" action="<?php echo e(action('SomeController@withdrawal')); ?>">
        					   		<input style="padding:5px;" class="form-control" placeholder="Enter amount here" type="text" name="amount" required><br/>
        					   		<input style="padding:5px;" class="form-control" value="<?php echo e($method->name); ?>" type="text" disabled><br/>
        					   		<input value="<?php echo e($method->name); ?>" type="hidden" name="payment_mode">
        					   		<input value="<?php echo e($method->id); ?>" type="hidden" name="method_id"><br/>
                                       
        					   		<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        					   		<input type="submit" class="btn btn-default" value="Submit" onclick="this.disabled = true; form.submit(); this.value='Please Wait ...';" />
        					   </form>
        			      </div>
        			    </div>
        			  </div>
        			</div>
        			<!-- /Withdrawals Modal -->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
				
                <h3 class="title1">Your Withdrawals</h3>
				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
					<table class="table table-hover"> 
						<thead> 
							<tr> 
								<th>ID</th> 
								<th>Amount requested</th>
								<th>Amount + charges</th>
                                <th>Recieving mode</th>
								<th>Status</th> 
                                <th>Date created</th>
							</tr> 
						</thead> 
						<tbody> 
							<?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr> 
								<th scope="row"><?php echo e($withdrawal->id); ?></th>
								 <td><?php echo e($withdrawal->amount); ?></td>
								 <td><?php echo e($withdrawal->to_deduct); ?></td> 
								 <td><?php echo e($withdrawal->payment_mode); ?></td> 
                                 <td><?php echo e($withdrawal->status); ?></td> 
								 <td><?php echo e($withdrawal->created_at); ?></td> 
							</tr> 
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody> 
					</table>
				</div>
			</div>
		</div>
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>