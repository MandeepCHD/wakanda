<!DOCTYPE html>
<html lang="en">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8" />
    <title>2FA Authentication</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicons -->
    <link href="{{ asset('temp/img/favicon.png')}}" rel="icon">
    <link href="{{ asset('temp/img/apple-touch-icon.png')}}" rel="apple-touch-icon">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS File -->
    <link href="{{ asset ('temp/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Libraries CSS Files -->
        <link href="{{ asset ('temp/lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{ asset ('temp/lib/animate/animate.min.css')}}" rel="stylesheet">
        <link href="{{ asset ('temp/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
        <link href="{{ asset ('temp/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
        <link href="{{asset ('temp/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
        <link href="{{ asset ('temp/lib/jquery/magnific-popup.css')}}" rel="stylesheet">



    <!-- Main Stylesheet File -->
    <link href="{{ asset ('temp/css/frontend_style_blue.css')}}" rel="stylesheet">
    <link href="{{ asset ('temp/css/frontend_style_default.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('temp/css/'.$settings->site_colour.'.css')}}">

</head>

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
                         <h4 class="" >A 2FA authentication code has been sent to your email, kindly check your email and enter code below to continue.</h4>
                    					
						<!-- Section Title Ends -->
						<!-- Form Starts -->
						<form role="form" method="POST" action="{{ route('2fa') }}" class="form">

                            {{ csrf_field() }}
                        
                            <div class="form__group {{ $errors->has('email') ? 'has-error' : '' }}">
                                
                                <input id="2fa" type="text" class="form__input" name="2fa" style="background-color:#fff; color:#222;" placeholder="Enter the code you received here." required autofocus>
                                
                                @if ($errors->has('2fa'))
                                
                                <span class="help-block">
                                
                                <strong>{{ $errors->first('2fa') }}</strong>
                                
                                </span>
                                
                                @endif
                                <label for="2fa" class="form__label">2fa</label>
                            
                            </div>
                        
                            <div class="form__group text-center">
                            
                                <button class="btn btn__login" type="submit">Submit</button><br>
                                <p>Are you stucked here?</p>
                                <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="btn btn__login">
                                Repeat login
                                </a>
                            
                            </div>
                        
                        </form>
                        
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            </form>
                        
						<!-- Form Ends -->
					</div>
				</div>
	
		</div>
    </div>
    <!-- Wrapper Ends -->
</body>

</html>
