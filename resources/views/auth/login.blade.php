@include('home.assetss')

<body class="auth-page">
    <div id="limiter">
    <div class="container-form  user-auth">
                 
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
                    @if($rmessage!="")
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-ok"></i> {{ $rmessage }}
                            </div>
                        </div>
                    </div>
                    @endif
            
            <div class="section-form-box ">
                <a href="{{url('/')}}" class="text-center"><img  
                    src="{{ $settings->site_address}}/cloud/app/images/{{$settings->logo}}" alt="{{$settings->site_name}}"
                     class="text-center"> </a>
                <h3 class="mb-3"> Member Login</h3>

                <div class="section-form-login">
                    <form  class="form" method="POST" action="{{ route('login') }}">
                        {{csrf_field()}}	
                        
                        <!-- Input Fields -->
                        <div class="form__group">
                        @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            <input  class="form__input" name="email" id="email" placeholder="Enter your email" name="email" type="email" value="{{ old('email') }}" required>
                            <label for="email" class="form__label">enter email</label>
                           
                        </div>
                        <div class="form__group" id="show_hide_password">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            <input  class="form__input" id="password" name="password" id="password" placeholder="Enter Password" type="password" required>
                            
                            <label for="password" class="form__label">Password</label>
                        </div>
                        <a href="{{ url('/password/reset') }}"><p class="forget text-right mr-5"> forgot password </p></a>
                        
                        <!-- Submit Form Button Starts -->
                        <div class="form__group text-center">
                            <button class="btn btn__login" type="submit">login</button>
                        </div>
                        <!-- Submit Form Button Ends -->
                        <div class="signup text-center">
                            <a href="{{route('register')}}"><p class=""> Don't have account ? Register </p></a>
                        </div>
                        <div class="form__footer text-center">
                            <p class="mb-4">  &copy; Copyright  {{date('Y')}} &nbsp; {{$settings->site_name}} &nbsp; All Rights Reserved.</p>
                        </div>
                    </form>
                <div>
            </div>
        </div>
    </div>

</body>
</html>
