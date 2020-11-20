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
					<table class="table table-hover" id="table"> 
						<thead> 
							<tr> 
                                <th>CLIENT NAME</th> 
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
                                <th>ACTIONS</th>
							</tr> 
						</thead> 
						<tbody> 
							<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr> 
                                <td><?php echo e($deposit->duser->name); ?> <?php echo e($deposit->duser->l_name); ?></td> 
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
                                 <td><a href="#" data-toggle="modal" data-target="#editorder<?php echo e($deposit->id); ?>" class="btn btn-primary">Edit Order</a>
                                 
                                 <a class="btn btn-default" href="<?php echo e(url('dashboard/closeorder')); ?>/<?php echo e($deposit->id); ?>">Close</a></td> 
							</tr> 


                            <!-- Edit user Modal -->
								<div id="editorder<?php echo e($deposit->id); ?>" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title" style="text-align:center;">Edit Order details.</strong></h4>
								</div>
								<div class="modal-body">
                                    <form  id="buyorder" role="form" method="post" action="<?php echo e(action('Controller@editorder')); ?>">
                                        <div class="form-row">
                                            <div class="col-md-6"  style="margin-bottom: 5px">
                                                <label >Volume</label>
                                                <input type="number" value="<?php echo e($deposit->orders); ?>" name="amount" class="form-control" placeholder="Amount to Buy" required>
                                            </div>

                                            <div class="col-md-6"  style="margin-bottom: 5px">
                                                <label>Type</label>
                                                <select name="type" id="" class="form-control">
                                                <option value="<?php echo e($deposit->type); ?>"><?php echo e($deposit->type); ?></option>
                                                    <option value="Market Execution">Market Execution</option>
                                                    <option value="Pending Order">Pending Order</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-row mb-3" >
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                                <label>Market</label>
                                                <select name="market" id="market" class="form-control">
                                                    <option value="<?php echo e($deposit->market); ?>"><?php echo e($deposit->market); ?></option>
                                                    <option value="Cryptocurrency">Cryptocurrency</option> 
                                                    <option value="Stock">Stock</option> 
                                                    <option value="Currency">Currency</option> 
                                                    <option value="Commodity">CFD</option> 
                                                    <option value="Commodity">Indices</option> 
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                                <label>Asset</label>
                                                <select name="symbol" class="form-control">
                                                    <option value="<?php echo e($deposit->symbol); ?>"><?php echo e($deposit->symbol); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-row mb-3" >
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                            <label>Stop Loss</label>
                                            <input type="text" value="<?php echo e($deposit->stoploss); ?>"  name="stoploss" class="form-control" placeholder="0.000" required>
                                            </div>
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                            <label>Take Profit</label>
                                            <input type="text" value="<?php echo e($deposit->takeprofit); ?>" name="takeprofit" class="form-control" placeholder="0.000" required>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3" >
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                            <label>Profit</label>
                                            <input type="text"  name="profitt" class="form-control">
                                            </div>
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                            <label>Loss</label>
                                            <input type="text" name="losss" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row mb-3" style="margin-bottom: 5px">
                                            <div class="col-md-12 mb-3">
                                            <label>Comment</label>
                                            <input type="text" name="comment" value="<?php echo e($deposit->comment); ?>" class="form-control"> <br>
                                            </div>
                                        </div>
                                        
                                        <div  style="padding:5px; margin-bottom: 5px">
                                        <input type="hidden" name="profit" value="<?php echo e($deposit->profit); ?>">
										<input type="hidden" name="loss" value="<?php echo e($deposit->loss); ?>">

                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                        <input type="hidden" name="user_id" value="<?php echo e($deposit->user); ?>">
										<input type="hidden" name="id" value="<?php echo e($deposit->id); ?>">
                                        <button class="btn btn-success btn-block" type="submit">Update</button>
                                        </div>
                                    </form>
								</div>
								</div>
							</div>
							</div>
							<!-- /Edit user Modal -->
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody> 
					</table>
				</div>
			</div>
		</div>
        
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>