
	@include('home/assetss')


<body class="auth-page">
	
    <!-- Wrapper Starts -->
    <div class="limiter">
        <div class="container-form user-auth">

				@if(Session::has('message'))
		        <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-warning"></i> {{ Session::get('message') }}
                        </div>
                    </div>
                </div>
                @endif
			
				<div class="section-form-box">
					<div>
						<!-- Section Title Starts -->
							<h2 class="">Create new password</h2>
						
						<!-- Section Title Ends -->
						<!-- Form Starts -->
						 @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                    <form class="form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}" class="form__input">

                        <div class="form__group {{ $errors->has('email') ? ' has-error' : '' }}">
                            
                            <input id="email" type="email" class="form__input" name="email" value="{{ $email or old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif

                            <label for="email" class="form__label">E-Mail Address</label>
                            
                        </div>

                        <div class="form__group{{ $errors->has('password') ? ' has-error' : '' }}">
                            
                            <input  id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                            <label for="password" class="form__label">Password</label>
                        </div>

                        <div class="form__group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                            <input style="background:transparent; color:#555;" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif

                            <label for="password-confirm" class="form__label">Confirm Password</label>
                        </div>

                        <div class="form__group text-center">
                            <button type="submit" class="btn btn__login">
                                Reset Password
                            </button>
                        </div>
                    </form>
                        <!-- Form Ends -->
                    <div class="form__footer text-center">
                        <p class="mt-2">  &copy; Copyright  {{date('Y')}} &nbsp; {{$settings->site_name}} &nbsp; All Rights Reserved.</p>
                    </div>
			</div>
		</div>
    </div>
    <!-- Wrapper Ends -->
</body>

</html>

