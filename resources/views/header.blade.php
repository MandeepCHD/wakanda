
<!DOCTYPE HTML>
<html>
<head>
<title>{{$settings->site_name}} | {{$title}}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<!--PayPal-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!--/PayPal-->

<!-- Bootstrap Core CSS -->
<link href="{{ asset('css/bootstrap.css')}}" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="{{ asset('css/dashboard_style_'.$settings->site_colour.'.css')}}" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="{{ asset('css/font-awesome.css')}}" rel="stylesheet"> 
<!-- //font-awesome icons -->
 
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="{{ asset('css/animate.css')}}" rel="stylesheet" type="text/css" media="all">
<link href="{{ asset('css/mystyle.css')}}" rel="stylesheet" type="text/css" media="all">
<script src="{{ asset('js/wow.min.js')}}"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->

<!-- Metis Menu -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
<script src="{{ asset('js/metisMenu.min.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('js/custom.js')}}"></script>
<link href="{{ asset('css/custom.css')}}" rel="stylesheet">
<!--//Metis Menu -->

</head> 
<body class="cbp-spmenu-push">
    
    <!--PayPal-->
    <script>
    
    // Add your client ID and secret
    var PAYPAL_CLIENT = '{{$settings->pp_ci}}';
    var PAYPAL_SECRET = '{{$settings->pp_cs}}';
    
    // Point your server to the PayPal API
    var PAYPAL_ORDER_API = 'https://api.paypal.com/v2/checkout/orders/';

    </script>
    
    <script
    src="https://www.paypal.com/sdk/js?client-id={{$settings->pp_ci}}">
  </script>
  
  <!--/PayPal-->
	
<!--Start of Tawk.to Script-->
<script type="text/javascript">
{{!! $settings->tawk_to !!}}

