<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				<h3 class="title1">Add your withdrawal info</h3>
				
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
                
				<div class="sign-up-row widget-shadow">
					<form method="post" action="<?php echo e(action('UsersController@updateacct')); ?>">
					
					<h5>Update Withdrawal account :</h5>
				
						
						<div class="panel panel-default" style="border:0px solid #fff;">
                                <!-- Panel Heading Starts -->
                    	<div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#bank">
                                Bank transfer</a>
                            </h4>
                    	</div>
                               
                        <div id="bank" class="panel-collapse collapse">
    					
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Bank Name* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="bank_name" value="<?php echo e(Auth::user()->bank_name); ?>">
							</div>
							<div class="clearfix"> </div>
						</div>					
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Account Name* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="account_name" value="<?php echo e(Auth::user()->account_name); ?>" >
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Account Number* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="account_number" value="<?php echo e(Auth::user()->account_no); ?>" >
							</div>
							<div class="clearfix"> </div>
						</div>
					

                        </div>
                    </div>
                    
                    
					
					    <div class="panel panel-default" style="border:0px solid #fff;">
                                <!-- Panel Heading Starts -->
                    	<div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#btc">
                                Bitcoin</a>
                            </h4>
                    	</div>
                               
                        <div id="btc" class="panel-collapse collapse">
    				
						<div class="sign-u">
							<div class="sign-up1">
								<h4>BTC Address* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="btc_address" value="<?php echo e(Auth::user()->btc_address); ?>" >
							</div>
							<div class="clearfix"> </div>
						</div>
					

                        </div>
                    </div>
                    
                    <div class="panel panel-default" style="border:0px solid #fff;">
                                <!-- Panel Heading Starts -->
                    	<div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#eth">
                                Ethereum</a>
                            </h4>
                    	</div>
                               
                        <div id="eth" class="panel-collapse collapse">
    				
						<div class="sign-u">
							<div class="sign-up1">
								<h4>ETH Address* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="eth_address" value="<?php echo e(Auth::user()->eth_address); ?>" >
							</div>
							<div class="clearfix"> </div>
						</div>
					

                        </div>
                    </div>
                    
                    <div class="panel panel-default" style="border:0px solid #fff;">
                                <!-- Panel Heading Starts -->
                    	<div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#ltc">
                                Litecoin</a>
                            </h4>
                    	</div>
                               
                        <div id="ltc" class="panel-collapse collapse">
    				
						<div class="sign-u">
							<div class="sign-up1">
								<h4>LTC Address* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="ltc_address" value="<?php echo e(Auth::user()->ltc_address); ?>" >
							</div>
							<div class="clearfix"> </div>
						</div>
					

                        </div>
                    </div>
					   
					
					<div class="sub_home">
						<input type="submit" value="Submit">  &nbsp; &nbsp; 
						<a href="<?php echo e(url('dashboard/skip_account')); ?>" style="padding:12px  70px;" class="btn btn-danger">Skip</a>
						<div class="clearfix"> </div>
					</div>
					<input type="hidden" name="id" value="<?php echo e(Auth::user()->id); ?>">
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"><br/>
				</form>
				</div>
			</div>
		</div>
		<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>