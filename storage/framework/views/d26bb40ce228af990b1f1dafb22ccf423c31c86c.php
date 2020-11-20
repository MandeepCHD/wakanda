<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $trade = app('App\Http\Controllers\BuySellController'); ?>
		<!-- main content start-->
		<div id="page-wrapper" style="padding-left:0px; padding-right:5px;">
			<div class="main-page mp">
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
				
				<div class="row" style="background-color:#171e2b; padding:10px 10px 10px 10px;">

							<div class="col-lg-5 col-md-5 col-sm-5" style="padding-top:10px">
							    <h4>
    							<a href="javascript:void(0)" id="" class="d-inline mr-4 chartmarket" style="margin: 10px">Forex</a>
    							<a href="javascript:void(0)" id="" class="d-inline m-4 chartmarket" style="margin: 10px">Stock</a>
    							<a href="javascript:void(0)" id="" class="d-inline m-4 chartmarket" style="margin: 10px">Cryptocurrency</a>
    							<a href="javascript:void(0)" id=""class="d-inline m-4 chartmarket" style="margin: 10px">Indices</a>
    							<a href="javascript:void(0)" id="" class="d-inline m-4 chartmarket " style="margin: 10px">CFD</a>
    							</h4>
							</div>
							
							<div class="col-lg-7 col-md-7 col-sm-7 ">
    							<button class="btn btn-danger by d-inline" data-toggle="modal" data-target="#sellModal" style="margin-right:10px; padding:9px 40px;">Sell</button>
    							<button class="btn btn-success by d-inline" data-toggle="modal" data-target="#buyModal" style="margin-right:10px;padding:9px 40px;">Buy</button>
    							
    							<form method="POST" action="javascript:void(0)" style="display:inline;" name="auto" id="auto" >
    							    <label style="color:#fff;">Auto Trading: </label>
    									<label class="switch form-check-inline d-inline">
    										<input id="switchbox" name="auto_trade" id="check" type="checkbox">
    										<span class="slider round"></span>
    									</label>
    									<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
    							</form>
    							<?php if(Auth::user()->auto_trade =='yes'): ?>
    								<script>document.getElementById("switchbox").checked= true;</script>
    							<?php endif; ?>
    
    							
    							
							<strong class="btn btn-success bal" style="float:right;"><h3>Bal: <?php echo e($settings->currency); ?><?php echo e(number_format(Auth::user()->account_bal, 2, '.', ',')); ?></h3></strong>
							
							</div>
					<div class="clearfix"> </div>
				</div>

				<div class="row-one" style="background-color:#171e2b; margin-top:10px; text-align:center;">
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-briefcase fa-stack-1x"></i>
                        </span>
					    DEPOSITED
					    </h4>
						<h3 style=" margin-top:20px;" title="Your account balance">
						    <?php $__currentLoopData = $deposited; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposited): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						    <?php if(!empty($deposited->count)): ?>
							<?php echo e($settings->currency); ?><?php echo e($deposited->count); ?>

							<?php else: ?>
							<?php echo e($settings->currency); ?>0.00
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</h3>
					</div>
					
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon2-background"></i>
                          <i class="fa fa-lock fa-stack-1x"></i>
                        </span>
					    PROFIT
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							<?php echo e($settings->currency); ?><?php echo e(number_format(Auth::user()->roi, 2, '.', ',')); ?>

						</h3>
					</div>
					
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon3-background"></i>
                          <i class="fa fa-gift fa-stack-1x"></i>
                        </span>
					    BONUS
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							<?php echo e($settings->currency); ?> <?php echo e(number_format($total_bonus->bonus, 2, '.', ',')); ?>

						</h3>
					</div>
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon3-background"></i>
                          <i class="fa fa-bullhorn fa-stack-1x"></i>
                        </span>
					    REF. BONUS
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							<?php echo e($settings->currency); ?><?php echo e(number_format(Auth::user()->ref_bonus, 2, '.', ',')); ?>

						</h3>
					</div>

					<!--<div class="col-md-4 col-sm-6 rp t-b" style="margin-top: 8px;">-->
					<!--    <h4>-->
					<!--    <span class="fa-stack">-->
     <!--                     <i class="fa fa-circle fa-stack-2x icon1-background"></i>-->
     <!--                     <i class="fa fa-money fa-stack-1x"></i>-->
     <!--                   </span>-->
					<!--    BALANCE-->
					<!--	</h4>-->
					<!--	<div class="row"  style="display:inline;">-->
					<!--	<div class="col-lg-6 col-md-6"  style="display:inline;">-->
					<!--	<h3 style="text-align:center;" title="Your account balance">-->
					<!--	<small>Main balance<br>-->
					<!--		<?php echo e($settings->currency); ?><?php echo e(number_format(Auth::user()->account_bal, 2, '.', ',')); ?></small>-->
					<!--	</h3>-->
					<!--	</div>-->
					<!--	<div class="col-lg-6 col-md-6" style="display:inline;">-->
					<!--	<h3 style="text-align:center;" title="Your trading balance">-->
					<!--	<small>Trading account<br>-->
					<!--		<?php echo e($settings->currency); ?><?php echo e(number_format($trade->get_bal(Auth::user()->id,"USD"), 2, '.', ',')); ?></small>-->
					<!--	</h3>-->
					<!--	</div>-->
					<!--	</div>-->
					<!--</div>-->

					<!--<div class="col-md-4 col-sm-6 rp t-b" style="margin-top: 8px;">-->
					<!--    <h4>-->
					<!--    <span class="fa-stack">-->
     <!--                     <i class="fa fa-circle fa-stack-2x icon1-background"></i>-->
     <!--                     <i class="fa fa-unlock fa-stack-1x"></i>-->
     <!--                   </span>-->
					<!--    TOTAL PACKAGES-->
					<!--    </h4>-->
					<!--	<h3 style=" margin-top:20px;" title="Your account balance">-->
					<!--	<?php if(count($user_plan)>0): ?>-->
					<!--	   <?php echo e($user_plan->count()); ?>-->
					<!--	<?php else: ?>-->
					<!--		0-->
					<!--	<?php endif; ?>-->
					<!--	</h3>-->
					<!--</div>-->
					<!--<div class="col-md-4 col-sm-6 rp t-b" style="margin-top: 8px;">-->
					<!--    <h4>-->
					<!--    <span class="fa-stack">-->
     <!--                     <i class="fa fa-circle fa-stack-2x icon1-background"></i>-->
     <!--                     <i class="fa fa-unlock-alt fa-stack-1x" ></i>-->
					<!--	</span>-->
					<!--	ACTIVE PACKAGES-->
					<!--    </h4>-->
					<!--	<h3 style=" margin-top:20px;" title="Your account balance">-->
					<!--		<?php if(count($user_plan_active)>0): ?>-->
					<!--	   <?php echo e($user_plan_active->count()); ?>-->
					<!--		<?php else: ?>-->
					<!--			0-->
					<!--		<?php endif; ?>-->
					<!--	</h3>-->
					<!--</div>-->
					<!-- <div class="col-md-4 col-sm-6 rp t-b" style="margin-top: 8px;">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-money fa-stack-1x"></i>
                        </span>
					    FEES
						</h4>
						<div class="row"  style="display:inline;">
						<div class="col-lg-6 col-md-6"  style="display:inline;">
						<h3 style="text-align:center;" title="Last fee paid">
						<small>Last Fee<br>
							<?php echo e($settings->currency); ?><?php echo e(number_format($last_fee, 2, '.', ',')); ?></small>
						</h3>
						</div>
						<div class="col-lg-6 col-md-6" style="display:inline;">
						<h3 style="text-align:center;" title="Total fees paid">
						<small>Total Fee<br>
						<?php echo e($settings->currency); ?><?php echo e(number_format($total_fee, 2, '.', ',')); ?> </small>
						</h3>
						</div>
						</div>
					</div> -->
					<!--
					<?php if(empty($uplan)): ?>
					<div class="col-md-3 rp" style="text-align:center; color:#fa3425;">
					<h4>Activate account!<br>
					<small>
					<a style="background-color:#fa3425; color:#fff; padding:4px;" href="<?php echo e(url('dashboard/mplans')); ?>">Join a plan</a> 
					</small>
					</h4>
					</div>
					<?php else: ?>
					<div class="col-md-3 rp">
						<h4>
						    <small>Current plan</small><br>
						    <strong><?php echo e($uplan->name); ?></strong>
							 
						</h4>
					</div>
					<?php endif; ?>	
					-->
					


				
				<div class="clearfix"> </div>
			</div>
					
			<div id="chart-page">
                <?php echo $__env->make('chart', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        	</div>
			</div>	
	<!-- Modal -->
	<div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Buy Order</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form  id="buyorder" role="form" method="post" action="javascript:void(0)">
						<div class="form-row">
							<div class="col-md-6"  style="margin-bottom: 5px">
								<label >Volume</label>
								<input type="number" name="amount" class="form-control" placeholder="Amount to Buy" required>
							</div>

							<div class="col-md-6"  style="margin-bottom: 5px">
								<label>Type</label>
								<select name="type" id="" class="form-control">
								<option value="">Select</option>
									<option value="Market Execution">Market Execution</option>
									<option value="Pending Order">Pending Order</option>
								</select>
							</div>

						</div>
						<div class="form-row mb-3" >
							<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
								<label>Market</label>
								<select name="market" id="market" class="form-control">
									<option value="">Select</option>
									<option value="Cryptocurrency">Cryptocurrency</option> 
									<option value="Stock">Stock</option> 
									<option value="Currency">Currency</option> 
									<option value="Commodity">CFD</option> 
									<option value="Commodity">Indices</option> 
								</select>
							</div>
							<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
								<label>Asset</label>
								<select name="symbol" id="asset" class="form-control">
									<!-- <option value="">Select</option> -->
								</select>
							</div>
						</div>
						
						<div class="form-row mb-3" >
							<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
							<label>Stop Loss</label>
							<input type="text"  name="stoploss" class="form-control" placeholder="0.000">
							</div>
							<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
							<label>Take Profit</label>
							<input type="text"  name="takeprofit" class="form-control" placeholder="0.000">
							</div>
						</div>
						<div class="form-row mb-3" style="margin-bottom: 5px">
							<div class="col-md-12 mb-3">
							<label>Comment</label>
							<input type="text" name="comment" class="form-control"> <br>
							</div>
						</div>
						<div  style="padding:5px; margin-bottom: 5px">
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
						<button class="btn btn-success btn-block" type="submit">Buy Now</button>
						</div>
					</form>

					<script type="text/javascript">
                            //create investment
							$("#buyorder").on('submit',function(){
                                $.ajax({
                                    url: "<?php echo e(url('/dashboard/addbuyorder')); ?>",
                                    type: 'POST',
                                    data:$("#buyorder").serialize(),
                                    success: function (response) {
                                        if(response.status ===200){
                                            swal({
                                        icon: "success",
                                        text: response.message,
                                        timer:6000,
                                        });
										location.reload(true);
                                        }
                                        if(response.status ===201){
                                            swal({
                                        icon: "error",
                                        text: response.message,
                                        timer:6000,
                                        });
										location.reload(true);
                                        }
                                    },
                                    error: function (data) {
                                        swal({
                                        icon: "error",
                                        text: "Something went wrong", 
                                        timer:6000,
                                        });
                                    },

                                });
                            });

					$(document).ready(function () {
						$("#market").change(function () {
							var val = $(this).val();
							if (val == "Cryptocurrency") {
								$("#asset").html("<?php echo $trade->getAssets('Cryptocurrency'); ?>");
							} else if (val == "Stock") {
								$("#asset").html("<?php echo $trade->getAssets('Stock'); ?>");
							} else if (val == "Currency") {
								$("#asset").html("<?php echo $trade->getAssets('Currency'); ?>");
							} else if (val == "CFD") {
								$("#asset").html("<?php echo $trade->getAssets('CFD'); ?>");
							}else if(val == "Indices"){
								$("#asset").html("<?php echo $trade->getAssets('Indices'); ?>");
							}
						});
					});
				</script>
				</div>
			</div>
		</div>
	</div>

					
		<!-- Modal -->
		<div class="modal fade" id="sellModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Sell Market</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="sellorder" role="form" method="post" action="javascript:void(0)">
							<div class="form-row">
								<div class="col-md-6"  style="margin-bottom: 5px">
									<label >Volume</label>
									<input type="number" name="amount" class="form-control" placeholder="Amount to Sell" required>
								</div>

								<div class="col-md-6"  style="margin-bottom: 5px">
									<label>Type</label>
									<select name="type" id="" class="form-control">
									<option value="">Select</option>
										<option value="Market Execution">Market Execution</option>
										<option value="Pending Order">Pending Order</option>
									</select>
								</div>

							</div>
							<div class="form-row mb-3" >
								<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
									<label>Market</label>
									<select name="market" id="mark" class="form-control">
										<option value="">Select</option>
										<option value="Cryptocurrency">Cryptocurrency</option> 
										<option value="Stock">Stock</option> 
										<option value="Currency">Currency</option> 
										<option value="Commodity">Commodity</option> 
									</select>
								</div>
								<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
									<label>Asset</label>
									<select name="symbol" id="ass" class="form-control">
									</select>
								</div>
							</div>
							
							<div class="form-row mb-3" >
								<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
								<label>Stop Loss</label>
								<input type="text" name="stoploss" class="form-control" placeholder="0.000">
								</div>
								<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
								<label>Take Profit</label>
								<input type="text" name="takeprofit" class="form-control" placeholder="0.000">
								</div>
							</div>
							<div class="form-row mb-3" style="margin-bottom: 5px">
								<div class="col-md-12 mb-3">
								<label>Comment</label>
								<input type="text" name="comment" class="form-control"> <br>
								</div>
							</div>
							<div  style="padding:5px; margin-bottom: 5px">
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
							<button class="btn btn-danger btn-block" type="submit">Sell by Market</button>
							</div>
							
						</form>

						<script type="text/javascript">

							$("#sellorder").on('submit',function(){
                                $.ajax({
                                    url: "<?php echo e(url('/dashboard/addsellorder')); ?>",
                                    type: 'POST',
                                    data:$("#sellorder").serialize(),
                                    success: function (response) {
                                        if(response.status ===200){
                                            swal({
                                        icon: "success",
                                        text: response.message,
                                        timer:6000,
                                        });
										location.reload(true);
                                        }
                                        if(response.status ===201){
                                            swal({
                                        icon: "error",
                                        text: response.message,
                                        timer:6000,
                                        });
										location.reload(true);
                                        }
                                    },
                                    error: function (data) {
                                        swal({
                                        icon: "error",
                                        text: "Something went wrong", 
                                        timer:6000,
                                        });
                                    },

                                });
                            });



							$(document).ready(function () {
								$("#mark").change(function () {
									var val = $(this).val();
									if (val == "Cryptocurrency") {
										$("#ass").html("<?php echo $trade->getAssets('Cryptocurrency'); ?>");
									} else if (val == "Stock") {
										$("#ass").html("<?php echo $trade->getAssets('Stock'); ?>");
									} else if (val == "Currency") {
										$("#ass").html("<?php echo $trade->getAssets('Currency'); ?>");
									} else if (val == "CFD") {
										$("#ass").html("<?php echo $trade->getAssets('CFD'); ?>");
									}else if(val == "Indices"){
										$("#ass").html("<?php echo $trade->getAssets('Indices'); ?>");
									}
								});
							});
						</script>
					</div>
					
				</div>
			</div>
		</div>
						<!-- Bu modal -->

<script>
$('#switchbox').change('checked',function(){
        if(this.checked) {
			var url = "<?php echo e(url('/dashboard/autotrade/on')); ?>";
        }
        else{
			var url = "<?php echo e(url('/dashboard/autotrade/off')); ?>";
        }
        $.ajax({
            url: url,
            type: 'GET',
            data:$('#auto').serialize(),
            success: function (data) {
                swal({
                icon: "success",
                text: data.message,
                timer:6000,
                });
                //location.reload(true);
            },
            error: function (data) {
                swal({
                icon: "error",
                text: "Something went wrong", 
                timer:9000,
                });
            },
        });
    });
</script>
	<?php echo $__env->make('modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>		
	<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	