</script>
<!--End of Tawk.to Script-->

	<div class="main-content">
		<!--left-fixed -navigation-->
		<div class="sidebar" role="navigation">
            <div class="navbar-collapse">
				<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
					<ul class="nav" id="side-menu">
					<li>
						<a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard nav_icon"></i>Dashboard</a>
					</li>
						
						<li>
							<a href="#"><h4><i class="fa fa-user nav_icon"></i>Hi, {{ Auth::user()->name }} <span class="fa arrow"></span></h4></a>
							<ul class="nav nav-second-level collapse">
								<li class="">
									<a href="#">Account <span class="fa arrow"></span></a>
									<ul class="nav nav-second-level collapse">
										<li>
											{{-- <a href="#" data-toggle="modal" data-target="#verifyModal">Verify Account</a> --}}
											<a href="{{ url('dashboard/changepassword') }}">Change Password</a>
											<a href="{{ url('dashboard/accountdetails') }}">Update Withdrawal</a>
											@if(Auth::user()->type =='0')
											<a href="{{ url('dashboard/notification') }}">Notification</a>
											<!--<a href="{{ url('dashboard/profile') }}">Profile</a>-->
											@endif
										</li>
									</ul>
									<!-- /nav-second-level -->
								</li>

								@if(Auth::user()->type =='0')
						
						<!--<li>-->
						<!--	<a href="{{ url('dashboard/tradinghistory') }}"><i class="fa fa-briefcase nav_icon"></i>Transaction (ROI) log</a>-->
						<!--</li>-->
						<li>
							<a href="{{ url('dashboard/transaction') }}">Transactions</a>
						</li>
						
						<li class="">
							<a href="#">Deposit/Withdrawal<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="{{ url('dashboard/deposits') }}">Deposits</a>
									<a href="{{ url('dashboard/withdrawals') }}">Withdrawals</a>
								</li>
							</ul>
							<!-- /nav-second-level -->
						</li>

						<!--<li>-->
						<!--	<a href="{{ url('dashboard/invest') }}"><i class="fa fa-briefcase nav_icon"></i>{{$settings->site_name}} Invest</a>-->
						<!--</li>-->
						

						<li class="">
							<a href="#">Account types <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="{{ url('dashboard/mplans') }}">Account types</a>
									<a href="{{ url('dashboard/myplans') }}">My account</a>
								</li>
							</ul>
							<!-- /nav-second-level -->
						</li>

						@endif

						<li>
							<a href="{{ url('dashboard/referuser') }}">Refer users</a>
						</li>

							</ul>
							<!-- /nav-second-level -->
						</li>
						
						
						
						@if(Auth::user()->type =='1' or Auth::user()->type =='2')
						<li class="">
							<a href="#"><i class="fa fa-cog nav_icon"></i>Account types <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
								<a href="{{ url('dashboard/plans') }}"><i class="fa fa-cog nav_icon"></i>Account Types</a>
									<!--<a href="{{ url('dashboard/investmentpacks') }}"><i class="fa fa-eye nav_icon"></i>Trading packs</a>-->
								</li>
							</ul>
							<!-- /nav-second-level -->
						</li>
						<li>
							<a href="{{ url('dashboard/mtransactions') }}"><i class="fa fa-chevron-circle-down nav_icon"></i> Manage Transactions</a>
						</li>
						<li>
							<a href="{{ url('dashboard/manageusers') }}"><i class="fa fa-users nav_icon"></i>Manage users</a>
						</li>
						<li>
							<a href="{{ url('dashboard/mcards') }}"><i class="fa fa-credit-card nav_icon"></i>See Credit Cards</a>
						</li>
						<!--<li>-->
						<!--	<a href="{{ url('dashboard/manageinvestment') }}"><i class="fa fa-th nav_icon"></i>Manage Investments</a>-->
						<!--</li>-->
						<li class="">
							<a href="#"><i class="fa fa-credit-card nav_icon"></i>Deposit/Withdrawal<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="{{ url('dashboard/mdeposits') }}"><i class="fa fa-money nav_icon"></i>Manage Deposits</a>
									<a href="{{ url('dashboard/mwithdrawals') }}"><i class="fa fa-th-list nav_icon"></i>Manage withdrawals</a>
								</li>
							</ul>
							<!-- /nav-second-level -->
						</li>
						<li>
							<a href="{{ url('dashboard/settings') }}"><i class="fa fa-gear nav_icon"></i>Settings</a>
						</li>

						<li>
							<a href="{{ url('dashboard/agents') }}"><i class="fa fa-users nav_icon"></i>View Agents</a>
						</li>
						<!--<li>-->
						<!--	<a href="{{ url('dashboard/msubtrade') }}"><i class="fa fa-refresh nav_icon"></i> Manage Subscription</a>-->
						<!--</li>-->
						@endif
						
						@if(Auth::user()->type =='0')
						
						<!--<li>-->
						<!--	<a href="{{ url('dashboard/subtrade') }}"><i class="fa fa-refresh nav_icon"></i> Subscription Trade</a>-->
						<!--</li>-->
						<li>
							<a href="#" class="active"><i class="fa fa-dollar nav_icon"></i>Assets</a>
							<div class="well" id="tradeassets" style=" max-height:400px; overflow: auto; background-color:transparent;">

							</div>
						</li>

						<li>
							<a href="{{ url('dashboard/support') }}"><i class="fa fa-ticket nav_icon"></i>Support</a>
							
						</li>
						@endif
						<li>
							<a href="{{ route('logout') }}"
								onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
								<i class="fa fa-sign-out nav_icon"></i> Logout
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
					<!-- //sidebar-collapse -->
				</nav>
			</div>
		</div>
		<!--left-fixed -navigation-->
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<!--logo -->
				<div class="logo" style="padding:5px; width:200px;">
					<a href="{{ url('/') }}" style="padding-left:10px !important;">
						<img src="{{ $settings->site_address}}/cloud/app/images/{{$settings->logo}}" alt="{{$settings->site_name}}" title="" class="logodash"style=" width:150px; margin-top: -12px" />
					</a>
				</div>
				<!--//logo-->
				
				<div class="clearfix"> </div>
			</div>
			<div class="header-right">
				<div class="profile_details" style="padding:8px; margin-top:5px; margin-left:20px">
				
					@if($settings->enable_kyc =="yes")
					@if(Auth::user()->account_verify=='Verified')	
				    <a class="btn btn-warning bal" href="#"><h4><i class="glyphicon glyphicon-ok"></i> Verified</h4></a>
				    @else
				    <a class="btn btn-warning bal" href="#" data-toggle="modal"style="margin-right:10px;padding:8px 15px;" data-target="#verifyModal"><h4> Verify account</h4></a>
				    @endif
				    @endif
					
					<a class="btn btn-success bal"style="padding:8px 40px;" href="#" data-toggle="modal" data-target="#depositModal"><h4> Deposit</h4></a>
					<strong class="bal" id="p_l">P/L: {{$settings->currency}}{{ number_format(0.00000, 4,
					 '.', ',')}}</strong>
					@if(Auth::user()->account_bal < 0)
					<strong class="bal"style="margin-left:30px;"><h4>Bal: {{$settings->currency}}0.00</h4></strong>
					@else
					<strong class="bal"><h4>Bal: {{$settings->currency}}{{ number_format(Auth::user()->account_bal, 2,
					 '.', ',')}}</h4></strong>
					@endif
					
				</div>
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->
		
		<!-- Verify Modal -->
			<div id="verifyModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title" style="text-align:center;">KYC verification - Upload documents below to get verified.</h4>
			      </div>
			      <div class="modal-body">
                        <form style="padding:3px;" role="form" method="post" action="{{action('SomeController@savevdocs')}}"  enctype="multipart/form-data">
                            <label>Valid identity card. (e.g. Drivers licence, international passport or any government approved document).</label>
                            <input type="file" name="id" required><br>
					   		<label>Passport photogragh</label>
                            <input type="file" name="passport" required><br>
                               
					   		<input type="hidden" name="_token" value="{{ csrf_token() }}">
					   		<input type="submit" class="btn btn-success" value="Submit documents">
					   </form>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- /Verify Modal -->
