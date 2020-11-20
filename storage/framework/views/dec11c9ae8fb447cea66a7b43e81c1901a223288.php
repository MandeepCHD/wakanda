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
				
				
				<div class="row" style="background-color:#171e2b; padding:20px 20px 10px 10px;">

							<div class="col-lg-6 col-md-6 col-sm-6" style="padding-top:10px">
							    <h4 class="mybtn">
    							<a href="javascript:void(0)" class="d-inline mr-4 chartmarket" style="margin: 10px">Forex</a>
    							<a href="javascript:void(0)" class="d-inline m-4 chartmarket" style="margin: 10px">Stock</a>
    							<a href="javascript:void(0)" class="d-inline m-4 chartmarket" style="margin: 10px">Cryptocurrency</a>
    							<a href="javascript:void(0)" class="d-inline m-4 chartmarket " style="margin: 10px">Indices</a>
    							<a href="javascript:void(0)" class="d-inline m-4 chartmarket " style="margin: 10px">CFD</a>
    							</h4>
							</div>
							
							
							<div class="col-lg-6 col-md-6 col-sm-6">
    							<div class="wrap-section">
										<button class="btn btn-danger by d-inline" data-toggle="modal" data-target="#sellModal" style="margin-right:10px; padding:9px 40px;"><h4>Sell</h4></button>
										<button class="btn btn-success  d-inline" data-toggle="modal" data-target="#buyModal" style="margin-right:10px;padding:9px 40px;"><h4>Buy</h4></button>
									
    
								</div>
    							
    							
							
							
						</div>
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
					<h5 class="modal-title" id="exampleModalLabel">Buy Order <span style="display:none;" id="price_c"></span></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form  id="buysellorder" role="form" method="post" action="javascript:void(0)">
						<div class="form-row">
							<div class="col-md-6"  style="margin-bottom: 5px">
								<label >Volume in base currency</label>
								<input type="number" min="0" step="any" id="pinput1" onkeyup="priceFunction1(this)" name="base_amount" class="form-control" placeholder="Amount to Buy" required>
							</div>

							<div class="col-md-6"  style="margin-bottom: 5px">
								<label>Amount in quote currency</label>
								<input type="number" min="0" step="any" id="pinput2" onkeyup="priceFunction2(this)" name="quote_amount" class="form-control" placeholder="Amount in quote currency">
							</div>

						</div>
						<div class="form-row mb-3" >
							<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
							<label>Instrument</label>
								<input type="text"  name="market_pair" id="bmarket" class="form-control" placeholder="market" value="BTCUSD" required>
							</div>
							</div>
							<div class="col-md-6 mb-3"  style="margin-bottom: 15px">
								<label>Type</label>
								<select name="ordertype" id="" class="form-control">
									<option value="Market Execution">Market Execution</option>
								</select>
							</div>
						</div>
						
						<div  style="padding:5px; margin-bottom: 5px">
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
						<input type="hidden" name="type" value="Buy">
						<button class="btn btn-success btn-block" type="submit">Buy Now</button>
						</div>
					</form>

					<!-- <script type="text/javascript">


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
				</script> -->
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
						<form id="buysellorder" role="form" method="post" action="javascript:void(0)">
						<div class="form-row">
							<div class="col-md-6"  style="margin-bottom: 5px">
								<label >Volume in base currency</label>
								<input type="number" min="0" step="any" id="sinput1" onkeyup="spriceFunction1(this)" name="base_amount" class="form-control" placeholder="Amount to Sell" required>
							</div>

							<div class="col-md-6"  style="margin-bottom: 5px">
								<label>Amount in quote currency</label>
								<input type="number" min="0" step="any" id="sinput2" onkeyup="spriceFunction2(this)" name="quote_amount" class="form-control" placeholder="Amount in quote currency">
							</div>

						</div>
						<div class="form-row mb-3" >
							<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
							<label>Instrument</label>
								<input type="text"  name="market_pair" id="smarket" class="form-control" placeholder="market" value="BTCUSD" required>
							</div>
							</div>
							<div class="col-md-6 mb-3"  style="margin-bottom: 15px">
								<label>Type</label>
								<select name="ordertype" id="" class="form-control">
									<option value="Market Execution">Market Execution</option>
								</select>
							</div>
						</div>

							<div  style="padding:5px; margin-bottom: 5px">
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
							<input type="hidden" name="type" value="Sell">
							<button class="btn btn-danger btn-block" type="submit">Sell by Market</button>
							</div>
							
						</form>

						<!-- <script type="text/javascript">

							// $("#sellorder").on('submit',function(){
                            //     $.ajax({
                            //         url: "<?php echo e(url('/dashboard/addsellorder')); ?>",
                            //         type: 'POST',
                            //         data:$("#sellorder").serialize(),
                            //         success: function (response) {
                            //             if(response.status ===200){
                            //                 swal({
                            //             icon: "success",
                            //             text: response.message,
                            //             timer:6000,
                            //             });
							// 			location.reload(true);
                            //             }
                            //             if(response.status ===201){
                            //                 swal({
                            //             icon: "error",
                            //             text: response.message,
                            //             timer:6000,
                            //             });
							// 			location.reload(true);
                            //             }
                            //         },
                            //         error: function (data) {
                            //             swal({
                            //             icon: "error",
                            //             text: "Something went wrong", 
                            //             timer:6000,
                            //             });
                            //         },

                            //     });
                            // });



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
						</script> -->
					</div>
					
				</div>
			</div>
		</div>
						<!-- Bu modal -->

	<?php echo $__env->make('modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>		
	<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	