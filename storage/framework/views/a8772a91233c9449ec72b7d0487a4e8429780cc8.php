<?php echo $__env->make('home.assetss', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<body class="auth-page">
	
    <!-- Wrapper Starts -->
    <div class="limiter">
        <div class="container-form user-auth" >
				<div class="section-form-box">
                            <!-- Logo Starts -->
                            <a href="<?php echo e(url('/')); ?>">
                                <img id="logo" src="<?php echo e($settings->site_address); ?>/cloud/app/images/<?php echo e($settings->logo); ?>" alt="logo">   
                            </a>
                            <!-- Logo Ends -->
						    <!-- Section Title Starts -->
							<h3 class="mb-3">member registration</h3>
						<!-- Section Title Ends -->
						<!-- Form Starts -->
						<form  class="form" method="POST" action="<?php echo e(route('register')); ?>">
                            <?php echo e(csrf_field()); ?>   
                            <!-- Input Field Starts -->
							<div class="form__group">
								<input  class="form__input" id="name" placeholder="Enter your firstname" name="name" type="text" value="<?php echo e(old('name')); ?>" required>
                                <?php if($errors->has('name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                                <label for="name" class="form__label">First Name</label>
                            </div>
							<!-- Input Field Ends -->
	
							<!-- Input Field Starts for lastname -->
							<div class="form__group">
								<input  class="form__input" id="name" placeholder="Enter your Lastname" name="l_name" type="text" value="<?php echo e(old('l_name')); ?>" required >
                            
                                <?php if($errors->has('l_name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('l_name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                                <label for="name" class="form__label">last Name</label>
                            </div>
							<!-- Input Field Ends -->

                             <!-- Input Field Starts -->
                            <div class="form__group">
                                <input class="form__input" id="email" placeholder="Enter your email" name="email" type="email" value="<?php echo e(old('email')); ?>" required>
                            
                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                                <label for="email" class="form__label">Emails</label>
                            </div>
                            
                            <div class="form__group">
								<input  class="form__input" id="phone" placeholder="Enter your number"  name="phone" type="number" value="<?php echo e(old('phone')); ?>" required>
                            
                                <?php if($errors->has('phone')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('phone')); ?></strong>
                                    </span>
                                <?php endif; ?>
                                <label for="phone" class="form__label">Phone number</label>
                            </div>
							
							<!-- Input Field Starts -->
							<div class="form__group">
                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                                <input  class="form__input" id="password" name="password" id="password" placeholder="Enter Password" type="password" required>
                                <label for="password" class="form__label">Enter password</label>
							</div>
                            <!-- Input Field Ends -->
                            <!-- Input Field Starts -->
							<div class="form__group">
								<input  class="form__input" id="password" placeholder="RE-ENTER YOUR PASSWORD" name="password_confirmation" type="password" value="<?php echo e(old('password_confirmation')); ?>" required>
                                <label for="password" class="form__label">Enter password</label>
							</div>
							<!-- Input Field Ends -->
                            <!-- Input Field Starts -->
                            <div class="form__group">
                            <label for="country" class="form__label">Account Type</label>
								<select  class="form__input" name="plan" id="plan">
								<option value="None">Select Account Type</option>
								<?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($plan->id); ?>"><?php echo e($plan->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                
                            </div> <br>
                            
                            <div class="form__group">
								
								<select  class="form__input" name="country" id="country">
								<option value="None">Select country</option>
								<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($country); ?>"><?php echo e($country); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <label for="country" class="form__label">country</label>
                            </div>
							<!-- Submit Form Button Starts -->
							<div class="form__group text-center">
								<button class="btn btn__login" type="submit">Create account</button>
								<p class="text-center">Already a member?  <a href="<?php echo e(route('login')); ?>">Login now</a></p>
                            </div>
                            
							<!-- Submit Form Button Ends -->
                        </form>
                        <!-- Form Ends -->
                        <!-- Copyright Text Starts -->
                        <div class="form__footer text-center">
                            <p class="mt-2">  &copy; Copyright  <?php echo e(date('Y')); ?> &nbsp; <?php echo e($settings->site_name); ?> &nbsp; All Rights Reserved.</p>
                        </div>
				<!-- Copyright Text Ends -->
			</div>
		</div>

    </div>
    <!-- Wrapper Ends -->
</body>

</html>

