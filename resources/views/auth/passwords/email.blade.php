
	@include('home/assetss')

<body class="auth-page" >
	
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
                        <a href="{{url('/')}}" class="text-center"><img  src="{{ asset('temp/img/'.$settings->logo)}}" alt="{{$settings->site_name}}" class="text-center"> </a>
						<!-- Section Title Starts -->
					    <h3 class="mb-3 mt-2">Password reset</h3>
					
						<!-- Section Title Ends -->
						<!-- Form Starts -->
						 @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                    <form method="POST" action="{{ route('password.email') }}" class="form">
                        {{ csrf_field() }}

                        <div class="form__group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <input  id="email" type="email" class="form__input" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            <label for="email" class="form__label">Email Address</label>
                        </div>

                        <div class="form__group text-center">
                            <button type="submit" class="btn btn__login mb-4">
                                Send Password Reset Link
                            </button>
                        </div>
                    </form>
						<!-- Form Ends -->
                    </div>
                    <div class="form__footer text-center">
                        <p class="mt-2">  &copy; Copyright  {{date('Y')}} &nbsp; {{$settings->site_name}} &nbsp; All Rights Reserved.</p>
                    </div>
				</div>
				
		</div>
    </div>
    <!-- Wrapper Ends -->
</body>

</html>

